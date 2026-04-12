@extends('vendor.layouts.app')
@section('title', 'عملائي')

@section('breadcrumb')
    <li class="breadcrumb-item active">عملائي</li>
@endsection

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="mdi mdi-account-group-outline me-2 text-primary"></i>
            عملائي ({{ $customers->total() }})
        </h4>
        <small class="text-muted">العملاء الذين اشتروا من متجرك</small>
    </div>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-account-multiple-outline text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">إجمالي العملاء</div>
                    <div class="fw-bold fs-5">{{ $customers->total() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="mdi mdi-repeat text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">عملاء متكررون</div>
                    <div class="fw-bold fs-5">{{ $customers->where('vendor_orders_count', '>', 1)->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Customers table --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>العميل</th>
                    <th>البريد الإلكتروني</th>
                    <th class="text-center">عدد الطلبات</th>
                    <th class="text-center">إجمالي الإنفاق</th>
                    <th class="text-center">آخر طلب</th>
                    <th class="text-center">تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary"
                                 style="width:40px;height:40px;flex-shrink:0;font-size:15px">
                                {{ strtoupper(substr($customer->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $customer->first_name }} {{ $customer->family_name }}</div>
                                <small class="text-muted" dir="ltr">{{ $customer->phone_number }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small" dir="ltr">{{ $customer->email }}</td>
                    <td class="text-center">
                        <span class="badge {{ $customer->vendor_orders_count > 1 ? 'bg-success' : 'bg-primary' }}">
                            {{ $customer->vendor_orders_count }}
                            {{ $customer->vendor_orders_count > 1 ? 'طلبات' : 'طلب' }}
                        </span>
                    </td>
                    <td class="text-center fw-bold text-primary">
                        {{ number_format($revenueByUser[$customer->id] ?? 0, 0) }} ر.س
                    </td>
                    <td class="text-center text-muted small">
                        {{ $customer->orders->first()?->created_at?->format('d/m/Y') ?? '-' }}
                    </td>
                    <td class="text-center text-muted small">
                        {{ $customer->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="mdi mdi-account-off-outline d-block mb-2" style="font-size:40px;opacity:0.3"></i>
                        لا يوجد عملاء بعد
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
        {{ $customers->links() }}
    </div>
    @endif
</div>

@endsection
