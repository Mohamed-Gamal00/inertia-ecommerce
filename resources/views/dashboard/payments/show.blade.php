@extends('dashboard.index')
@section('title', 'تفاصيل المعاملة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">المدفوعات</a></li>
    <li class="breadcrumb-item active">معاملة #{{ $transaction->id }}</li>
@endsection

@section('section')

<div class="row g-4">

    {{-- Transaction info --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-credit-card-outline me-2 text-primary"></i>
                بيانات المعاملة
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:40%">معرّف المعاملة</td>
                        <td><code>{{ $transaction->moyasar_payment_id ?? '—' }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">الحالة</td>
                        <td><span class="badge bg-{{ $transaction->status_color }} px-3 py-2">{{ $transaction->status_label }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">المبلغ</td>
                        <td class="fw-bold fs-5" style="color:#1a237e">{{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">طريقة الدفع</td>
                        <td>{{ $transaction->payment_method ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">البطاقة</td>
                        <td>
                            @if($transaction->card_brand)
                                {{ strtoupper($transaction->card_brand) }}
                                @if($transaction->card_last_four)
                                    •••• {{ $transaction->card_last_four }}
                                @endif
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">الوصف</td>
                        <td>{{ $transaction->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">عنوان IP</td>
                        <td dir="ltr">{{ $transaction->ip_address ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">التاريخ</td>
                        <td>{{ $transaction->created_at->format('d/m/Y — H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Order info --}}
    <div class="col-lg-6">
        @if($transaction->order)
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-bold d-flex justify-content-between align-items-center">
                <span><i class="mdi mdi-package-variant-closed me-2 text-primary"></i>بيانات الطلب</span>
                <a href="{{ route('orders.show', $transaction->order->id) }}" class="btn btn-sm btn-outline-primary">
                    عرض الطلب
                </a>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:40%">رقم الطلب</td>
                        <td class="fw-bold">#{{ $transaction->order->number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">العميل</td>
                        <td>{{ $transaction->order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">إجمالي الطلب</td>
                        <td>{{ number_format($transaction->order->total_price, 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">حالة الدفع</td>
                        <td>
                            @if($transaction->order->payment_status === 'paid')
                                <span class="badge bg-success">مدفوع</span>
                            @elseif($transaction->order->payment_status === 'failed')
                                <span class="badge bg-danger">فاشل</span>
                            @else
                                <span class="badge bg-warning text-dark">معلق</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if($transaction->order->orderItems->count())
                <div class="mt-3 border-top pt-3">
                    <div class="text-muted fw-semibold small mb-2">المنتجات</div>
                    @foreach($transaction->order->orderItems as $item)
                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom" style="font-size:13px">
                        <span>{{ $item->product_name }}</span>
                        <span class="text-muted">× {{ $item->quantity }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Raw response --}}
    @if($transaction->raw_response)
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-code-json me-2 text-primary"></i>
                الاستجابة الكاملة من Moyasar
            </div>
            <div class="card-body p-0">
                <pre class="mb-0 p-3" style="background:#f8f9fb; border-radius:0 0 8px 8px; font-size:12px; max-height:300px; overflow-y:auto; direction:ltr; text-align:left">{{ json_encode(json_decode($transaction->raw_response), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
