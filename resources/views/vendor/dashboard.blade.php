@extends('vendor.layouts.app')
@section('title', 'لوحة التحكم')

@section('content')

{{-- Welcome bar --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold mb-0">مرحباً، {{ $vendor->name }} 👋</h5>
        <small class="text-muted">{{ now()->format('l، d F Y') }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus me-1"></i> منتج جديد
        </a>
        <a href="{{ route('vendor.orders') }}" class="btn btn-outline-primary btn-sm">
            <i class="mdi mdi-package-variant me-1"></i> الطلبات
        </a>
    </div>
</div>

{{-- ===== Stat cards ===== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-shopping-outline text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">منتجاتي</div>
                    <div class="fw-bold fs-5">{{ $productsCount }}</div>
                    @if($lowStockCount > 0)
                        <div class="text-warning" style="font-size:11px">
                            <i class="mdi mdi-alert-outline"></i> {{ $lowStockCount }} قاربت على النفاذ
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="mdi mdi-package-variant text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">الطلبات</div>
                    <div class="fw-bold fs-5">{{ $ordersCount }}</div>
                    @if($pendingOrdersCount > 0)
                        <div class="text-warning" style="font-size:11px">
                            <i class="mdi mdi-clock-outline"></i> {{ $pendingOrdersCount }} قيد الانتظار
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="mdi mdi-cash text-warning fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">إجمالي المبيعات</div>
                    <div class="fw-bold fs-5">{{ number_format($totalRevenue, 0) }} ر.س</div>
                    <div class="text-muted" style="font-size:11px">هذا الشهر: {{ number_format($monthRevenue, 0) }} ر.س</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="mdi mdi-arrow-u-left-top text-danger fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">طلبات الإرجاع</div>
                    <div class="fw-bold fs-5">{{ $returnsCount }}</div>
                    <div class="text-muted" style="font-size:11px">
                        <span class="badge {{ $vendor->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $vendor->status === 'active' ? 'متجر نشط' : 'قيد المراجعة' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Row 2: Recent orders + Top products ===== --}}
<div class="row g-4 mb-4">

    {{-- Recent orders --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">
                        <i class="mdi mdi-clock-outline me-2 text-primary"></i>
                        آخر الطلبات
                    </h6>
                    <a href="{{ route('vendor.orders') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>التاريخ</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">الإجمالي</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="fw-bold">#{{ $order->number }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $order->orderStatus?->CurrentNameLang ?? '-' }}</span>
                                </td>
                                <td class="text-center fw-bold">{{ $order->total_price }} ر.س</td>
                                <td>
                                    <a href="{{ route('vendor.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">لا توجد طلبات بعد</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top products + Low stock --}}
    <div class="col-lg-5 d-flex flex-column gap-4">

        {{-- Top selling --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="mdi mdi-trending-up me-2 text-success"></i>
                    أكثر المنتجات مبيعاً
                </h6>
                @forelse($topProducts as $item)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $item->product?->image_url }}" style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb" alt="">
                    <div style="flex:1">
                        <div class="fw-semibold" style="font-size:13px">{{ $item->product?->name ?? '-' }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $item->total_quantity }} قطعة مباعة</div>
                    </div>
                    <div class="fw-bold text-success" style="font-size:13px">{{ number_format($item->total_revenue, 0) }} ر.س</div>
                </div>
                @empty
                <p class="text-muted small text-center py-2">لا توجد مبيعات بعد</p>
                @endforelse
            </div>
        </div>

        {{-- Low stock alert --}}
        @if($lowStockProducts->count())
        <div class="card border-0 shadow-sm border-warning border-start border-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-warning">
                    <i class="mdi mdi-alert-outline me-2"></i>
                    منتجات قاربت على النفاذ
                </h6>
                @foreach($lowStockProducts as $product)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ $product->image_url }}" style="width:32px;height:32px;object-fit:cover;border-radius:6px" alt="">
                        <span style="font-size:13px">{{ $product->name }}</span>
                    </div>
                    <span class="badge bg-warning text-dark">{{ $product->quantity }} متبقي</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ===== Row 3: Order status breakdown --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="fw-bold mb-4">
            <i class="mdi mdi-chart-donut me-2 text-primary"></i>
            توزيع حالات الطلبات
        </h6>
        <div class="row g-3">
            @foreach($orderStatusBreakdown as $status => $count)
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 text-center" style="background:#f8f9fb; border:1px solid #e5e7eb">
                    <div class="fw-bold fs-4 text-primary">{{ $count }}</div>
                    <div class="text-muted small">{{ $status }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
