<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب جديد #{{ $order->number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            background: #f0f2f8;
            color: #111827;
            direction: rtl;
        }
        .wrapper { max-width: 620px; margin: 32px auto; padding: 0 16px 40px; }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
            border-radius: 16px 16px 0 0;
            padding: 32px 32px 24px;
            text-align: center;
        }
        .header-icon {
            width: 56px; height: 56px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 28px;
        }
        .header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .header p {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
        }

        /* Body */
        .body {
            background: #fff;
            padding: 28px 32px;
        }

        /* Alert banner */
        .alert-banner {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #1b5e20;
            font-weight: 600;
        }

        /* Section title */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }
        .info-item {
            background: #f8f9fb;
            border-radius: 10px;
            padding: 12px 14px;
        }
        .info-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .info-value.highlight { color: #1a237e; font-size: 16px; }

        /* Products table */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 13px;
        }
        .products-table th {
            background: #f3f4f6;
            padding: 10px 12px;
            text-align: right;
            font-weight: 700;
            color: #374151;
            font-size: 12px;
        }
        .products-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        .products-table tr:last-child td { border-bottom: none; }

        /* Totals */
        .totals {
            background: #f8f9fb;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #6b7280;
            padding: 4px 0;
        }
        .totals-row.total {
            font-size: 16px;
            font-weight: 800;
            color: #1a237e;
            border-top: 1px solid #e5e7eb;
            margin-top: 8px;
            padding-top: 10px;
        }

        /* CTA button */
        .cta {
            text-align: center;
            margin: 24px 0;
        }
        .cta a {
            display: inline-block;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: #fff;
            text-decoration: none;
            padding: 13px 32px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* Customer info */
        .customer-box {
            background: #f0f2ff;
            border: 1px solid #c5cae9;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 13px;
        }
        .customer-box .row {
            display: flex;
            gap: 8px;
            margin-bottom: 4px;
        }
        .customer-box .lbl { color: #6b7280; min-width: 90px; }
        .customer-box .val { color: #111827; font-weight: 600; }

        /* Footer */
        .footer {
            background: #f8f9fb;
            border-radius: 0 0 16px 16px;
            padding: 20px 32px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
        .footer a { color: #3949ab; text-decoration: none; }

        @media (max-width: 480px) {
            .info-grid { grid-template-columns: 1fr; }
            .body { padding: 20px 16px; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Header -->
    <div class="header">
        <div class="header-icon">🛒</div>
        <h1>طلب جديد وارد!</h1>
        <p>{{ now()->format('d/m/Y — H:i') }}</p>
    </div>

    <!-- Body -->
    <div class="body">

        <!-- Alert -->
        <div class="alert-banner">
            ✅ تم استلام طلب جديد برقم <strong>#{{ $order->number }}</strong> — يرجى مراجعته والبدء في المعالجة.
        </div>

        <!-- Order info grid -->
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
                <div class="info-label">طريقة الدفع</div>
                <div class="info-value">
                    {{ $order->payment_method === 'cash_on_delivery' ? 'الدفع عند الاستلام' : 'بطاقة دفع' }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">حالة الدفع</div>
                <div class="info-value">
                    @if($order->payment_status === 'paid')
                        ✅ مدفوع
                    @elseif($order->payment_status === 'failed')
                        ❌ فاشل
                    @else
                        ⏳ معلق
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer info -->
        @php $addr = $order->addresses->first(); @endphp
        @if($addr)
        <div class="section-title">بيانات العميل</div>
        <div class="customer-box">
            <div class="row">
                <span class="lbl">الاسم:</span>
                <span class="val">{{ $addr->first_name }} {{ $addr->last_name }}</span>
            </div>
            @if($addr->phone_number)
            <div class="row">
                <span class="lbl">الهاتف:</span>
                <span class="val" dir="ltr">{{ $addr->phone_number }}</span>
            </div>
            @endif
            @if($addr->email)
            <div class="row">
                <span class="lbl">البريد:</span>
                <span class="val" dir="ltr">{{ $addr->email }}</span>
            </div>
            @endif
            @if($addr->address)
            <div class="row">
                <span class="lbl">العنوان:</span>
                <span class="val">
                    {{ $addr->address }}
                    @if($addr->city) — {{ $addr->city->name_ar }} @endif
                    @if($addr->country) — {{ $addr->country->name_ar }} @endif
                </span>
            </div>
            @endif
        </div>
        @endif

        <!-- Products -->
        <div class="section-title">المنتجات المطلوبة</div>
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
                    <td style="text-align:left; font-weight:700; color:#1a237e">
                        {{ number_format($item->price, 2) }} ر.س
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <span>المجموع قبل الشحن</span>
                <span>{{ number_format($order->totalBeforeDiscount ?? $order->total_price, 2) }} ر.س</span>
            </div>
            <div class="totals-row">
                <span>تكلفة الشحن</span>
                <span>{{ number_format($order->shipping_price ?? 0, 2) }} ر.س</span>
            </div>
            <div class="totals-row total">
                <span>الإجمالي الكلي</span>
                <span>{{ number_format($order->total_price, 2) }} ر.س</span>
            </div>
        </div>

        <!-- CTA -->
        <div class="cta">
            <a href="{{ route('orders.show', $order->id) }}">
                عرض تفاصيل الطلب في لوحة التحكم →
            </a>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>هذا البريد أُرسل تلقائياً من نظام إدارة المتجر.</p>
        <p style="margin-top:6px">
            <a href="{{ url('/admin') }}">لوحة التحكم</a>
            &nbsp;·&nbsp;
            <a href="{{ url('/') }}">الموقع</a>
        </p>
    </div>

</div>
</body>
</html>
