<?php

namespace App\Services\CheckOut;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SendNewsToUser;
use App\Models\Setting;
use App\Models\ShippingTypesAndPrice;
use App\Models\UserAddress;
use App\Services\Vendor\VendorOrderNotificationService;
use App\Notifications\OrderCreatedEmailAdmin;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class CheckoutServices
{
    public function checkJoinNews($request, $user)
    {
        if ($request->join_news) {
            $email = $user ? $user->email : $request->guest_email;
            if ($email) {
                SendNewsToUser::firstOrCreate(['subscription_email' => $email]);
            }
        }
    }

    public function checkUserAddressOptions($request)
    {
        // تعارض فقط لو اليوزر بعت عنوان محفوظ وعنوان جديد في نفس الوقت
        if ($request->has('user_address')
            && $request->user_address !== 'add_address'
            && (isset($request->addr['shipping']) || isset($request->addr['billing']))) {
            throw new \Exception('الرجاء اختيار خيار واحد فقط: إما عنوان محفوظ أو إضافة عنوان جديد.', 400);
        }
    }

    public function checkShippingSelectOptions($request)
    {
        $selectedShippingOptions = 0;
        if ($request->has('pickup_from_store')) {
            $selectedShippingOptions++;
        }
        if ($request->has('fixed_shipping')) {
            $selectedShippingOptions++;
        }
        if ($request->has('shipping_based_on_weight')) {
            $selectedShippingOptions++;
        }
        if ($request->has('shipping_based_on_city')) {
            $selectedShippingOptions++;
        }

        if ($selectedShippingOptions > 1) {
            throw new \Exception('لا يمكن اختيار اكثر من طريقة شحن في اّن واحد', 400);
        }
    }

    public function calculateShippingPrice($request, $user): float
    {
        $shipping = ShippingTypesAndPrice::find(1);
        $shippingPrice = 0;

        // الاستلام من المتجر
        if ($request->has('pickup_from_store') && $shipping->add_pickup_from_store == 1) {
            $shippingPrice = 0;
        }
        // شحن ثابت
        elseif ($request->has('fixed_shipping') && $shipping->add_normal_price == 1) {
            $shippingPrice = $shipping->normal_shipping_price;
        }
        // شحن بناء علي الوزن
        elseif ($request->has('shipping_based_on_weight') && $shipping->add_wight_price == 1) {
            $cartItems = Cart::withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)
                ->get();

            $totalWeight = $cartItems->sum(fn ($item) => ($item->product->weight ?? 0) * $item->quantity);
            $shippingPrice = $totalWeight * $shipping->weight_price;
        }
        // شحن بناء علي المدينة
        elseif ($request->has('shipping_based_on_city') && $shipping->add_price_based_on_city == 1) {
            // لو اليوزر اختار عنوان محفوظ
            if ($request->has('user_address') && $request->user_address !== 'add_address') {
                $userAddress = UserAddress::find($request->user_address);
                if (! $userAddress) {
                    throw new \Exception('العنوان المحدد غير موجود. يرجى التحقق من صحة العنوان.', 400);
                }
                $cityId = $userAddress->city_id;
            } else {
                // لو بيضيف عنوان جديد
                $cityId = $request->addr['shipping']['city_id']
                    ?? $request->addr['billing']['city_id']
                    ?? null;
            }
            $city = City::find($cityId);
            $shippingPrice = $city ? $city->shipping_price : 0;
        } else {
            throw new \Exception('تأكد من اختيارك طريقة شحن متاحة', 200);
        }

        return (float) $shippingPrice;
    }

    public function createOrder($request, $user, $shippingPrice, ?int $companyId = null): Order
    {
        $settings = Setting::first();
        $valueAddedTax = $settings->value_added_tax ?? 0;
        $totalPrice = $this->calculateTotal($user);
        $totalBeforeDiscount = $this->calculateTotalBeforeDiscount($user);
        $addedTax = ($totalPrice * ($valueAddedTax / 100));

        return Order::create([
            'user_id' => $user->id,
            'company_id' => $companyId,
            'payment_method' => $request->payment_method,
            'order_status_id' => OrderStatus::where('default_status', true)->first()->id,
            'note' => $request->note,
            'shipping_price' => $shippingPrice,
            'totalBeforeDiscount' => $totalBeforeDiscount,
            'total_price' => $totalPrice + $addedTax,
        ]);
    }

    public function createOrderItems($order, $user)
    {
        $cartItems = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->get();

        foreach ($cartItems as $cartItem) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->discount_price ?? $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);

            // لو فيه sub_choice كمان، زودها مع withPivot
            if (! empty($cartItem->choices)) {
                foreach ($cartItem->choices as $choiceId) {
                    $orderItem->choices()->attach($choiceId);
                }
            }

            $cartItem->product->decrement('quantity', $cartItem->quantity);
        }
    }

    public function calculateTotal($user): float
    {
        // السعر بعد الخصم لو فيه خصم
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)->where('status', 0)->get()
            ->sum(function ($item) {
                if ($item->product->discount_price) {
                    return $item->quantity * ($item->discounted_price ?? $item->product->discount_price);
                } else {
                    return $item->quantity * ($item->discounted_price ?? $item->product->price);
                }
            });
    }

    public function calculateTotalBeforeDiscount($user): float
    {
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)->where('status', 0)->get()
            ->sum(function ($item) {
                if ($item->product->discount_price) {
                    return $item->quantity * $item->product->discount_price;
                } else {
                    return $item->quantity * $item->product->price;
                }
            });
    }

    public function isAddingNewAddress($order, $request, $user)
    {
        // الحالة الأولى: اليوزر اختار عنوان محفوظ
        if ($request->has('user_address') && $request->user_address !== 'add_address') {
            $UserAddress = UserAddress::where('id', $request->user_address)->first();
            if ($UserAddress) {
                $order->addresses()->create([
                    'type' => 'shipping',
                    'first_name' => $UserAddress->first_name,
                    'last_name' => $UserAddress->family_name,
                    'phone_number' => $UserAddress->phone_number,
                    'country_id' => $UserAddress->country_id,
                    'city_id' => $UserAddress->city_id,
                    'address' => $UserAddress->address,
                    'email' => $user?->email,
                ]);
            }

            return;
        }

        // الحالة الثانية: يوزر مسجل بيضيف عنوان شحن جديد
        if (isset($request->addr['shipping'])) {
            $addr = $request->addr['shipping'];
            $order->addresses()->create([
                'type' => 'shipping',
                'first_name' => $addr['first_name'] ?? null,
                'last_name' => $addr['last_name'] ?? null,
                'phone_number' => $addr['phone_number'] ?? null,
                'country_id' => $addr['country_id'] ?? null,
                'city_id' => $addr['city_id'] ?? null,
                'address' => $addr['address'] ?? null,
                'email' => $user?->email,
            ]);

            // حفظ العنوان في قائمة عناوين اليوزر للاستخدام مستقبلاً
            if ($user) {
                UserAddress::create([
                    'user_id' => $user->id,
                    'address_title' => 'عنوان جديد',
                    'first_name' => $addr['first_name'] ?? null,
                    'family_name' => $addr['last_name'] ?? null,
                    'phone_number' => $addr['phone_number'] ?? null,
                    'country_id' => $addr['country_id'] ?? null,
                    'city_id' => $addr['city_id'] ?? null,
                    'address' => $addr['address'] ?? null,
                    'main_address' => false,
                ]);
            }

            return;
        }

        // الحالة الثالثة: زائر بيضيف عنوان billing
        if (isset($request->addr['billing'])) {
            $addr = $request->addr['billing'];
            $order->addresses()->create([
                'type' => 'billing',
                'first_name' => $addr['first_name'] ?? null,
                'last_name' => $addr['last_name'] ?? null,
                'phone_number' => $addr['phone_number'] ?? null,
                'country_id' => $addr['country_id'] ?? null,
                'city_id' => $addr['city_id'] ?? null,
                'address' => $addr['address'] ?? null,
                'email' => $request->guest_email,
            ]);
        }
    }

    public function getCartItems($user)
    {
        return Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->with('product')
            ->get();
    }

    public function disActiveProduct($cartItems)
    {
        // تعطيل المنتج لو الكمية وصلت للصفر أو أقل
        foreach ($cartItems as $item) {
            $product = Product::where('id', $item->product_id)->first();
            if ($product && $product->quantity <= 1) {
                $product->update(['status' => 'archived']);
            }
        }
    }

    public function updateProductStatue($user)
    {
        // تحويل حالة السلة من نشطة (0) إلى منتهية (1) بعد إتمام الطلب
        Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->update(['status' => 1]);
    }

    public function sendNotificationToAdmin($order)
    {
        VendorOrderNotificationService::notifyNewOrder($order);

        $admins = Admin::all();
        Notification::send($admins, new OrderCreatedNotification($order));

        // إرسال إيميل للأدمنز اللي عندهم إيميل صحيح
        $validAdmins = $admins->filter(fn ($admin) => filter_var($admin->email, FILTER_VALIDATE_EMAIL));
        foreach ($validAdmins as $admin) {
            try {
                Notification::route('mail', $admin->email)
                    ->notify(new OrderCreatedEmailAdmin($order));
            } catch (\Exception $e) {
            }
        }
    }

    public function checkPaymentMethod($request, $order)
    {
        if ($request->payment_method == 'card_payment') {
            // توجيه لصفحة الدفع بالبطاقة
            return response()->json([
                'redirect' => route('user.payment', ['order_number' => $order->number]),
            ], 201);
        }

        // الدفع عند الاستلام — توجيه للصفحة الرئيسية
        return response()->json([
            'redirect' => route('home'),
            'message' => 'تم إتمام الطلب بنجاح',
        ], 201);
    }
}
