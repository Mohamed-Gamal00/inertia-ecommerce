<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartSystemTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Reset the per-request cookie cache between tests so each test
        // starts with a clean slate.
        Cart::resetCookieCache();
    }

    /** Helper: create and authenticate a user. */
    private function createUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'password' => bcrypt('password'),
        ], $overrides));
    }

    /** Helper: create a product with the given stock. */
    private function createProduct(int $stock = 100, array $overrides = []): Product
    {
        return Product::factory()->create(array_merge([
            'quantity' => $stock,
        ], $overrides));
    }

    /** Helper: set a guest cookie ID for the current test request cycle. */
    private function setGuestCookie(string $cookieId): void
    {
        Cart::setCookieId($cookieId);
    }

    /** Helper: insert a cart row directly (bypassing Eloquent hooks/scope). */
    private function insertCartItem(array $data): void
    {
        DB::table('carts')->insert(array_merge([
            'id'         => Str::uuid()->toString(),
            'status'     => 0,
            'quantity'   => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ], $data));
    }

    // ===================================================================
    // 1. A new guest adds a product to the cart
    // ===================================================================
    public function test_new_guest_can_add_product_to_cart(): void
    {
        $product = $this->createProduct(10);

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $product->id)
            ->assertJsonPath('items.0.quantity', 2);

        // Verify the row in the DB belongs to a guest (user_id is null)
        $cartItem = Cart::withoutGlobalScope('cookie_id')->first();
        $this->assertNotNull($cartItem);
        $this->assertNull($cartItem->user_id);
        $this->assertSame(2, (int) $cartItem->quantity);
    }

    // ===================================================================
    // 2. A returning guest reuses the same cookie
    // ===================================================================
    public function test_returning_guest_reuses_same_cookie(): void
    {
        $cookieId = 'guest-' . Str::uuid();
        $this->setGuestCookie($cookieId);

        $product = $this->createProduct(10);

        // First request — add a product
        $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 1,
        ])->assertStatus(200);

        // The cookie_id used must be the one we set
        $cartItem = Cart::withoutGlobalScope('cookie_id')->first();
        $this->assertSame($cookieId, $cartItem->cookie_id);

        // Second request — the same cookie should see the same item
        $response = $this->getJson('/cart');

        $response->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $product->id);
    }

    // ===================================================================
    // 3. Adding the same product multiple times updates quantity, no duplicates
    // ===================================================================
    public function test_adding_same_product_updates_quantity_without_duplicates(): void
    {
        $this->setGuestCookie('guest-dup');
        $product = $this->createProduct(20);

        // Add the same product three times
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 2]);
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 3]);
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 1]);

        // Should have exactly one cart row with quantity 6
        $this->getJson('/cart')
            ->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.quantity', 6);

        $dbCount = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-dup')
            ->where('status', 0)
            ->count();
        $this->assertSame(1, $dbCount, 'There should be exactly one cart row, not duplicates');
    }

    // ===================================================================
    // 4. A guest can only update and delete their own cart items
    // ===================================================================
    public function test_guest_can_only_update_and_delete_own_items(): void
    {
        $productA = $this->createProduct(50);
        $productB = $this->createProduct(50);

        // Guest A adds product A
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-A');
        $this->postJson('/cart/add', ['product_id' => $productA->id, 'quantity' => 1]);

        $guestAItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-A')
            ->where('status', 0)
            ->first();

        // Guest B adds product B
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-B');
        $this->postJson('/cart/add', ['product_id' => $productB->id, 'quantity' => 1]);

        $guestBItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-B')
            ->where('status', 0)
            ->first();

        // Guest A tries to update Guest B's item — should NOT change it
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-A');
        $this->patchJson("/cart/{$guestBItem->id}", ['quantity' => 99]);

        $guestBItem->refresh();
        $this->assertSame(1, (int) $guestBItem->quantity, 'Guest A must not be able to update Guest B\'s cart item');

        // Guest A tries to delete Guest B's item — should NOT remove it
        $this->deleteJson("/cart/{$guestBItem->id}");

        $guestBItem->refresh();
        $this->assertSame(0, (int) $guestBItem->status, 'Guest A must not be able to delete Guest B\'s cart item');

        // Guest A can update their own item
        $this->patchJson("/cart/{$guestAItem->id}", ['quantity' => 5])
            ->assertStatus(200);

        $guestAItem->refresh();
        $this->assertSame(5, (int) $guestAItem->quantity);

        // Guest A can delete their own item
        $this->deleteJson("/cart/{$guestAItem->id}")
            ->assertStatus(200);

        $guestAItem->refresh();
        $this->assertSame(1, (int) $guestAItem->status);
    }

    // ===================================================================
    // 5. A guest logs in and their cart is merged correctly
    // ===================================================================
    public function test_guest_cart_is_merged_on_login(): void
    {
        $productA = $this->createProduct(50);
        $productB = $this->createProduct(50);

        $user = $this->createUser();

        // Pre-populate the user's existing cart with product A (qty 1)
        $this->insertCartItem([
            'cookie_id'   => 'user-existing',
            'product_id'  => $productA->id,
            'user_id'     => $user->id,
            'quantity'    => 1,
        ]);

        // Guest adds product A (qty 2) and product B (qty 1)
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-merge');
        $this->postJson('/cart/add', ['product_id' => $productA->id, 'quantity' => 2]);
        $this->postJson('/cart/add', ['product_id' => $productB->id, 'quantity' => 1]);

        // Guest logs in
        $response = $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(302); // redirect

        // After login, the user's cart should have:
        // - Product A: merged qty = 1 + 2 = 3
        // - Product B: transferred qty = 1
        $userItems = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->get();

        $productAItem = $userItems->firstWhere('product_id', $productA->id);
        $productBItem = $userItems->firstWhere('product_id', $productB->id);

        $this->assertNotNull($productAItem, 'Product A should be in the user\'s cart');
        $this->assertSame(3, (int) $productAItem->quantity, 'Product A quantity should be merged (1 + 2 = 3)');

        $this->assertNotNull($productBItem, 'Product B should be transferred to the user\'s cart');
        $this->assertSame(1, (int) $productBItem->quantity);

        // The old guest items should be gone (marked status=1 or reassigned)
        $remainingGuestItems = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-merge')
            ->whereNull('user_id')
            ->where('status', 0)
            ->count();
        $this->assertSame(0, $remainingGuestItems, 'No active guest items should remain');
    }

    // ===================================================================
    // 6. A user logs out and their cart is transferred to a new guest identity
    // ===================================================================
    public function test_cart_transferred_to_new_guest_on_logout(): void
    {
        $product = $this->createProduct(50);
        $user = $this->createUser();

        // Log in and add items to the user's cart
        $this->actingAs($user, 'web');
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 3])
            ->assertStatus(200);

        // Verify the user has the item
        $this->getJson('/cart')
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.quantity', 3);

        // Capture the user's cart item ID
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->first();
        $this->assertNotNull($cartItem);

        // Log out
        $response = $this->postJson('/logout');
        $response->assertStatus(302);

        // After logout, a new guest cookie should be set and the item transferred
        $transferredItem = Cart::withoutGlobalScope('cookie_id')
            ->where('id', $cartItem->id)
            ->first();

        $this->assertNotNull($transferredItem, 'Cart item should still exist');
        $this->assertNull($transferredItem->user_id, 'user_id should be null after transfer');
        $this->assertSame(0, (int) $transferredItem->status, 'Item should still be active');
        $this->assertSame(3, (int) $transferredItem->quantity, 'Quantity should be preserved');

        // The new guest cookie should be able to access the cart
        $newCookieId = Cart::getCookieId();
        $this->assertSame($transferredItem->cookie_id, $newCookieId, 'Transferred item should use the new cookie_id');

        // GET /cart with the new cookie should show the items
        $response = $this->getJson('/cart');
        $response->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $product->id)
            ->assertJsonPath('items.0.quantity', 3);
    }

    // ===================================================================
    // 7. The previous user cart cannot be accessed using the old guest identity
    // ===================================================================
    public function test_old_guest_identity_cannot_access_transferred_cart(): void
    {
        $product = $this->createProduct(50);
        $user = $this->createUser();

        // Log in and add items
        $this->actingAs($user, 'web');
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 2]);

        // Capture the cookie_id that was on the item before logout
        $itemBeforeLogout = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->first();
        $oldCookieId = $itemBeforeLogout->cookie_id;

        // Log out — this transfers the cart to a new guest identity
        $this->postJson('/logout');

        // Simulate the old guest identity by setting the old cookie_id
        Cart::resetCookieCache();
        $this->setGuestCookie($oldCookieId);

        // The old guest identity should NOT see any cart items
        $response = $this->getJson('/cart');
        $response->assertStatus(200)
            ->assertJsonPath('count', 0);

        // Verify in the DB: no active items with the old cookie_id
        $oldItems = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', $oldCookieId)
            ->where('status', 0)
            ->count();
        $this->assertSame(0, $oldItems, 'Old guest identity must not have access to the transferred cart');
    }

    // ===================================================================
    // 8. One authenticated user cannot access another user's cart
    // ===================================================================
    public function test_authenticated_user_cannot_access_another_users_cart(): void
    {
        $productA = $this->createProduct(50);
        $productB = $this->createProduct(50);

        $userA = $this->createUser();
        $userB = $this->createUser();

        // User A adds product A
        $this->actingAs($userA, 'web');
        $this->postJson('/cart/add', ['product_id' => $productA->id, 'quantity' => 2]);

        // User B adds product B
        $this->actingAs($userB, 'web');
        $this->postJson('/cart/add', ['product_id' => $productB->id, 'quantity' => 1]);

        // User A should only see product A
        $this->actingAs($userA, 'web');
        $this->getJson('/cart')
            ->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $productA->id);

        // User B should only see product B
        $this->actingAs($userB, 'web');
        $this->getJson('/cart')
            ->assertStatus(200)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $productB->id);

        // User A cannot delete User B's item
        $userBItem = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $userB->id)
            ->where('status', 0)
            ->first();

        $this->actingAs($userA, 'web');
        $this->deleteJson("/cart/{$userBItem->id}");

        $userBItem->refresh();
        $this->assertSame(0, (int) $userBItem->status, 'User A must not be able to delete User B\'s item');
    }

    // ===================================================================
    // 9. Stock limits are respected during cart updates and merging
    // ===================================================================
    public function test_stock_limits_respected_during_update(): void
    {
        $this->setGuestCookie('guest-stock');
        $product = $this->createProduct(5);

        // Add 3 units (OK)
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 3])
            ->assertStatus(200);

        // Try to update to 10 (exceeds stock of 5) — should be rejected
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-stock')
            ->where('status', 0)
            ->first();

        $response = $this->patchJson("/cart/{$cartItem->id}", ['quantity' => 10]);
        $response->assertStatus(422);

        // Quantity should remain unchanged
        $cartItem->refresh();
        $this->assertSame(3, (int) $cartItem->quantity, 'Quantity should not exceed stock');
    }

    public function test_stock_limits_respected_during_merge(): void
    {
        $product = $this->createProduct(5);
        $user = $this->createUser();

        // User already has 3 units of the product
        $this->insertCartItem([
            'cookie_id'   => 'user-cart',
            'product_id'  => $product->id,
            'user_id'     => $user->id,
            'quantity'    => 3,
        ]);

        // Guest has 4 units of the same product
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-stock-merge');
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 4]);

        // Guest logs in — merge should cap at stock (5)
        $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ])->assertStatus(302);

        $mergedItem = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('status', 0)
            ->first();

        $this->assertNotNull($mergedItem);
        $this->assertSame(5, (int) $mergedItem->quantity, 'Merged quantity should be capped at stock (5), not 7');
    }

    public function test_stock_limits_respected_during_add(): void
    {
        $this->setGuestCookie('guest-stock-add');
        $product = $this->createProduct(5);

        // Add 3 (OK)
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 3])
            ->assertStatus(200);

        // Add 3 more (total 6 > stock 5) — should be rejected
        $response = $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertStatus(422);

        // Quantity should remain 3
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', 'guest-stock-add')
            ->where('status', 0)
            ->first();
        $this->assertSame(3, (int) $cartItem->quantity, 'Quantity should not exceed stock');
    }

    // ===================================================================
    // 10. Guest and authenticated checkout use the correct cart
    // ===================================================================
    public function test_each_user_sees_only_their_own_cart(): void
    {
        $productA = $this->createProduct(50);
        $productB = $this->createProduct(50);
        $productC = $this->createProduct(50);

        $userA = $this->createUser();
        $userB = $this->createUser();

        // User A adds product A
        $this->actingAs($userA, 'web');
        $this->postJson('/cart/add', ['product_id' => $productA->id, 'quantity' => 2]);

        // User B adds product B
        $this->actingAs($userB, 'web');
        $this->postJson('/cart/add', ['product_id' => $productB->id, 'quantity' => 1]);

        // Guest adds product C
        Auth::guard('web')->logout();
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-checkout');
        $this->postJson('/cart/add', ['product_id' => $productC->id, 'quantity' => 3]);

        // User A sees only product A
        $this->actingAs($userA, 'web');
        $this->getJson('/cart')
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $productA->id);

        // User B sees only product B
        $this->actingAs($userB, 'web');
        $this->getJson('/cart')
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $productB->id);

        // Guest sees only product C
        Auth::guard('web')->logout();
        Cart::resetCookieCache();
        $this->setGuestCookie('guest-checkout');
        $this->getJson('/cart')
            ->assertJsonPath('count', 1)
            ->assertJsonPath('items.0.product_id', $productC->id);
    }

    public function test_checkout_uses_correct_cart_for_user(): void
    {
        $productA = $this->createProduct(50);
        $productB = $this->createProduct(50);

        $userA = $this->createUser();
        $userB = $this->createUser();

        // User A adds product A
        $this->actingAs($userA, 'web');
        $this->postJson('/cart/add', ['product_id' => $productA->id, 'quantity' => 1]);

        // User B adds product B
        $this->actingAs($userB, 'web');
        $this->postJson('/cart/add', ['product_id' => $productB->id, 'quantity' => 1]);

        // Verify via the checkout controller's getCartItems logic
        // (which bypasses the scope and filters by user_id)
        $userAItems = app(\App\Services\CheckOut\CheckoutServices::class)
            ->getCartItems($userA);
        $this->assertCount(1, $userAItems);
        $this->assertSame($productA->id, $userAItems->first()->product_id);

        $userBItems = app(\App\Services\CheckOut\CheckoutServices::class)
            ->getCartItems($userB);
        $this->assertCount(1, $userBItems);
        $this->assertSame($productB->id, $userBItems->first()->product_id);
    }
}
