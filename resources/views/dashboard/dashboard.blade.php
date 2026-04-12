@extends('dashboard.index')
@section('title', 'لوحة التحكم')

@section('section')

{{-- ══════════════════════════════════════════════
     Welcome bar
══════════════════════════════════════════════ --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold">مرحباً، {{ auth()->guard('admin')->user()->name ?? 'المدير' }} 👋</h4>
        <p class="text-muted mb-0" style="font-size:13px">
            {{ now()->format('l، d F Y') }} —
            <span class="text-primary fw-semibold">{{ $pendingOrders }} طلب بانتظار المعالجة</span>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus me-1"></i> منتج جديد
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="mdi mdi-clipboard-list-outline me-1"></i> الطلبات
        </a>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     KPI Cards Row 1
══════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:44px;height:44px;background:#e8f5e9">
                        <i class="mdi mdi-cash-multiple text-success fs-5"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size:11px">إجمالي</span>
                </div>
                <div class="fw-bold" style="font-size:22px;color:#111827">
                    {{ number_format($totalRevenue, 0) }}
                    <small class="text-muted fw-normal" style="font-size:12px">{{ $mainCurrency->name_ar ?? 'ر.س' }}</small>
                </div>
                <div class="text-muted" style="font-size:12px">إجمالي الإيرادات المحصّلة</div>
                @if($todayRevenue > 0)
                <div class="mt-2 text-success" style="font-size:12px">
                    <i class="mdi mdi-trending-up me-1"></i>
                    +{{ number_format($todayRevenue, 0) }} اليوم
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:44px;height:44px;background:#e3f2fd">
                        <i class="mdi mdi-package-variant-closed text-primary fs-5"></i>
                    </div>
                    @php $orderDiff = $thisMonthOrders - $lastMonthOrders; @endphp
                    <span class="badge {{ $orderDiff >= 0 ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger' }}" style="font-size:11px">
                        {{ $orderDiff >= 0 ? '+' : '' }}{{ $orderDiff }} عن الشهر الماضي
                    </span>
                </div>
                <div class="fw-bold" style="font-size:22px;color:#111827">{{ number_format($ordersCount) }}</div>
                <div class="text-muted" style="font-size:12px">إجمالي الطلبات</div>
                <div class="mt-2 text-primary" style="font-size:12px">
                    <i class="mdi mdi-calendar-month-outline me-1"></i>
                    {{ $thisMonthOrders }} هذا الشهر
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:44px;height:44px;background:#fce4ec">
                        <i class="mdi mdi-account-group-outline" style="color:#e91e63;font-size:20px"></i>
                    </div>
                    <a href="{{ route('clients.index') }}" class="text-muted" style="font-size:11px">عرض الكل ←</a>
                </div>
                <div class="fw-bold" style="font-size:22px;color:#111827">{{ number_format($usersCount) }}</div>
                <div class="text-muted" style="font-size:12px">إجمالي العملاء المسجلين</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:44px;height:44px;background:#fff3e0">
                        <i class="mdi mdi-shopping-outline" style="color:#ff9800;font-size:20px"></i>
                    </div>
                    @if($outOfStockCount > 0)
                    <span class="badge bg-danger" style="font-size:11px">{{ $outOfStockCount }} نفذت</span>
                    @endif
                </div>
                <div class="fw-bold" style="font-size:22px;color:#111827">{{ number_format($productsCount) }}</div>
                <div class="text-muted" style="font-size:12px">إجمالي المنتجات</div>
                @if($outOfStockCount > 0)
                <div class="mt-2 text-danger" style="font-size:12px">
                    <i class="mdi mdi-alert-outline me-1"></i>
                    {{ $outOfStockCount }} منتج نفذت كميته
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════
     Sales Chart + Order Status
══════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    {{-- Sales chart --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <div class="fw-bold">
                    <i class="mdi mdi-chart-line me-2 text-primary"></i>
                    المبيعات — آخر 7 أيام
                </div>
                <span class="text-muted" style="font-size:12px">{{ $mainCurrency->name_ar ?? 'ر.س' }}</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Order status breakdown --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-chart-donut me-2 text-primary"></i>
                حالات الطلبات (30 يوم)
            </div>
            <div class="card-body">
                @forelse($ordersByStatus as $status)
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:13px; color:#374151">{{ $status->name }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="progress" style="width:80px; height:6px; border-radius:3px">
                            @php $pct = $ordersCount > 0 ? ($status->total / $ordersCount) * 100 : 0; @endphp
                            <div class="progress-bar bg-primary" style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="fw-bold" style="font-size:13px; min-width:24px; text-align:left">{{ $status->total }}</span>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:13px">لا توجد بيانات</p>
                @endforelse

                <div class="border-top pt-3 mt-2">
                    <div class="d-flex justify-content-between" style="font-size:12px; color:#6b7280">
                        <span>المرتجعات</span>
                        <span class="fw-bold text-danger">{{ $returnsCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-1" style="font-size:12px; color:#6b7280">
                        <span>بانتظار المعالجة</span>
                        <span class="fw-bold text-warning">{{ $pendingOrders }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════
     Latest Orders + Top Products + Low Stock
══════════════════════════════════════════════ --}}
<div class="row g-3">

    {{-- Latest orders --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <div class="fw-bold">
                    <i class="mdi mdi-clipboard-list-outline me-2 text-primary"></i>
                    آخر الطلبات
                </div>
                <a href="{{ route('orders.index') }}" class="text-primary" style="font-size:12px">عرض الكل ←</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="font-size:12px">رقم الطلب</th>
                                <th style="font-size:12px">العميل</th>
                                <th style="font-size:12px">الإجمالي</th>
                                <th style="font-size:12px">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                            <tr>
                                <td class="ps-3">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="fw-bold text-primary text-decoration-none" style="font-size:13px">
                                        #{{ $order->number }}
                                    </a>
                                    <div class="text-muted" style="font-size:11px">{{ $order->created_at->diffForHumans() }}</div>
                                </td>
                                <td style="font-size:13px">{{ $order->customer_name }}</td>
                                <td class="fw-bold" style="font-size:13px; color:#1a237e">
                                    {{ number_format($order->total_price, 0) }}
                                </td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success" style="font-size:10px">مدفوع</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge bg-danger" style="font-size:10px">فاشل</span>
                                    @else
                                        <span class="badge bg-warning text-dark" style="font-size:10px">معلق</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">لا توجد طلبات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top products + Low stock --}}
    <div class="col-lg-6">
        <div class="row g-3 h-100">

            {{-- Top selling --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-fire me-2 text-danger"></i>
                        الأكثر مبيعاً
                    </div>
                    <div class="card-body py-2">
                        @forelse($topProducts as $i => $p)
                        <div class="d-flex align-items-center justify-content-between py-2
                            {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width:24px;height:24px;background:#e8eaf6;color:#1a237e;font-size:11px">
                                    {{ $i + 1 }}
                                </span>
                                <span style="font-size:13px; color:#374151">{{ Str::limit($p->name, 30) }}</span>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size:11px">
                                {{ $p->sold }} مبيعة
                            </span>
                        </div>
                        @empty
                        <p class="text-muted text-center py-2 mb-0" style="font-size:13px">لا توجد بيانات</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Low stock --}}
            @if($lowStockProducts->count())
            <div class="col-12">
                <div class="card border-0 shadow-sm border-warning" style="border-right: 3px solid #f59e0b !important">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-alert-outline me-2 text-warning"></i>
                        منتجات تقترب من النفاذ
                    </div>
                    <div class="card-body py-2">
                        @foreach($lowStockProducts as $p)
                        <div class="d-flex align-items-center justify-content-between py-2
                            {{ !$loop->last ? 'border-bottom' : '' }}">
                            <span style="font-size:13px; color:#374151">{{ Str::limit($p->name, 32) }}</span>
                            <span class="badge {{ $p->quantity <= 2 ? 'bg-danger' : 'bg-warning text-dark' }}" style="font-size:11px">
                                {{ $p->quantity }} متبقي
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

{{-- ══ Chart.js ══ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($salesChart);
    const ctx  = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.label),
            datasets: [{
                label: 'الإيرادات',
                data: data.map(d => d.total),
                backgroundColor: 'rgba(57,73,171,0.15)',
                borderColor: '#3949ab',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }, {
                label: 'عدد الطلبات',
                data: data.map(d => d.count),
                type: 'line',
                borderColor: '#ef4444',
                backgroundColor: 'transparent',
                borderWidth: 2,
                pointBackgroundColor: '#ef4444',
                pointRadius: 4,
                tension: 0.4,
                yAxisID: 'y2',
            }]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12 }, boxWidth: 12 } },
                tooltip: { rtl: true, textDirection: 'rtl' },
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: {
                    position: 'right',
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { font: { size: 11 } },
                },
                y2: {
                    position: 'left',
                    grid: { display: false },
                    ticks: { font: { size: 11 }, stepSize: 1 },
                },
            }
        }
    });
});
</script>

@endsection
