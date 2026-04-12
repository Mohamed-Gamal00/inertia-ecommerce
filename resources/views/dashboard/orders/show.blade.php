@extends('dashboard.index')

@section('title', 'تفاصيل الطلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">الطلبات</a></li>
    <li class="breadcrumb-item active">طلب #{{ $order->number }}</li>
@endsection

@section('section')

<div class="row mb-4 align-items-center">
    <div class="col">
        <h4 class="mb-0 fw-bold">
            <i class="mdi mdi-package-variant me-2 text-primary"></i>
            تفاصيل الطلب <span class="text-primary">#{{ $order->number }}</span>
        </h4>
        <small class="text-muted">{{ $order->created_at->format('d/m/Y — h:i A') }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="mdi mdi-arrow-right me-1"></i> العودة للطلبات
        </a>
    </div>
</div>

{{-- ===== Row 1: Status cards ===== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-pound text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">رقم الطلب</div>
                    <div class="fw-bold">#{{ $order->number }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="mdi mdi-cash text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">الإجمالي</div>
                    <div class="fw-bold">{{ $order->total_price }} ر.س</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="mdi mdi-credit-card text-info fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">طريقة الدفع</div>
                    <div class="fw-bold">
                        {{ $order->payment_method === 'cash_on_delivery' ? 'عند الاستلام' : 'بطاقة ائتمانية' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="mdi mdi-check-circle text-warning fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">حالة الدفع</div>
                    <div class="fw-bold">
                        @if($order->payment_status === 'paid')
                            <span class="badge bg-success">مدفوع</span>
                        @else
                            <span class="badge bg-warning text-dark">غير مدفوع</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Row 2: Order status timeline ===== --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">
            <i class="mdi mdi-timeline-check me-2 text-primary"></i>
            حالة الطلب
        </h5>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @foreach($orderStatus->sortBy('arrangement') as $status)
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

{{-- ===== Row 3: Products + Customer info ===== --}}
<div class="row g-4 mb-4">

    {{-- Products --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-shopping me-2 text-primary"></i>
                    المنتجات المطلوبة
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item->product->image_url }}"
                                            alt="{{ $item->product_name }}"
                                            class="rounded"
                                            style="width:52px; height:52px; object-fit:cover; border:1px solid #e5e7eb">
                                        <div>
                                            <div class="fw-semibold" style="font-size:14px">{{ $item->product_name }}</div>
                                            @if($item->product->parent)
                                                <small class="text-muted">{{ $item->product->parent->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-center">{{ number_format($item->price / max($item->quantity,1), 2) }} ر.س</td>
                                <td class="text-center fw-bold text-primary">{{ number_format($item->price, 2) }} ر.س</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">لا توجد منتجات</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">تكلفة الشحن</td>
                                <td class="text-center fw-bold">{{ $order->shipping_price ?? 0 }} ر.س</td>
                            </tr>
                            @if($order->discountCode)
                            <tr>
                                <td colspan="3" class="text-end fw-bold text-success">
                                    <i class="mdi mdi-tag-outline me-1"></i>
                                    كود الخصم
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success ms-1" style="font-size:12px">
                                        {{ $order->discountCode->code }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold text-success">
                                    @if($order->discountCode->discount_type === 'percentage')
                                        - {{ $order->discountCode->price }}%
                                    @else
                                        - {{ $order->discountCode->price }} ر.س
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-6">الإجمالي الكلي</td>
                                <td class="text-center fw-bold fs-6 text-primary">
                                    {{ number_format($order->total_price, 2) }} ر.س
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->note)
                <div class="alert alert-light border mt-3 mb-0">
                    <i class="mdi mdi-note-text me-2 text-muted"></i>
                    <strong>ملاحظة العميل:</strong> {{ $order->note }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Customer info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-account me-2 text-primary"></i>
                    بيانات العميل
                    @if(!$order->user_id)
                        <span class="badge bg-secondary ms-2" style="font-size:11px">زائر</span>
                    @endif
                </h5>

                @php $addr = $order->addresses->first(); @endphp

                @if($order->user_id && $order->user)
                <div class="mb-3 p-2 rounded" style="background:#f0f2ff; border:1px solid #c5cae9">
                    <div class="text-muted small mb-1">عميل مسجل</div>
                    <a href="{{ route('clients.edit', $order->user_id) }}" class="fw-bold text-primary text-decoration-none">
                        <i class="mdi mdi-account-circle me-1"></i>
                        {{ $order->user->first_name }} {{ $order->user->family_name }}
                    </a>
                </div>
                @endif

                @if($addr)
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <i class="mdi mdi-account-outline text-muted mt-1"></i>
                        <div>
                            <div class="text-muted small">الاسم</div>
                            <div class="fw-semibold">{{ $addr->first_name }} {{ $addr->last_name }}</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <i class="mdi mdi-phone-outline text-muted mt-1"></i>
                        <div>
                            <div class="text-muted small">الهاتف</div>
                            <div class="fw-semibold" dir="ltr">{{ $addr->phone_number }}</div>
                        </div>
                    </li>
                    @if($addr->email)
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <i class="mdi mdi-email-outline text-muted mt-1"></i>
                        <div>
                            <div class="text-muted small">البريد الإلكتروني</div>
                            <div class="fw-semibold" dir="ltr">{{ $addr->email }}</div>
                        </div>
                    </li>
                    @endif
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <i class="mdi mdi-map-marker-outline text-muted mt-1"></i>
                        <div>
                            <div class="text-muted small">العنوان</div>
                            <div class="fw-semibold">
                                {{ $addr->address }}
                                @if($addr->city) — {{ $addr->city->name_ar }} @endif
                                @if($addr->country) — {{ $addr->country->name_ar }} @endif
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="mdi mdi-truck-outline text-muted mt-1"></i>
                        <div>
                            <div class="text-muted small">الشحن</div>
                            <div class="fw-semibold">
                                {{ $order->shipping_price ? $order->shipping_price . ' ر.س' : 'استلام من المتجر' }}
                            </div>
                        </div>
                    </li>
                    @if($order->discountCode)
                    <li class="d-flex align-items-start gap-2 mt-3 pt-3" style="border-top:1px solid #f3f4f6">
                        <i class="mdi mdi-tag-outline text-success mt-1"></i>
                        <div>
                            <div class="text-muted small">كود الخصم المستخدم</div>
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <span class="badge fs-6 px-3 py-2" style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; font-family:monospace; letter-spacing:1px">
                                    {{ $order->discountCode->code }}
                                </span>
                                <span class="badge bg-success">
                                    @if($order->discountCode->discount_type === 'percentage')
                                        خصم {{ $order->discountCode->price }}%
                                    @else
                                        خصم {{ $order->discountCode->price }} ر.س
                                    @endif
                                </span>
                            </div>
                            <div class="text-muted mt-1" style="font-size:11px">
                                {{ $order->discountCode->name }}
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
                @else
                <p class="text-muted">لا توجد بيانات عنوان</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== Row 4: Update status ===== --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">
            <i class="mdi mdi-pencil me-2 text-primary"></i>
            تحديث حالة الطلب
        </h5>
        <form action="{{ route('orders.update', $order->id) }}" method="post">
            @csrf
            @method('put')
            <div class="row align-items-end g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الحالة الجديدة</label>
                    <select class="form-select" name="order_status_id" required>
                        @foreach($orderStatus as $status)
                            <option value="{{ $status->id }}" @selected($order->order_status_id == $status->id)>
                                {{ $status->CurrentNameLang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="mdi mdi-content-save me-1"></i>
                        حفظ الحالة
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
