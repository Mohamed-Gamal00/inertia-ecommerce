@extends('dashboard.index')
@section('title', 'تفاصيل البائع')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">البائعون</a></li>
    <li class="breadcrumb-item active">{{ $vendor->name }}</li>
@endsection

@section('section')

<div class="row mb-4 align-items-center">
    <div class="col d-flex align-items-center gap-3">
        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary fs-4"
             style="width:56px;height:56px;flex-shrink:0">
            {{ strtoupper(substr($vendor->name, 0, 1)) }}
        </div>
        <div>
            <h4 class="mb-0 fw-bold">{{ $vendor->name }}</h4>
            <small class="text-muted" dir="ltr">{{ $vendor->email }}</small>
        </div>
    </div>
    <div class="col-auto d-flex gap-2">
        @if($vendor->status !== 'active')
        <form method="POST" action="{{ route('vendors.approve', $vendor->id) }}">
            @csrf @method('PUT')
            <button class="btn btn-success btn-sm px-3">
                <i class="mdi mdi-check me-1"></i> تفعيل
            </button>
        </form>
        @endif
        @if($vendor->status === 'active')
        <form method="POST" action="{{ route('vendors.suspend', $vendor->id) }}">
            @csrf @method('PUT')
            <button class="btn btn-warning btn-sm px-3">
                <i class="mdi mdi-pause me-1"></i> إيقاف
            </button>
        </form>
        @endif
        <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="mdi mdi-arrow-right me-1"></i> العودة
        </a>
    </div>
</div>

<x-alert type="success"/>
<x-alert type="dark"/>

<div class="row g-4">

    {{-- Info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-information-outline me-2 text-primary"></i>
                    معلومات البائع
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">الاسم</span>
                        <span class="fw-semibold small">{{ $vendor->name }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">البريد</span>
                        <span class="fw-semibold small" dir="ltr">{{ $vendor->email }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">الهاتف</span>
                        <span class="fw-semibold small" dir="ltr">{{ $vendor->phone ?? '-' }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">الحالة</span>
                        @if($vendor->status === 'active')
                            <span class="badge bg-success">نشط</span>
                        @elseif($vendor->status === 'pending')
                            <span class="badge bg-warning text-dark">قيد المراجعة</span>
                        @else
                            <span class="badge bg-danger">موقوف</span>
                        @endif
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">المنتجات</span>
                        <span class="badge bg-primary">{{ $vendor->products_count }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">إجمالي الطلبات</span>
                        <span class="badge bg-info">{{ $orderStatusCounts['all'] }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted small">تاريخ التسجيل</span>
                        <span class="fw-semibold small">{{ $vendor->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>

                @if($vendor->description)
                <div class="mt-3 p-3 bg-light rounded">
                    <div class="text-muted small mb-1">وصف المتجر</div>
                    <p class="mb-0 small">{{ $vendor->description }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Order Statistics --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">
                    <i class="mdi mdi-chart-line me-2 text-success"></i>
                    إحصائيات الطلبات
                </h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="text-center p-2 bg-warning bg-opacity-10 rounded">
                            <div class="fw-bold text-warning">{{ $orderStatusCounts['pending'] }}</div>
                            <small class="text-muted">قيد الانتظار</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-2 bg-info bg-opacity-10 rounded">
                            <div class="fw-bold text-info">{{ $orderStatusCounts['processing'] }}</div>
                            <small class="text-muted">قيد المعالجة</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-2 bg-success bg-opacity-10 rounded">
                            <div class="fw-bold text-success">{{ $orderStatusCounts['completed'] }}</div>
                            <small class="text-muted">مكتمل</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-2 bg-primary bg-opacity-10 rounded">
                            <div class="fw-bold text-primary">{{ $orderStatusCounts['all'] }}</div>
                            <small class="text-muted">إجمالي</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial Statistics --}}
        @if(isset($stats))
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">
                    <i class="mdi mdi-currency-usd me-2 text-success"></i>
                    الإحصائيات المالية
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">إجمالي الإيرادات</span>
                        <span class="fw-bold text-success small">{{ number_format($stats['total_revenue'], 2) }} ر.س</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">إجمالي العمولات</span>
                        <span class="fw-bold text-warning small">{{ number_format($stats['total_commission'], 2) }} ر.س</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">الرصيد المتاح</span>
                        <span class="fw-bold text-info small">{{ number_format($stats['available_balance'], 2) }} ر.س</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted small">إجمالي المدفوع</span>
                        <span class="fw-bold text-primary small">{{ number_format($stats['total_paid'], 2) }} ر.س</span>
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </div>

    {{-- Products --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-shopping-outline me-2 text-primary"></i>
                    منتجات البائع ({{ $vendor->products_count }})
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendor->products()->with('parent')->latest()->take(10)->get() as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $product->image_url }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px" alt="">
                                        <div>
                                            <div class="fw-semibold" style="font-size:13px">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->parent?->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold">{{ $product->price }} ر.س</td>
                                <td class="text-center">
                                    <span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->status === 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">لا توجد منتجات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Orders Section --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="mdi mdi-package-variant-closed me-2 text-primary"></i>
                        طلبات البائع ({{ $orderStatusCounts['all'] }})
                    </h5>
                    <div class="d-flex gap-2">
                        @if(Route::has('orders.index'))
                            <a href="{{ route('orders.index', ['vendor_id' => $vendor->id]) }}" class="btn btn-sm btn-outline-info">
                                <i class="mdi mdi-open-in-new me-1"></i>
                                عرض جميع الطلبات
                            </a>
                        @endif
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="order_search" class="form-control form-control-sm"
                                   placeholder="رقم الطلب" value="{{ request('order_search') }}" style="width: 150px;">
                            <select name="order_status" class="form-select form-select-sm" style="width: 120px;">
                                <option value="">كل الحالات</option>
                                <option value="pending" {{ request('order_status') === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="processing" {{ request('order_status') === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                <option value="completed" {{ request('order_status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ request('order_status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Order Status Tabs --}}
            <div class="card-body pt-0">
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item">
                        <a class="nav-link {{ !request('order_status') ? 'active' : '' }}"
                           href="{{ route('vendors.show', $vendor->id) }}">
                            الكل <span class="badge bg-secondary ms-1">{{ $orderStatusCounts['all'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('order_status') === 'pending' ? 'active' : '' }}"
                           href="{{ route('vendors.show', [$vendor->id, 'order_status' => 'pending']) }}">
                            قيد الانتظار <span class="badge bg-warning ms-1">{{ $orderStatusCounts['pending'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('order_status') === 'processing' ? 'active' : '' }}"
                           href="{{ route('vendors.show', [$vendor->id, 'order_status' => 'processing']) }}">
                            قيد المعالجة <span class="badge bg-info ms-1">{{ $orderStatusCounts['processing'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('order_status') === 'completed' ? 'active' : '' }}"
                           href="{{ route('vendors.show', [$vendor->id, 'order_status' => 'completed']) }}">
                            مكتمل <span class="badge bg-success ms-1">{{ $orderStatusCounts['completed'] }}</span>
                        </a>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th class="text-center">المبلغ الإجمالي</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">تاريخ الطلب</th>
                                <th class="text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $order->number }}</div>
                                    <small class="text-muted">{{ $order->orderItems->count() }} منتج</small>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">{{ $order->customer_name }}</div>
                                        <small class="text-muted" dir="ltr">{{ $order->customer_email }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="fw-bold">{{ number_format($order->total_price, 2) }} ر.س</div>
                                    @if($order->shipping_price > 0)
                                        <small class="text-muted">+ {{ number_format($order->shipping_price, 2) }} شحن</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            'refunded' => 'secondary'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'قيد الانتظار',
                                            'processing' => 'قيد المعالجة',
                                            'shipped' => 'تم الشحن',
                                            'delivered' => 'تم التسليم',
                                            'completed' => 'مكتمل',
                                            'cancelled' => 'ملغي',
                                            'refunded' => 'مسترد'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if(Route::has('orders.show'))
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="عرض الطلب">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        @endif
                                        @if(Route::has('orders.edit'))
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-secondary" title="تعديل الطلب">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="mdi mdi-package-variant-closed-remove d-block mb-2" style="font-size:40px;opacity:0.3"></i>
                                    لا توجد طلبات لهذا البائع
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
