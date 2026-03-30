@extends('vendor.layouts.app')
@section('title', 'تقارير المبيعات')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col">
        <h5 class="fw-bold mb-0">تقارير المبيعات</h5>
    </div>
    <div class="col-auto">
        <form class="row g-2 align-items-center" method="GET">
            <div class="col-auto">
                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $start_date }}">
            </div>
            <div class="col-auto text-muted small">إلى</div>
            <div class="col-auto">
                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $end_date }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm px-3">تصفية</button>
            </div>
            @if($start_date || $end_date)
                <div class="col-auto">
                    <a href="{{ route('vendor.reports.index') }}" class="btn btn-light btn-sm">إعادة تعيين</a>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">إجمالي الإيرادات</div>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['total_revenue'], 2) }} ر.س</h3>
                    </div>
                    <i class="mdi mdi-cash-multiple fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">إجمالي الطلبات</div>
                        <h3 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h3>
                    </div>
                    <i class="mdi mdi-package-variant-closed fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small mb-1">المنتجات المباعة</div>
                        <h3 class="fw-bold mb-0">{{ $stats['total_items_sold'] }}</h3>
                    </div>
                    <i class="mdi mdi-cart-outline fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">نشاط المبيعات (آخر 30 يوم)</h6>
                <div style="height: 300px; display: flex; align-items: flex-end; gap: 8px;" class="px-2">
                    @php
                        $maxRevenue = $salesOverTime->max('revenue') ?: 1;
                    @endphp
                    @foreach($salesOverTime as $sale)
                        <div class="bg-primary bg-opacity-75 rounded-top"
                             style="flex: 1; height: {{ ($sale->revenue / $maxRevenue) * 100 }}%;"
                             title="{{ $sale->date }}: {{ $sale->revenue }} ر.س">
                        </div>
                    @endforeach
                    @if($salesOverTime->isEmpty())
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                            لا توجد بيانات كافية لعرض المخطط
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between mt-3 text-muted small px-2">
                    <span>{{ now()->subDays(30)->format('d/m') }}</span>
                    <span>{{ now()->format('d/m') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">الأكثر مبيعاً</h6>
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $tp)
                        <div class="list-group-item px-0 border-0 mb-3 d-flex align-items-center gap-3">
                            <div class="rounded border p-1" style="width: 48px; height: 48px;">
                                <img src="{{ $tp->product->image_url }}" class="w-100 h-100 object-fit-cover rounded">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="text-truncate fw-semibold small">{{ $tp->product->name }}</div>
                                <div class="text-muted small">{{ $tp->total_quantity }} قطعة</div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold small">{{ number_format($tp->total_revenue, 2) }}</span>
                                <div class="text-muted" style="font-size: 10px;">ر.س</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted small">لا توجد بيانات مبيعات</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
