@extends('vendor.layouts.app')
@section('title', 'منتجاتي')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">منتجاتي ({{ $products->total() }})</h5>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus me-1"></i> إضافة منتج
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>المنتج</th>
                    <th>القسم</th>
                    <th class="text-center">السعر</th>
                    <th class="text-center">الكمية</th>
                    <th class="text-center">الحالة</th>
                    <th class="text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb">
                            <div>
                                <div class="fw-semibold" style="font-size:14px">{{ $product->name }}</div>
                                <small class="text-muted">{{ $product->slug }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $product->parent?->name ?? '-' }}</td>
                    <td class="text-center">
                        @if($product->discount_price)
                            <del class="text-muted small">{{ $product->price }}</del>
                            <span class="text-danger fw-bold ms-1">{{ $product->discount_price }} ر.س</span>
                        @else
                            <span class="fw-bold">{{ $product->price }} ر.س</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $product->quantity > 5 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->status === 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">لا توجد منتجات بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
