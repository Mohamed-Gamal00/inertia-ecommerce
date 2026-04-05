@extends('dashboard.index')
@section('title', 'المدفوعات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">المدفوعات</li>
@endsection

@section('section')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-0 fw-bold">
            <i class="mdi mdi-credit-card-outline me-2 text-primary"></i>
            سجل المعاملات المالية
        </h4>
        <small class="text-muted">جميع عمليات الدفع المسجلة في قاعدة البيانات</small>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="mdi mdi-cash-check text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">إجمالي المحصّل</div>
                    <div class="fw-bold fs-5">{{ number_format($stats['total_paid'], 2) }} ر.س</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-check-circle-outline text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">مدفوعات ناجحة</div>
                    <div class="fw-bold fs-5">{{ $stats['paid_count'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="mdi mdi-close-circle-outline text-danger fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">مدفوعات فاشلة</div>
                    <div class="fw-bold fs-5">{{ $stats['failed_count'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="mdi mdi-calendar-today text-warning fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">إيرادات اليوم</div>
                    <div class="fw-bold fs-5">{{ number_format($stats['today_paid'], 2) }} ر.س</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('payments.index') }}" class="d-flex gap-2 flex-wrap align-items-end">
            <div>
                <label class="form-label small fw-semibold mb-1">بحث</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="رقم الطلب أو معرّف الدفعة..."
                    value="{{ request('search') }}" style="min-width:220px" />
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1">الحالة</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">جميع الحالات</option>
                    <option value="paid"      @selected(request('status') === 'paid')>مدفوع</option>
                    <option value="failed"    @selected(request('status') === 'failed')>فاشل</option>
                    <option value="initiated" @selected(request('status') === 'initiated')>قيد التنفيذ</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="mdi mdi-magnify me-1"></i> بحث
            </button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary btn-sm">مسح</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>رقم الطلب</th>
                        <th>معرّف Moyasar</th>
                        <th>طريقة الدفع</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">المبلغ</th>
                        <th>التاريخ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $tx->id }}</td>
                        <td>
                            @if($tx->order)
                            <a href="{{ route('orders.show', $tx->order->id) }}"
                                class="fw-bold text-primary text-decoration-none">
                                #{{ $tx->order->number }}
                            </a>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <code style="font-size:11px; color:#374151">
                                {{ $tx->moyasar_payment_id ? Str::limit($tx->moyasar_payment_id, 24) : '—' }}
                            </code>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                @if($tx->payment_method === 'creditcard')
                                    <i class="mdi mdi-credit-card-outline text-muted"></i>
                                @elseif($tx->payment_method === 'stcpay')
                                    <i class="mdi mdi-cellphone text-muted"></i>
                                @endif
                                <span style="font-size:12px">
                                    {{ $tx->card_brand ? strtoupper($tx->card_brand) : ($tx->payment_method ?? '—') }}
                                    @if($tx->card_last_four)
                                        <span class="text-muted">•••• {{ $tx->card_last_four }}</span>
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $tx->status_color }}">{{ $tx->status_label }}</span>
                        </td>
                        <td class="text-center fw-bold" style="color:#1a237e">
                            {{ number_format($tx->amount, 2) }} ر.س
                        </td>
                        <td style="font-size:12px; color:#6b7280">
                            {{ $tx->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('payments.show', $tx->id) }}"
                                class="btn btn-sm btn-outline-secondary" title="تفاصيل">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="mdi mdi-credit-card-off-outline d-block fs-1 mb-2"></i>
                            لا توجد معاملات مالية بعد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
