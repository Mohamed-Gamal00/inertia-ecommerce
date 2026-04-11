@extends('vendor.layouts.app')
@section('title', 'طلبات الإرجاع')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">طلبات الإرجاع ({{ $orders->total() }})</h5>
        <p class="text-muted small mb-0 mt-1">عندما يطلب العميل إرجاعاً للطلب يظهر هنا ويصلك تنبيه.</p>
    </div>
    <a href="{{ route('vendor.orders') }}" class="btn btn-outline-secondary btn-sm">كل الطلبات</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>رقم الطلب</th>
                    <th>التاريخ</th>
                    <th>العميل</th>
                    <th class="text-center">الحالة</th>
                    <th class="text-center">الإجمالي</th>
                    <th class="text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php $addr = $order->addresses->first(); @endphp
                <tr>
                    <td class="fw-bold">
                        #{{ $order->number }}
                        <span class="badge bg-warning text-dark ms-1">إرجاع</span>
                    </td>
                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($addr)
                            <div class="fw-semibold" style="font-size:13px">{{ $addr->first_name }} {{ $addr->last_name }}</div>
                            <small class="text-muted" dir="ltr">{{ $addr->phone_number }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary">{{ $order->orderStatus?->CurrentNameLang ?? '-' }}</span>
                    </td>
                    <td class="text-center fw-bold">{{ $order->total_price }} ر.س</td>
                    <td class="text-center">
                        <a href="{{ route('vendor.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-eye"></i> عرض
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">لا توجد طلبات إرجاع بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
