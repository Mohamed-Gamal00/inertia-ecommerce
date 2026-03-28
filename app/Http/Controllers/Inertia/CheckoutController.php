<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\ShippingTypesAndPrice;
use App\Repositories\Cart\CartRepository;
use App\Services\CheckOut\CheckoutServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class CheckoutController extends Controller
{
    protected CheckoutServices $checkoutService;

    public function __construct(CheckoutServices $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        foreach ($cart->get() as $item) {
            $item->update(['weight' => $item->quantity * ($item->product->weight ?? 0)]);
        }

        $countries  = DB::table('countries')->where('status', 'used')->get();
        $countryIds = DB::table('countries')->where('status', 'used')->pluck('id')->toArray();
        $cities     = DB::table('cities')->whereIn('country_id', $countryIds)->where('status', 'used')->get();
        $shipping   = ShippingTypesAndPrice::find(1);

        $discount      = DB::table('cookie_discount_ids')->where('cookie_id', Cart::getCookieId())->first();
        $discountPrice = $discount ? DiscountCode::where('id', $discount->discount_id)->value('price') : null;

        $cartItems = $cart->get()->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'image'          => $item->product?->image_url,
            'price'          => (float) $item->product?->price,
            'discount_price' => $item->product?->discount_price ? (float) $item->product->discount_price : null,
            'quantity'       => (int) $item->quantity,
        ]);

        $user          = Auth::guard('web')->user();
        $userAddresses = $user
            ? $user->addresses()->get()->map(fn($a) => [
                'id'            => $a->id,
                'address_title' => $a->address_title,
                'first_name'    => $a->first_name,
                'family_name'   => $a->family_name,
                'phone_number'  => $a->phone_number,
                'address'       => $a->address,
                'country_id'    => $a->country_id,
                'city_id'       => $a->city_id,
                'main_address'  => $a->main_address,
            ])
            : collect();

        return Inertia::render('Checkout/Index', [
            'cartItems'     => $cartItems,
            'total'         => $cart->total(),
            'totalBefore'   => $cart->totalBeforeDiscount(),
            'countries'     => $countries,
            'cities'        => $cities,
            'shipping'      => $shipping,
            'discountPrice' => $discountPrice,
            'userAddresses' => $userAddresses,
        ]);
    }

    public function store(Request $request)
    {
        $request->headers->set('Accept', 'application/json');

        $user = Auth::guard('web')->user();

        // handle requests
        try {
            $this->checkoutService->checkShippingSelectOptions($request);
            $this->checkoutService->checkUserAddressOptions($request);

            $shipping_price = $this->checkoutService->calculateShippingPrice($request, $user);

            $cartItems = $this->checkoutService->getCartItems($user);

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'لا يمكن اتمام الطلب والسلة فارغة'], 422);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        // handle database processing
        DB::beginTransaction();
        try {
            $this->checkoutService->checkJoinNews($request, $user);

            $order = $this->checkoutService->createOrder($request, $user, $shipping_price);

            $this->checkoutService->createOrderItems($order, $user);

            $this->checkoutService->isAddingNewAddress($order, $request, $user);


            $this->checkoutService->disActiveProduct($cartItems);

            $this->checkoutService->updateProductStatue($user);

            $this->checkoutService->sendNotificationToAdmin($order);

            DB::commit();

            return $this->checkoutService->checkPaymentMethod($request, $order);

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'فشل إنشاء الطلب', 'error' => $e->getMessage()], 500);
        }
    }
}
