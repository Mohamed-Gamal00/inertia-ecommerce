@extends('dashboard.index')
@section('title', 'إدارة البائعين')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">البائعون</li>
@endsection

@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="mdi mdi-store-outline me-2 text-primary"></i>
        البائعون ({{ $vendors->total() }})
    </h4>
</div>

<x-alert type="success"/>
<x-alert type="dark"/>

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
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary"
                                 style="width:40px;height:40px;flex-shrink:0">
                                {{ strtoupper(substr($vendor->name, 0, 1)) }}
                            </div>
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
                                    <i class="mdi mdi-check"></i>
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
                                  onsubmit="return confirm('حذف هذا البائع؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">لا يوجد بائعون مسجلون</td></tr>
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
