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
        <div class="card border-0 shadow-sm">
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
    </div>

    {{-- Products --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
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
    </div>
</div>

@endsection
