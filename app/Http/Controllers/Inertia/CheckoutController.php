<?php

namespace App\Http\Controllers\Inertia;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\City;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SendNewsToUser;
use App\Models\ShippingTypesAndPrice;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\OrderCreatedEmailAdmin;
use App\Notifications\OrderCreatedNotification;
use App\Notifications\SendOrderCreatedToUser;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function store(Request $request, CartRepository $cart, Order $order)
    {
        dd('test');
        // Ensure validation errors return JSON for axios
        $request->headers->set('Accept', 'application/json');

        // billing for guest & shipping for authenticated user
        if (Auth::guard('web')->check()) {
            // Only require user_address if not adding a new address
            if (!isset($request->addr['shipping'])) {
                $request->validate([
                    'user_address' => 'required',
                    'terms'        => 'required',
                ], [
                    'user_address.required' => 'برجاء اختيار عنوان او اضافة عنوان جديد',
                ]);
            } else {
                $request->validate(['terms' => 'required']);
            }
        }

        if (isset($request->addr['shipping']) && $request->user_address == 'add_address') {
            $request->validate([
                "addr.shipping.first_name" => ['required', 'max:255'],
                "addr.shipping.last_name" => ['required', 'max:255'],
                "addr.shipping.phone_number" => ['required', 'numeric'],
                "addr.shipping.address" => ['required', 'string', 'max:255'],
                "addr.shipping.country_id" => ['nullable', 'exists:countries,id'],
                "addr.shipping.city_id" => ['nullable', 'exists:cities,id'],
                'note' => 'nullable|string',
                'shipping_price' => 'nullable',
                'country_code' => 'nullable|exists:countries,id',
                'terms' => 'required'


            ]);
        } elseif (isset($request->addr['billing'])) {
            $request->validate([
                "addr.billing.first_name" => ['required', 'max:255'],
                "addr.billing.last_name" => ['required', 'max:255'],
                "addr.billing.phone_number" => ['required', 'numeric'],
                "addr.billing.address" => ['required', 'string', 'max:255'],
                "addr.billing.country_id" => ['required', 'exists:countries,id'],
                "addr.billing.city_id" => ['required', 'exists:cities,id'],
                'note' => 'nullable|string',
                'shipping_price' => 'nullable',
                "guest_email" => 'required|email',
                'country_code' => 'nullable|exists:countries,id',
                'terms' => 'required'
            ]);

        }


//        dd($request->all());


        $items = $cart->get();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'السلة فارغة'], 422);
        }

        if ($request->payment_method == 'card_payment') {

            DB::beginTransaction();
            try {

                // store email to News if use checked join_news radio
                if ($request->join_news) {
                    $email = Auth::guard('web')->check() ? Auth::guard('web')->user()->email : $request->guest_email;

                    $existingEmail = SendNewsToUser::where('subscription_email', $email)->first();

                    if (!$existingEmail) {
                        SendNewsToUser::create(['subscription_email' => $email]);
                    }
                }

                $order = Order::create([
                    'user_id' => Auth::guard('web')->user()->id ?? null,
                    'payment_method' => $request->payment_method,
                    'order_status_id' => OrderStatus::select('id')->where('default_status', true)->first()->id,
                    'note' => $request->note,
                    'shipping_price' => request()->shipping == 'noShipping' ? 0 : (float)($request->shipping_price ?? 0),
                    'totalBeforeDiscount' => $cart->totalBeforeDiscount(),
                    'total_price' => $cart->total(),
                    'cookie_id' => Auth::guard('web')->check() ? null : Cart::getCookieId()
                ]);


                // dd($items);
                /* items of cart items */
                foreach ($items as $cart_items) {
                    // العناصر اللي في السلة هعمل بيها اوردر
                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart_items->product_id,
                        'product_name' => $cart_items->product->name, // product is the relation
                        'price' => $cart_items->product->price * $cart_items->quantity, // product is the relation
                        'quantity' => $cart_items->quantity,
                        //'color' => $cart_items->color_id
                    ]);

                    $product = Product::where('id', $item->product_id)->first();
                    $decrementQuantity = Product::where('id', $item->product_id)->update([
                        'quantity' => $product->quantity - $item->quantity
                    ]);


                    if (!empty($request->post('addr')['billing']['first_name'])) {

                        foreach ($request->post('addr') as $type => $address) {
                            $address['type'] = $type;
                            $address['email'] = Auth::guard('web')->user()->email ?? $request->guest_email;
                            $order->addresses()->create($address);
                        }
                    } elseif ($request->user_address) {

                        $UserAddress = UserAddress::where('id', $request->user_address)
                            ->first();
                        $address['type'] = 'shipping';
                        $address['first_name'] = $UserAddress->first_name ?? $request->addr['shipping']['first_name'];
                        $address['last_name'] = $UserAddress->family_name ?? $request->addr['shipping']['last_name'];
                        $address['phone_number'] = $UserAddress->phone_number ?? $request->addr['shipping']['phone_number'];
                        $address['country_id'] = $UserAddress->country_id ?? $request->addr['shipping']['country_id'];
                        $address['city_id'] = $UserAddress->city_id ?? $request->addr['shipping']['city_id'];
                        $address['address'] = $UserAddress->address ?? $request->addr['shipping']['address'];
                        $address['email'] = Auth::guard('web')->user()->email;

                        $order->addresses()->create($address);
                    }
                }

                foreach ($items as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    if ($product->quantity == 1) {
                        $product->update([
                            'status' => 'archived'
                        ]);
                    }
                }


                $admins = Admin::all();
                Notification::send($admins, new OrderCreatedNotification($order));

                $validAdmins = $admins->filter(function ($admin) {
                    return filter_var($admin->email, FILTER_VALIDATE_EMAIL);
                });
                foreach ($validAdmins as $admin) {
                    try {
                        Notification::route('mail', $admin->email)
                            ->notify(new OrderCreatedEmailAdmin($order));
                    } catch (\Exception $e) {
                    }
                }

                $user = $order->addresses->first();

                // $user->notify(new SendOrderCreatedToUser($order));


                $cart->empty();

                DB::commit();
                return response()->json([
                    'redirect' => route('user.payment', ['order_number' => $order['number']])
                ]);
            } catch (Throwable $e) {
                DB::rollBack();
                throw $e;
            }

        } //
        else {
            DB::beginTransaction();
            try {

                // store email to News if use checked join_news radio
                if ($request->join_news) {
                    $email = Auth::guard('web')->check() ? Auth::guard('web')->user()->email : $request->guest_email;

                    $existingEmail = SendNewsToUser::where('subscription_email', $email)->first();

                    if (!$existingEmail) {
                        SendNewsToUser::create(['subscription_email' => $email]);
                    }
                }


                $order = Order::create([
                    'user_id' => Auth::guard('web')->user()->id ?? null,
                    'payment_method' => $request->payment_method, // cash on deleviry
                    'order_status_id' => OrderStatus::select('id')->where('default_status', true)->first()->id,
                    'note' => $request->note,
                    'shipping_price' => request()->shipping == 'noShipping' ? 0 : (float)($request->shipping_price ?? 0),
                    'totalBeforeDiscount' => $cart->totalBeforeDiscount(),
                    'total_price' => $cart->total(),
                    'cookie_id' => Auth::guard('web')->check() ? null : Cart::getCookieId()
                ]);


                // dd($items);
                /* items of cart items */
                foreach ($items as $cart_items) {
                    // العناصر اللي في السلة هعمل بيها اوردر
                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart_items->product_id,
                        'product_name' => $cart_items->product->name, // product is the relation
                        'price' => $cart_items->product->price * $cart_items->quantity, // product is the relation
                        'quantity' => $cart_items->quantity,
                        //'color' => $cart_items->color_id
                    ]);

                    $product = Product::where('id', $item->product_id)->first();
                    $decrementQuantity = Product::where('id', $item->product_id)->update([
                        'quantity' => $product->quantity - $item->quantity
                    ]);


                    if (!empty($request->post('addr')['billing']['first_name'])) {

                        foreach ($request->post('addr') as $type => $address) {
                            $address['type'] = $type;
                            $address['email'] = Auth::guard('web')->user()->email ?? $request->guest_email;
                            $order->addresses()->create($address);
                        }
                    } elseif ($request->user_address) {

                        $UserAddress = UserAddress::where('id', $request->user_address)
                            ->first();
                        $address['type'] = 'shipping';
                        $address['first_name'] = $UserAddress->first_name ?? $request->addr['shipping']['first_name'];
                        $address['last_name'] = $UserAddress->family_name ?? $request->addr['shipping']['last_name'];
                        $address['phone_number'] = $UserAddress->phone_number ?? $request->addr['shipping']['phone_number'];
                        $address['country_id'] = $UserAddress->country_id ?? $request->addr['shipping']['country_id'];
                        $address['city_id'] = $UserAddress->city_id ?? $request->addr['shipping']['city_id'];
                        $address['address'] = $UserAddress->address ?? $request->addr['shipping']['address'];
                        $address['email'] = Auth::guard('web')->user()->email;

                        $order->addresses()->create($address);
                    }
                }

                foreach ($items as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    if ($product->quantity == 1) {
                        $product->update([
                            'status' => 'archived'
                        ]);
                    }
                }


                $admins = Admin::all();
                Notification::send($admins, new OrderCreatedNotification($order));

                $validAdmins = $admins->filter(function ($admin) {
                    return filter_var($admin->email, FILTER_VALIDATE_EMAIL);
                });
                foreach ($validAdmins as $admin) {
                    try {
                        Notification::route('mail', $admin->email)
                            ->notify(new OrderCreatedEmailAdmin($order));
                    } catch (\Exception $e) {
                    }
                }

                $user = $order->addresses->first();

                // $user->notify(new SendOrderCreatedToUser($order));


                $cart->empty();
                DB::commit();

                return response()->json([
                    'redirect' => route('home'),
                    'message'  => 'تم اتمام الطلب بنجاح',
                ]);
            } catch (Throwable $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }

    }

    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        foreach ($cart->get() as $item) {
            $item->update(['weight' => $item->quantity * $item->product->weight]);
        }

        $countries = \DB::table('countries')->where('status', 'used')->get();
        $countriesId = \DB::table('countries')->where('status', 'used')->pluck('id')->toArray();
        $cities = \DB::table('cities')->whereIn('country_id', $countriesId)->where('status', 'used')->get();
        $shipping = ShippingTypesAndPrice::where('id', 1)->first();

        $discount = \DB::table('cookie_discount_ids')->where('cookie_id', Cart::getCookieId())->first();
        $discountPrice = null;
        if ($discount) {
            $discountPrice = \App\Models\DiscountCode::where('id', $discount->discount_id)->value('price');
        }

        $cartItems = $cart->get()->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'image'          => $item->product?->image_url,
            'price'          => (float) $item->product?->price,
            'discount_price' => $item->product?->discount_price ? (float) $item->product->discount_price : null,
            'quantity'       => $item->quantity,
        ]);

        $userAddresses = Auth::guard('web')->check()
            ? Auth::guard('web')->user()->addresses()->with(['country', 'city'])->get()->map(fn($a) => [
                'id'           => $a->id,
                'address_title'=> $a->address_title,
                'first_name'   => $a->first_name,
                'family_name'  => $a->family_name,
                'phone_number' => $a->phone_number,
                'address'      => $a->address,
                'country_id'   => $a->country_id,
                'city_id'      => $a->city_id,
                'main_address' => $a->main_address,
            ])
            : collect();

        return \Inertia\Inertia::render('Checkout/Index', [
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
}
