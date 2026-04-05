<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Show the Moyasar payment form for a given order number.
     */
    public function show($order_number)
    {
        $order = Order::where('number', $order_number)
            ->with(['addresses', 'orderItems'])
            ->firstOrFail();

        // Already paid — redirect to success
        if ($order->payment_status === 'paid') {
            return redirect()->route('home')
                ->with('success', 'هذا الطلب تم دفعه بالفعل.');
        }

        $setting        = Setting::first();
        $publishable_key = $setting?->publishable_key;

        $callbackUrl = url("/payment/{$order->number}/callback");

        return Inertia::render('Payment/Index', [
            'order'           => [
                'id'             => $order->id,
                'number'         => $order->number,
                'total_price'    => (float) $order->total_price,
                'shipping_price' => (float) ($order->shipping_price ?? 0),
                'payment_status' => $order->payment_status,
            ],
            'publishable_key' => $publishable_key,
            'callback_url'    => $callbackUrl,
        ]);
    }

    /**
     * Handle Moyasar callback after payment attempt.
     */
    public function callback(Request $request, $order_number)
    {
        $order = Order::where('number', $order_number)
            ->with('orderItems')
            ->firstOrFail();

        // Already paid — go straight to success page
        if ($order->payment_status === 'paid') {
            return Inertia::render('Payment/Success', [
                'order' => $this->orderData($order),
            ]);
        }

        $paymentId  = $request->query('id');
        $setting    = Setting::first();
        $secret_key = $setting?->secret_key;
        $token      = base64_encode($secret_key . ':');

        $payment = Http::baseUrl('https://api.moyasar.com/v1')
            ->withHeaders(['Authorization' => "Basic {$token}"])
            ->get("payments/{$paymentId}")
            ->json();

        // Auth error
        if (isset($payment['type']) && $payment['type'] === 'authentication_error') {
            return Inertia::render('Payment/Failed', [
                'order'   => $this->orderData($order),
                'message' => 'بيانات بوابة الدفع غير صحيحة. يرجى التواصل مع الدعم.',
            ]);
        }

        $status = $payment['status'] ?? 'failed';
        $order->update(['payment_status' => $status === 'paid' ? 'paid' : 'failed']);

        if ($status === 'paid') {
            return Inertia::render('Payment/Success', [
                'order' => $this->orderData($order),
            ]);
        }

        return Inertia::render('Payment/Failed', [
            'order'   => $this->orderData($order),
            'message' => $payment['source']['message'] ?? 'فشلت عملية الدفع. يرجى المحاولة مرة أخرى.',
        ]);
    }

    private function orderData(Order $order): array
    {
        return [
            'number'         => $order->number,
            'total_price'    => (float) $order->total_price,
            'shipping_price' => (float) ($order->shipping_price ?? 0),
            'payment_status' => $order->payment_status,
            'items_count'    => $order->orderItems->sum('quantity'),
        ];
    }
}
