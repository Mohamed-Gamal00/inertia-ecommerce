<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الدفع — طلب #{{ $order->number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; background: #f0f2f8; color: #111827; direction: rtl; }
        .wrapper { max-width: 620px; margin: 32px auto; padding: 0 16px 40px; }

        .header {
            background: linear-gradient(135deg, #14532d 0%, #16a34a 100%);
            border-radius: 16px 16px 0 0;
            padding: 32px 32px 24px;
            text-align: center;
        }
        .header-icon { font-size: 48px; margin-bottom: 12px; display: block; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 800; margin-bottom: 4px; }
        .header p  { color: rgba(255,255,255,0.8); font-size: 13px; }

        .body { background: #fff; padding: 28px 32px; }

        .alert-banner {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #14532d;
            font-weight: 600;
        }

        .section-title {
            font-size: 12px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 12px; padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .info-item { background: #f8f9fb; border-radius: 10px; padding: 12px 14px; }
        .info-label { font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 3px; }
        .info-value { font-size: 14px; font-weight: 700; color: #111827; }

        /* Payment highlight box */
        .payment-box {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1.5px solid #86efac;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .payment-box-left .label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
        .payment-box-left .amount { font-size: 28px; font-weight: 900; color: #15803d; }
        .payment-box-left .currency { font-size: 14px; color: #6b7280; }
        .payment-box-right { text-align: left; }
        .payment-box-right .method { font-size: 13px; font-weight: 700; color: #374151; }
        .payment-box-right .card { font-size: 12px; color: #9ca3af; margin-top: 3px; }
        .paid-badge {
            display: inline-block;
            background: #16a34a;
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            margin-top: 6px;
        }

        .products-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 13px; }
        .products-table th { background: #f3f4f6; padding: 10px 12px; text-align: right; font-weight: 700; color: #374151; font-size: 12px; }
        .products-table td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; color: #374151; }
        .products-table tr:last-child td { border-bottom: none; }

        .totals { background: #f8f9fb; border-radius: 10px; padding: 14px 16px; margin-bottom: 24px; }
        .totals-row { display: flex; justify-content: space-between; font-size: 13px; color: #6b7280; padding: 4px 0; }
        .totals-row.total { font-size: 16px; font-weight: 800; color: #15803d; border-top: 1px solid #e5e7eb; margin-top: 8px; padding-top: 10px; }

        .cta { text-align: center; margin: 24px 0; }
        .cta a {
            display: inline-block;
            background: linear-gradient(135deg, #14532d, #16a34a);
            color: #fff; text-decoration: none;
            padding: 13px 32px; border-radius: 10px;
            font-size: 14px; font-weight: 700;
        }

        .footer {
            background: #f8f9fb; border-radius: 0 0 16px 16px;
            padding: 20px 32px; text-align: center;
            font-size: 12px; color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
        .footer a { color: #16a34a; text-decoration: none; }

        @media (max-width: 480px) {
            .info-grid { grid-template-columns: 1fr; }
            .body { padding: 20px 16px; }
            .payment-box { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <span class="header-icon">✅</span>
        <h1>تم استلام الدفع بنجاح!</h1>
        <p>{{ now()->format('d/m/Y — H:i') }}</p>
    </div>

    <div class="body">

        <div class="alert-banner">
            💰 تم تأكيد دفع الطلب <strong>#{{ $order->number }}</strong> بنجاح عبر بوابة Moyasar.
        </div>

        {{-- Payment highlight --}}
        <div class="section-title">تفاصيل الدفعة</div>
        <div class="payment-box">
            <div class="payment-box-left">
                <div class="label">المبلغ المحصّل</div>
                <div>
                    <span class="amount">{{ number_format($transaction->amount, 2) }}</span>
                    <span class="currency"> ر.س</span>
                </div>
                <span class="paid-badge">✓ مدفوع</span>
            </div>
            <div class="payment-box-right">
                <div class="method">
                    @if($transaction->payment_method === 'creditcard') 💳 بطاقة ائتمانية
                    @elseif($transaction->payment_method === 'stcpay') 📱 STC Pay
                    @else {{ $transaction->payment_method ?? '—' }}
                    @endif
                </div>
                @if($transaction->card_brand)
                <div class="card">
                    {{ strtoupper($transaction->card_brand) }}
                    @if($transaction->card_last_four) •••• {{ $transaction->card_last_four }} @endif
                </div>
                @endif
                @if($transaction->moyasar_payment_id)
                <div class="card" style="margin-top:6px; font-size:10px; direction:ltr">
                    ID: {{ Str::limit($transaction->moyasar_payment_id, 28) }}
                </div>
                @endif
            </div>
        </div>

        {{-- Order info --}}
        <div class="section-title">معلومات الطلب</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">رقم الطلب</div>
                <div class="info-value">#{{ $order->number }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">تاريخ الطلب</div>
                <div class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">العميل</div>
                <div class="info-value">{{ $order->customer_name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value" style="font-size:12px; direction:ltr">{{ $order->customer_email }}</div>
            </div>
        </div>

        {{-- Products --}}
        <div class="section-title">المنتجات</div>
        <table class="products-table">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th style="text-align:center">الكمية</th>
                    <th style="text-align:left">السعر</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td style="text-align:left; font-weight:700; color:#15803d">
                        {{ number_format($item->price, 2) }} ر.س
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>تكلفة الشحن</span>
                <span>{{ number_format($order->shipping_price ?? 0, 2) }} ر.س</span>
            </div>
            <div class="totals-row total">
                <span>الإجمالي المدفوع</span>
                <span>{{ number_format($order->total_price, 2) }} ر.س</span>
            </div>
        </div>

        <div class="cta">
            <a href="{{ route('orders.show', $order->id) }}">
                عرض الطلب في لوحة التحكم →
            </a>
        </div>

    </div>

    <div class="footer">
        <p>تم إرسال هذا البريد تلقائياً بعد تأكيد الدفع.</p>
        <p style="margin-top:6px">
            <a href="{{ url('/admin') }}">لوحة التحكم</a>
            &nbsp;·&nbsp;
            <a href="{{ url('/admin/payments') }}">سجل المدفوعات</a>
        </p>
    </div>

</div>
</body>
</html>
