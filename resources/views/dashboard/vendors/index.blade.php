@extends('dashboard.index')
@section('title', 'إدارة البائعين')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">البائعون</li>
@endsection

@section('section')

@php
    $statusFilter = request('status', 'all');
    $counts = [
        'all'       => \App\Models\Company::where('is_vendor', true)->count(),
        'active'    => \App\Models\Company::where('is_vendor', true)->where('status', 'active')->count(),
        'pending'   => \App\Models\Company::where('is_vendor', true)->where('status', 'pending')->count(),
        'suspended' => \App\Models\Company::where('is_vendor', true)->where('status', 'suspended')->count(),
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">
        <i class="mdi mdi-store-outline me-2 text-primary"></i>
        البائعون
    </h4>
    @if($counts['pending'] > 0)
    <div class="alert alert-warning border-0 shadow-sm mb-0 py-2 px-3 d-flex align-items-center gap-2">
        <i class="mdi mdi-clock-alert-outline"></i>
        <span>{{ $counts['pending'] }} بائع بانتظار الموافقة</span>
        <a href="{{ route('vendors.index', ['status' => 'pending']) }}" class="btn btn-warning btn-sm ms-2">مراجعة</a>
    </div>
    @endif
</div>

<x-alert type="success"/>
<x-alert type="dark"/>

{{-- Status tabs --}}
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $statusFilter === 'all' ? 'active' : '' }}" href="{{ route('vendors.index') }}">
            الكل <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $statusFilter === 'active' ? 'active' : '' }}" href="{{ route('vendors.index', ['status' => 'active']) }}">
            نشط <span class="badge bg-success ms-1">{{ $counts['active'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $statusFilter === 'pending' ? 'active' : '' }}" href="{{ route('vendors.index', ['status' => 'pending']) }}">
            قيد المراجعة
            @if($counts['pending'] > 0)
                <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $statusFilter === 'suspended' ? 'active' : '' }}" href="{{ route('vendors.index', ['status' => 'suspended']) }}">
            موقوف <span class="badge bg-danger ms-1">{{ $counts['suspended'] }}</span>
        </a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>البائع</th>
                    <th>البريد الإلكتروني</th>
                    <th class="text-center">المنتجات</th>
                    <th class="text-center">الحالة</th>
                    <th class="text-center">تاريخ التسجيل</th>
                    <th class="text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr class="{{ $vendor->status === 'pending' ? 'table-warning' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($vendor->image)
                                <img src="{{ $vendor->image_url }}" class="rounded-circle border" style="width:40px;height:40px;object-fit:cover;flex-shrink:0" alt="">
                            @else
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary"
                                     style="width:40px;height:40px;flex-shrink:0">
                                    {{ strtoupper(substr($vendor->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ $vendor->name }}</div>
                                <small class="text-muted">{{ $vendor->phone }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small" dir="ltr">{{ $vendor->email }}</td>
                    <td class="text-center"><span class="badge bg-primary">{{ $vendor->products_count }}</span></td>
                    <td class="text-center">
                        @if($vendor->status === 'active')
                            <span class="badge bg-success">نشط</span>
                        @elseif($vendor->status === 'pending')
                            <span class="badge bg-warning text-dark">قيد المراجعة</span>
                        @else
                            <span class="badge bg-danger">موقوف</span>
                        @endif
                    </td>
                    <td class="text-center text-muted small">{{ $vendor->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            @if($vendor->status !== 'active')
                            <form method="POST" action="{{ route('vendors.approve', $vendor->id) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-success" title="تفعيل">
                                    <i class="mdi mdi-check"></i> تفعيل
                                </button>
                            </form>
                            @endif
                            @if($vendor->status === 'active')
                            <form method="POST" action="{{ route('vendors.suspend', $vendor->id) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-warning" title="إيقاف">
                                    <i class="mdi mdi-pause"></i>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('vendors.destroy', $vendor->id) }}"
                                  onsubmit="return confirm('حذف هذا البائع نهائياً؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">
                    <i class="mdi mdi-store-off-outline d-block mb-2" style="font-size:40px;opacity:0.3"></i>
                    لا يوجد بائعون في هذه الفئة
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vendors->hasPages())
    <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
        {{ $vendors->links() }}
    </div>
    @endif
</div>

@endsection
