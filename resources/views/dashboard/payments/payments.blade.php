@extends('dashboard.index')
@section('title', 'المدفوعات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">المدفوعات</li>
@endsection

@section('section')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            <i class="mdi mdi-credit-card-outline me-2 text-primary"></i>
            سجل المدفوعات
        </h4>
        <small class="text-muted">مدفوعات Moyasar</small>
    </div>
    <a href="{{ route('front_settings') }}" class="btn btn-outline-secondary btn-sm">
        <i class="mdi mdi-cog-outline me-1"></i>
        إعدادات بوابة الدفع
    </a>
</div>

@if(isset($error))
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="mdi mdi-alert-outline fs-5"></i>
    <div>{{ $error }}</div>
</div>
@endif

{{-- Stats row --}}
@if($payments->count())
@php
    $paidCount   = collect($payments->items())->where('status', 'paid')->count();
    $failedCount = collect($payments->items())->where('status', 'failed')->count();
    $totalAmount = collect($payments->items())->where('status', 'paid')->sum(fn($p) => $p['amount'] / 100);
@endphp
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="mdi mdi-check-circle-outline text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">مدفوعات ناجحة</div>
                    <div class="fw-bold fs-5">{{ $paidCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="mdi mdi-close-circle-outline text-danger fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">مدفوعات فاشلة</div>
                    <div class="fw-bold fs-5">{{ $failedCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-cash-multiple text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">إجمالي المحصّل</div>
                    <div class="fw-bold fs-5">{{ number_format($totalAmount, 2) }} ر.س</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">معرّف الدفعة</th>
                        <th>الوصف</th>
                        <th>طريقة الدفع</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">المبلغ</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td class="ps-4">
                            <code style="font-size:12px; color:#374151">{{ Str::limit($payment['id'], 20) }}</code>
                        </td>
                        <td style="font-size:13px; max-width:200px">
                            {{ $payment['description'] ?? '—' }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border" style="font-size:11px">
                                {{ strtoupper($payment['source']['type'] ?? '—') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($payment['status'] === 'paid')
                                <span class="badge bg-success">مدفوع</span>
                            @elseif($payment['status'] === 'failed')
                                <span class="badge bg-danger">فاشل</span>
                            @elseif($payment['status'] === 'initiated')
                                <span class="badge bg-warning text-dark">قيد التنفيذ</span>
                            @else
                                <span class="badge bg-secondary">{{ $payment['status'] }}</span>
                            @endif
                        </td>
                        <td class="text-center fw-bold" style="color:#1a237e">
                            {{ number_format($payment['amount'] / 100, 2) }} ر.س
                        </td>
                        <td style="font-size:12px; color:#6b7280">
                            {{ \Carbon\Carbon::parse($payment['created_at'])->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="mdi mdi-credit-card-off-outline d-block fs-1 mb-2"></i>
                            لا توجد مدفوعات بعد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
