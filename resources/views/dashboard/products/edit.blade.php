@extends('dashboard.index')

@section('title', 'تعديل منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item active">تعديل: {{ $product->name }}</li>
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

<form class="repeater" action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('put')

<div class="row g-4">

    {{-- ══════════════════════════════════════
         LEFT COLUMN
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
                            value="{{ old('name', $product->name) }}" />
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">اسم المنتج بالإنجليزية</label>
                        <input type="text" name="name_en" class="form-control"
                            value="{{ old('name_en', $product->name_en) }}" dir="ltr" />
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
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
                                value="{{ old('price', $product->price) }}" />
                            <span class="input-group-text">ر.س</span>
                        </div>
                        @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">سعر الخصم</label>
                        <div class="input-group">
                            <input type="number" name="discount_price" step="0.01" min="0"
                                class="form-control" value="{{ old('discount_price', $product->discount_price) }}" />
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الكمية <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" min="0"
                            class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', $product->quantity) }}" />
                        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الوزن (كجم)</label>
                        <div class="input-group">
                            <input type="number" name="weight" step="0.01" min="0"
                                class="form-control" value="{{ old('weight', $product->weight) }}" />
                            <span class="input-group-text">كجم</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Images --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-image-multiple-outline me-2 text-primary"></i>
                الصور
            </div>
            <div class="card-body">
                {{-- Main image --}}
                <label class="form-label fw-semibold">الصورة الرئيسية</label>
                <div class="d-flex align-items-start gap-4 mb-4">
                    <img id="mainImgPreview" src="{{ $product->image_url }}"
                        class="rounded border" style="width:120px; height:120px; object-fit:cover; flex-shrink:0" />
                    <div class="flex-grow-1">
                        <input type="file" name="image" class="form-control" accept="image/*"
                            onchange="previewMainImage(event)" />
                        <div class="form-text">اتركه فارغاً للإبقاء على الصورة الحالية</div>
                    </div>
                </div>

                {{-- Existing gallery --}}
                @if($product->images->count())
                <label class="form-label fw-semibold">الصور الحالية</label>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($product->images as $image)
                    @if($image->image)
                    <div id="image-{{ $image->id }}" style="position:relative; width:90px; height:90px;">
                        <img src="{{ asset('storage/' . $image->image) }}"
                            style="width:100%; height:100%; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb;" />
                        <button type="button" onclick="confirmProductImageDelete({{ $image->id }})"
                            style="position:absolute; top:-6px; right:-6px; width:20px; height:20px; border-radius:50%;
                                   background:#ef4444; color:white; border:none; cursor:pointer; font-size:12px;
                                   display:flex; align-items:center; justify-content:center;">×</button>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                {{-- Add more --}}
                <label class="form-label fw-semibold">إضافة صور جديدة</label>
                <div class="d-flex flex-wrap gap-2 mb-2" id="galleryContainer"></div>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="addProductImageUpload()">
                    <i class="mdi mdi-plus me-1"></i> إضافة صورة
                </button>
            </div>
        </div>

        {{-- Features --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-format-list-checks me-2 text-primary"></i>
                مميزات المنتج <span class="text-muted fw-normal" style="font-size:12px">(اختياري)</span>
            </div>
            <div class="card-body">
                <div data-repeater-list="product_features">

                    @if(empty($product->features->first()->feature_name))
                    <div class="row g-2 align-items-end mb-3 feature-row" data-repeater-item>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">اسم الميزة</label>
                            <input type="text" name="feature_name" class="form-control form-control-sm" placeholder="مثال: المادة" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">الاسم بالإنجليزية</label>
                            <input type="text" name="feature_name_en" class="form-control form-control-sm" dir="ltr" />
                        </div>
                        <input name="feature_id" hidden />
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">القيمة</label>
                            <input type="text" name="feature_description" class="form-control form-control-sm" />
                        </div>
                        <div class="col-md-2">
                            <input data-repeater-delete type="button" class="btn btn-outline-danger btn-sm w-100" value="حذف" />
                        </div>
                    </div>
                    @endif

                    @foreach($product->features as $feature)
                    <div class="row g-2 align-items-end mb-3 feature-row" data-repeater-item>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">اسم الميزة</label>
                            <input type="text" name="feature_name" class="form-control form-control-sm"
                                value="{{ $feature->feature_name }}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">الاسم بالإنجليزية</label>
                            <input type="text" name="feature_name_en" class="form-control form-control-sm"
                                value="{{ $feature->feature_name_en }}" dir="ltr" />
                        </div>
                        <input name="feature_id" value="{{ $feature->id }}" hidden />
                        <input name="feature_delete" value="{{ $feature->id }}" hidden />
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">القيمة</label>
                            <input type="text" name="feature_description" class="form-control form-control-sm"
                                value="{{ $feature->feature_description }}" />
                        </div>
                        <div class="col-md-2">
                            <input data-repeater-delete type="button" class="btn btn-outline-danger btn-sm w-100" value="حذف" />
                        </div>
                    </div>
                    @endforeach

                </div>
                <input data-repeater-create type="button" class="btn btn-outline-primary btn-sm" value="+ إضافة ميزة" />
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         RIGHT COLUMN
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
                    <select name="status" class="form-select">
                        <option value="active" @selected($product->status == 'active')>نشط</option>
                        <option value="archived" @selected($product->status == 'archived')>غير نشط</option>
                    </select>
                </div>
                <div>
                    <label class="form-label fw-semibold">نوع المنتج</label>
                    <select name="is_special" class="form-select">
                        <option value="0" @selected($product->is_special == 0)>عادي</option>
                        <option value="1" @selected($product->is_special == 1)>مميز</option>
                    </select>
                </div>
                <div>
                    <label class="form-label fw-semibold">حالة التوفر</label>
                    <select name="product_availability_id" class="form-select">
                        <option value="">اختر حالة التوفر</option>
                        @foreach($availability_status as $a)
                            <option value="{{ $a->id }}" @selected($product->product_availability_id == $a->id)>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <i class="mdi mdi-content-save me-1"></i>
                    حفظ التعديلات
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                    إلغاء
                </a>
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
                        function getSubCategoriesEdit($subCategories, $prefix = '', $selectedId = null) {
                            $html = '';
                            foreach ($subCategories as $category) {
                                $sel = $selectedId == $category->id ? 'selected' : '';
                                $html .= '<option value="' . $category->id . '" ' . $sel . '>' . $prefix . $category->name . '</option>';
                                if ($category->children->isNotEmpty()) {
                                    $html .= getSubCategoriesEdit($category->children, $prefix . $category->name . ' / ', $selectedId);
                                }
                            }
                            return $html;
                        }
                    @endphp
                    <select name="parent_id" id="category" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">اختر القسم</option>
                        {!! getSubCategoriesEdit($subCategories, '', $product->category_id) !!}
                    </select>
                    @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($companies)
                <div>
                    <label class="form-label fw-semibold">البراند</label>
                    <select name="company_id" class="form-select">
                        <option value="">بدون براند</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" @selected($product->company_id == $company->id)>
                                {{ $company->CurrentNameLang }}
                            </option>
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
                    <select name="colors[]" id="subcategory" class="form-select multi-select" multiple>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}"
                                {{ in_array($color->id, $productColors) ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label fw-semibold">الخيارات</label>
                    <select name="choice_id[]" id="choices" class="form-select multi-select" multiple>
                        <option></option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

</form>

<style>
.feature-row { background: #f8f9fb; border-radius: 8px; padding: 10px; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.multi-select').select2({ width: '100%' });

    var selectedChoices = @json($productChoices);

    // Load choices based on selected category
    function loadChoices(categoryId) {
        $.get('{{ route('fetch.choices') }}', { category_id: categoryId }, function (response) {
            $('#choices').empty().append('<option></option>');
            response.forEach(function (choice) {
                var sel = selectedChoices.includes(choice.id) ? 'selected' : '';
                $('#choices').append('<option value="' + choice.id + '" ' + sel + '>' + choice.name + '</option>');
            });
            $('#choices').trigger('change.select2');
        });
    }

    $('#category').on('change', function () { loadChoices($(this).val()); });
    loadChoices($('#category').val());
});

function previewMainImage(event) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('mainImgPreview').src = e.target.result;
    reader.readAsDataURL(event.target.files[0]);
}

let uploadIndex = 10;
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
                   background:#ef4444; color:white; border:none; cursor:pointer; font-size:12px;
                   display:flex; align-items:center; justify-content:center;">×</button>`;
    document.getElementById('galleryContainer').appendChild(wrap);
}

function previewGallery(event, idx) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('gp-' + idx).src = e.target.result;
    reader.readAsDataURL(event.target.files[0]);
}

function removeGallery(idx) { document.getElementById('gallery-' + idx)?.remove(); }

function confirmProductImageDelete(imageId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'لن يمكنك التراجع عن هذا الإجراء!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then(result => {
        if (result.isConfirmed) deleteProductImage(imageId);
    });
}

function deleteProductImage(imageId) {
    fetch('{{ route('image.delete') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ image_id: imageId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.message === 'Image Deleted Successfully') {
            document.getElementById('image-' + imageId)?.remove();
            Swal.fire('تم!', 'تم حذف الصورة بنجاح.', 'success');
        } else {
            Swal.fire('فشل!', data.message, 'error');
        }
    });
}
</script>

@push('scripts')
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
@endpush

@endsection
