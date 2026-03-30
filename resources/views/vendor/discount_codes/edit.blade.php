@extends('vendor.layouts.app')
@section('title', 'تعديل كوبون خصم')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 4px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@section('content')

<div class="mb-4">
    <a href="{{ route('vendor.discount_code.index') }}" class="btn btn-link text-decoration-none p-0 text-muted">
        <i class="mdi mdi-arrow-right me-1"></i> العودة للقائمة
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">تعديل الكوبون: {{ $discountCode->name }}</h5>

        <form action="{{ route('vendor.discount_code.update', $discountCode->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اسم الكوبون</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $discountCode->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">كود الخصم</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $discountCode->code) }}">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">نوع الخصم</label>
                    <div class="d-flex gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="discount_type" id="type_percentage" value="percentage" {{ old('discount_type', $discountCode->discount_type) == 'percentage' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_percentage">نسبة مئوية (%)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="discount_type" id="type_price" value="price" {{ old('discount_type', $discountCode->discount_type) == 'price' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_price">مبلغ ثابت (ر.س)</label>
                        </div>
                    </div>
                    @error('discount_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">قيمة الخصم</label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $discountCode->price) }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">عدد مرات الاستخدام القصوى</label>
                    <input type="number" name="number_of_used" class="form-control @error('number_of_used') is-invalid @enderror" value="{{ old('number_of_used', $discountCode->number_of_used) }}">
                    @error('number_of_used') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">حالة الكوبون</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $discountCode->status == 1 ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ old('status', $discountCode->status == 1 ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">المنتجات المشمولة</label>
                    <select name="product_ids[]" class="form-select product-select @error('product_ids') is-invalid @enderror" multiple>
                        @foreach($discountCode->products as $p)
                            <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">إذا لم يتم اختيار منتجات، سيطبق الكوبون على جميع منتجاتك المعروضة.</div>
                    @error('product_ids') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-5 border-top pt-4">
                <button type="submit" class="btn btn-primary px-5">تحديث الكوبون</button>
                <a href="{{ route('vendor.discount_code.index') }}" class="btn btn-light px-4 ms-2">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.product-select').select2({
            placeholder: 'اختر المنتجات',
            ajax: {
                url: '{{ route('vendor.discount_code.search-products') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    });
</script>
@endpush
