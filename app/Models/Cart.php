<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Guest as GuestModel;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    use HasFactory;

    /** Cookie name used to identify guest carts. */
    public const COOKIE_NAME = 'cart_id';

    /** Cookie lifetime in minutes (30 days). */
    public const COOKIE_MINUTES = 30 * 24 * 60;

    public $incrementing = false;

    protected $fillable = [
        'cookie_id', 'status', 'color_id', 'product_id', 'user_id', 'guest_id', 'quantity', 'weight', 'discounted_price'
    ];

    /** @var string|null Cached cookie id for the current request. */
    protected static ?string $cachedCookieId = null;

    protected $casts = [
        'quantity'          => 'integer',
        'status'            => 'integer',
        'weight'            => 'decimal:2',
        'discounted_price'  => 'decimal:2',
    ];

    protected static function booted()
    {
        /*
         * Global scope — restricts every Cart query to the *current* cart owner.
         *
         * Authenticated users are identified exclusively by user_id.
         * Guests are identified by the cart_id cookie (cookie_id column).
         *
         * This ensures users can never accidentally query another user's cart
         * and guests can never access another guest's cart.
         */
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            if (Auth::guard('web')->check()) {
                $builder->where('user_id', '=', Auth::guard('web')->id());
            } else {
                $builder->where('cookie_id', '=', Cart::getCookieId());
            }
        });

        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid()->toString();

            // Assign user_id automatically for authenticated web users
            if (!$cart->user_id && Auth::guard('web')->check()) {
                $cart->user_id = Auth::guard('web')->id();
            }

            // cookie_id is NOT NULL in the schema — always set it.
            if (str_contains(request()->path(), 'api')) {
                $cart->cookie_id = $cart->cookie_id ?: Cart::getCookieIdApi();
            } else {
                $cart->cookie_id = $cart->cookie_id ?: Cart::getCookieId();
            }
        });
    }

    /**
     * Resolve the guest cart identifier from the cart_id cookie.
     *
     * The UUID is cached for the duration of the request so that multiple
     * calls within the same request always return the same value — a fresh
     * UUID is never generated more than once per request.
     */
    public static function getCookieId(): string
    {
        if (static::$cachedCookieId) {
            return static::$cachedCookieId;
        }

        $cookie_id = Cookie::get(static::COOKIE_NAME);

        if (!$cookie_id) {
            $cookie_id = Str::uuid()->toString();
            Cookie::queue(
                static::COOKIE_NAME,
                $cookie_id,
                static::COOKIE_MINUTES,
                '/',                                    // path
                null,                                   // domain
                config('app.env') === 'production',     // secure
                true,                                   // httpOnly
                false,                                  // raw
                'lax'                                   // sameSite
            );
        }

        static::$cachedCookieId = $cookie_id;

        return $cookie_id;
    }

    /**
     * Override the cached cookie id — used during logout to set a new
     * guest identity before the response cookie reaches the browser.
     */
    public static function setCookieId(?string $id): void
    {
        static::$cachedCookieId = $id;
    }

    /**
     * Generate a fresh guest UUID and queue it as the cart_id cookie.
     * Returns the new UUID so callers can transfer cart items to it.
     */
    public static function generateNewGuestCookie(): string
    {
        $newId = Str::uuid()->toString();
        static::setCookieId($newId);
        Cookie::queue(
            static::COOKIE_NAME,
            $newId,
            static::COOKIE_MINUTES,
            '/',
            null,
            config('app.env') === 'production',
            true,
            false,
            'lax'
        );
        return $newId;
    }

    /**
     * Reset the request-level cookie cache.
     * Useful in tests to simulate a fresh request.
     */
    public static function resetCookieCache(): void
    {
        static::$cachedCookieId = null;
    }

    public static function getCookieIdApi()
    {
        $request = request();
        if (request()->user()) {
            $cookie_id = Cart::where('status', 0)->where('user_id', $request->user()->id)->withoutGlobalScope('cookie_id')->value('cookie_id');
        } else {
            $cookie_id = Cart::where('status', 0)->where('guest_id', $request->guest_id)->withoutGlobalScope('cookie_id')->value('cookie_id');
        }
        if (!$cookie_id) {
            $cookie_id = Str::uuid()->toString();
        }
        return $cookie_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function guest()
    {
        return $this->belongsTo(GuestModel::class, 'guest_id', 'id');
    }
}
