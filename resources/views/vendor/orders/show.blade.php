@extends('vendor.layouts.app')
@section('title', 'تفاصيل الطلب #' . $order->number)

@section('content')

<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
    <a href="{{ route('vendor.orders') }}" class="btn btn-outline-secondary btn-sm">
        <i class="mdi mdi-arrow-right me-1"></i> العودة
    </a>
    <h5 class="fw-bold mb-0">طلب #{{ $order->number }}</h5>
    <span class="badge bg-primary">{{ $order->orderStatus?->CurrentNameLang ?? '-' }}</span>
    @if($order->return_order)
        <span class="badge bg-warning text-dark">طلب إرجاع</span>
    @endif
</div>

@if($order->return_order)
<div class="alert alert-warning border-0 shadow-sm mb-4">
    <i class="mdi mdi-keyboard-return me-2"></i>
    <strong>طلب إرجاع:</strong> العميل طلب إرجاعاً لهذا الطلب. يمكنك متابعة الحالة أدناه وفق سياسة المنصة.
</div>
@endif

@if(!$canUpdateStatus)
    <div class="alert alert-warning border-0 shadow-sm mb-4">
        <i class="mdi mdi-information-outline me-2"></i>
        هذا الطلب يضم أكثر من بائع أو غير مرتبط بمتجرك بالكامل؛ تحديث الحالة متاح لمدير المنصة فقط.
    </div>
@endif

<div class="alert alert-light border mb-4 small">
    <strong>الشحن وطرق التوصيل:</strong> يضبطها مدير المنصة (أسعار الشحن وخيارات الاستلام). يظهر لك أدناه ما دفعه العميل كقيمة شحن مرفقة بالطلب.
</div>

{{-- حالة الطلب — نفس ترتيب لوحة المدير --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="mdi mdi-timeline-check me-2 text-primary"></i> مسار حالة الطلب</h6>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @foreach($orderStatuses->sortBy('arrangement') as $status)
                <div class="d-flex align-items-center">
                    <div class="text-center" style="min-width:90px">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-1
                            {{ $order->order_status_id == $status->id ? 'bg-primary text-white' : 'bg-light text-muted' }}"
                            style="width:40px; height:40px; font-size:13px; font-weight:700">
                            {{ $status->arrangement }}
                        </div>
                        <div style="font-size:11px; {{ $order->order_status_id == $status->id ? 'color:#1a237e; font-weight:700' : 'color:#9ca3af' }}">
                            {{ $status->CurrentNameLang }}
                        </div>
                    </div>
                    @if(!$loop->last)
                        <div class="flex-grow-1 mx-1" style="height:2px; background:#e5e7eb; min-width:20px"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@if($canUpdateStatus)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="mdi mdi-pencil me-2 text-primary"></i> تحديث حالة الطلب (تجهيز وشحن)</h6>
        <form action="{{ route('vendor.orders.status', $order) }}" method="post" class="row g-3 align-items-end">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label class="form-label small fw-semibold">الحالة</label>
                <select name="order_status_id" class="form-select" required>
                    @foreach($orderStatuses as $status)
                        <option value="{{ $status->id }}" @selected($order->order_status_id == $status->id)>
                            {{ $status->CurrentNameLang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="mdi mdi-content-save me-1"></i> حفظ
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-shopping me-2 text-primary"></i> منتجاتك في هذا الطلب</h6>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendorItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item->product->image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px" alt="">
                                        <div>
                                            <div class="fw-semibold">{{ $item->product_name }}</div>
                                            <small class="text-muted">{{ $item->product->parent?->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $item->quantity }}</span></td>
                                <td class="text-center fw-bold text-primary">{{ number_format($item->price, 2) }} ر.س</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="2" class="text-end fw-bold">إجمالي منتجاتك</td>
                                <td class="text-center fw-bold text-primary">
                                    {{ number_format($vendorItems->sum('price'), 2) }} ر.س
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->note)
                <div class="alert alert-light border mt-3 mb-0 small">
                    <strong>ملاحظة العميل:</strong> {{ $order->note }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-account me-2 text-primary"></i> بيانات العميل</h6>
                @php $addr = $order->addresses->first(); @endphp
                @if($addr)
                <ul class="list-unstyled mb-0">
                    <li class="d-flex gap-2 mb-2">
                        <i class="mdi mdi-account-outline text-muted"></i>
                        <span class="fw-semibold">{{ $addr->first_name }} {{ $addr->last_name }}</span>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                        <i class="mdi mdi-phone-outline text-muted"></i>
                        <span dir="ltr">{{ $addr->phone_number }}</span>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                        <i class="mdi mdi-map-marker-outline text-muted"></i>
                        <span>{{ $addr->address }}@if($addr->city) — {{ $addr->city->name_ar }}@endif</span>
                    </li>
                </ul>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-information-outline me-2 text-primary"></i> معلومات الطلب</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">تاريخ الطلب</span>
                    <span class="fw-semibold small">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">طريقة الدفع</span>
                    <span class="fw-semibold small">{{ $order->payment_method === 'cash_on_delivery' ? 'عند الاستلام' : 'بطاقة' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">حالة الدفع</span>
                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $order->payment_status === 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">الشحن (مدفوع مع الطلب)</span>
                    <span class="fw-semibold small">{{ number_format($order->shipping_price ?? 0, 2) }} ر.س</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">إجمالي الطلب (كامل)</span>
                    <span class="fw-semibold small">{{ number_format($order->total_price, 2) }} ر.س</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
