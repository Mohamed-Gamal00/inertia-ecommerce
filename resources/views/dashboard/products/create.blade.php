@extends('dashboard.index')

@section('title', 'إنشاء منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item active">إنشاء منتج</li>
@endsection

@section('section')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4">
    <i class="mdi mdi-alert-circle-outline me-2"></i>
    <strong>يرجى تصحيح الأخطاء التالية:</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form class="repeater" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
@csrf

<div class="row g-4">

    {{-- ══════════════════════════════════════
         LEFT COLUMN: Main info + Media
    ══════════════════════════════════════ --}}
    <div class="col-lg-8">

        {{-- Basic Info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-information-outline me-2 text-primary"></i>
                المعلومات الأساسية
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">اسم المنتج <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="اسم المنتج بالعربي" />
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">اسم المنتج بالإنجليزية</label>
                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                            value="{{ old('name_en') }}" placeholder="Product name in English" dir="ltr" />
                        @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" rows="4" class="form-control"
                            placeholder="وصف تفصيلي للمنتج...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing & Stock --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-cash-multiple me-2 text-primary"></i>
                السعر والمخزون
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">السعر <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="price" step="0.01" min="0"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}" placeholder="0.00" />
                            <span class="input-group-text">ر.س</span>
                        </div>
                        @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">سعر الخصم</label>
                        <div class="input-group">
                            <input type="number" name="discount_price" step="0.01" min="0"
                                class="form-control" value="{{ old('discount_price') }}" placeholder="0.00" />
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الكمية <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" min="0"
                            class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity') }}" placeholder="0" />
                        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الوزن (كجم)</label>
                        <div class="input-group">
                            <input type="number" name="weight" step="0.01" min="0"
                                class="form-control" value="{{ old('weight') }}" placeholder="0.00" />
                            <span class="input-group-text">كجم</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Image + Gallery --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-image-multiple-outline me-2 text-primary"></i>
                الصور
            </div>
            <div class="card-body">
                {{-- Main image --}}
                <label class="form-label fw-semibold">الصورة الرئيسية <span class="text-danger">*</span></label>
                <div class="d-flex align-items-start gap-4 mb-4">
                    <div class="main-img-preview-wrap">
                        <img id="mainImgPreview" src="{{ asset('assets/images/upload-image.jpg') }}"
                            class="rounded border" style="width:120px; height:120px; object-fit:cover" />
                    </div>
                    <div class="flex-grow-1">
                        <input type="file" name="image" id="mainImageInput" class="form-control @error('image') is-invalid @enderror"
                            accept="image/*" onchange="previewMainImage(event)" />
                        <div class="form-text">PNG, JPG, WEBP — الحد الأقصى 2MB</div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Gallery --}}
                <label class="form-label fw-semibold">صور إضافية</label>
                <div class="image-upload-container d-flex flex-wrap gap-2 mb-2" id="galleryContainer"></div>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="addProductImageUpload()">
                    <i class="mdi mdi-plus me-1"></i> إضافة صورة
                </button>
            </div>
        </div>

        {{-- Features repeater --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-format-list-checks me-2 text-primary"></i>
                مميزات المنتج <span class="text-muted fw-normal" style="font-size:12px">(اختياري)</span>
            </div>
            <div class="card-body">
                <div data-repeater-list="product_features">
                    <div class="row g-2 align-items-end mb-3 feature-row" data-repeater-item>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">اسم الميزة</label>
                            <input type="text" name="feature_name" class="form-control form-control-sm"
                                placeholder="مثال: المادة" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">الاسم بالإنجليزية</label>
                            <input type="text" name="feature_name_en" class="form-control form-control-sm"
                                placeholder="e.g. Material" dir="ltr" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">القيمة</label>
                            <input type="text" name="feature_description" class="form-control form-control-sm"
                                placeholder="مثال: قطن 100%" />
                        </div>
                        <div class="col-md-2">
                            <input data-repeater-delete type="button" class="btn btn-outline-danger btn-sm w-100" value="حذف" />
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-outline-primary btn-sm"
                    value="+ إضافة ميزة" />
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         RIGHT COLUMN: Settings
    ══════════════════════════════════════ --}}
    <div class="col-lg-4">

        {{-- Publish --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-publish me-2 text-primary"></i>
                النشر
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold">حالة النشاط</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" selected>نشط</option>
                        <option value="archived">غير نشط</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label fw-semibold">نوع المنتج</label>
                    <select name="is_special" class="form-select">
                        <option value="0" selected>عادي</option>
                        <option value="1">مميز</option>
                    </select>
                </div>
                <div>
                    <label class="form-label fw-semibold">حالة التوفر</label>
                    <select name="product_availability_id" class="form-select">
                        <option value="" disabled selected>اختر حالة التوفر</option>
                        @foreach($availability_status as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <i class="mdi mdi-content-save me-1"></i>
                    حفظ المنتج
                </button>
            </div>
        </div>

        {{-- Category --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-shape-outline me-2 text-primary"></i>
                التصنيف
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold">القسم <span class="text-danger">*</span></label>
                    @php
                        function getSubCategories($subCategories, $prefix = '') {
                            $html = '';
                            foreach ($subCategories as $category) {
                                $html .= '<option value="' . $category->id . '">' . $prefix . $category->name . '</option>';
                                if ($category->children->isNotEmpty()) {
                                    $html .= getSubCategories($category->children, $prefix . $category->name . ' / ');
                                }
                            }
                            return $html;
                        }
                    @endphp
                    <select name="parent_id" id="category" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">اختر القسم</option>
                        {!! getSubCategories($subCategories) !!}
                    </select>
                    @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($companies)
                <div>
                    <label class="form-label fw-semibold">البراند</label>
                    <select name="company_id" class="form-select">
                        <option value="">بدون براند</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->CurrentNameLang }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>

        {{-- Colors & Choices --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-palette-outline me-2 text-primary"></i>
                الألوان والخيارات
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold">الألوان</label>
                    <select name="colors[]" id="subcategory1" class="form-select multi-select" multiple>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label fw-semibold">الخيارات</label>
                    <select name="choice_id[]" id="choices" class="form-select multi-select" multiple></select>
                </div>
            </div>
        </div>

    </div>
</div>

</form>

{{-- ── Styles ── --}}
<style>
.main-img-preview-wrap img { transition: opacity 0.2s; }
.feature-row { background: #f8f9fb; border-radius: 8px; padding: 10px; }
</style>

{{-- ── Scripts ── --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.multi-select').select2({ width: '100%' });

    // Load choices on page load
    $.get('{{ route('fetch.choices') }}', function (response) {
        response.forEach(function (choice) {
            $('#choices').append('<option value="' + choice.id + '">' + choice.name + '</option>');
        });
        $('#choices').trigger('change.select2');
    });
});

function previewMainImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('mainImgPreview').src = e.target.result;
    reader.readAsDataURL(file);
}

let uploadIndex = 1;
function addProductImageUpload() {
    const idx = uploadIndex++;
    const wrap = document.createElement('div');
    wrap.id = 'gallery-' + idx;
    wrap.style.cssText = 'position:relative; width:90px; height:90px;';
    wrap.innerHTML = `
        <label style="cursor:pointer; display:block; width:100%; height:100%;">
            <img id="gp-${idx}" src="{{ asset('assets/images/upload-image.jpg') }}"
                style="width:100%; height:100%; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb;" />
            <input type="file" hidden name="header[${idx}][image]" accept="image/*"
                onchange="previewGallery(event, ${idx})" />
        </label>
        <button type="button" onclick="removeGallery(${idx})"
            style="position:absolute; top:-6px; right:-6px; width:20px; height:20px; border-radius:50%;
                   background:#ef4444; color:white; border:none; cursor:pointer; font-size:12px; line-height:1;
                   display:flex; align-items:center; justify-content:center;">×</button>`;
    document.getElementById('galleryContainer').appendChild(wrap);
}

function previewGallery(event, idx) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('gp-' + idx).src = e.target.result;
    reader.readAsDataURL(event.target.files[0]);
}

function removeGallery(idx) {
    document.getElementById('gallery-' + idx)?.remove();
}

window.onload = () => addProductImageUpload();
</script>

@push('scripts')
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
@endpush

@endsection
