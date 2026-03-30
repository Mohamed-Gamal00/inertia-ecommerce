@extends('vendor.layouts.app')
@section('title', 'إضافة منتج جديد')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('vendor.products') }}" class="btn btn-outline-secondary btn-sm">
        <i class="mdi mdi-arrow-right me-1"></i> المنتجات
    </a>
    <h5 class="fw-bold mb-0">إضافة منتج جديد</h5>
</div>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('vendor.products.store') }}" method="post" enctype="multipart/form-data">
@csrf

<div class="row g-4">

    {{-- ===== Left: Main info ===== --}}
    <div class="col-lg-8">

        {{-- Basic info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4"><i class="mdi mdi-information-outline me-2 text-primary"></i>المعلومات الأساسية</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">اسم المنتج <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="أدخل اسم المنتج">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">الاسم بالإنجليزية</label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="Product name in English" dir="ltr">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="وصف تفصيلي للمنتج...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4"><i class="mdi mdi-cash me-2 text-success"></i>التسعير والمخزون</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">السعر <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required min="0" placeholder="0.00">
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">سعر الخصم</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price') }}" min="0" placeholder="0.00">
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الكمية</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الوزن (كجم)</label>
                        <input type="number" step="0.001" name="weight" class="form-control" value="{{ old('weight') }}" min="0" placeholder="0.000">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">حالة التوفر</label>
                        <select name="product_availability_id" class="form-select">
                            <option value="">— اختر —</option>
                            @foreach ($availability_status as $a)
                                <option value="{{ $a->id }}" @selected(old('product_availability_id') == $a->id)>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">نوع المنتج</label>
                        <select name="is_special" class="form-select">
                            <option value="0" @selected(old('is_special', '0') == '0')>عادي</option>
                            <option value="1" @selected(old('is_special') == '1')>مميز ⭐</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colors --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-palette-outline me-2 text-primary"></i>الألوان المتاحة</h6>
                <p class="text-muted small mb-3">اختر الألوان المتاحة لهذا المنتج</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($colors as $color)
                    <label class="color-chip" title="{{ $color->name }}">
                        <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                               @checked(in_array($color->id, old('colors', [])))
                               class="color-chip-input">
                        <span class="color-chip-dot" style="background:{{ $color->color_code }}"></span>
                        <span class="color-chip-label">{{ $color->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Choices --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-format-list-checks me-2 text-primary"></i>خيارات المنتج</h6>
                <p class="text-muted small mb-3">اختر الخيارات المتاحة (مقاس، نوع، إلخ)</p>
                <div id="choices-container" class="d-flex flex-wrap gap-2">
                    <span class="text-muted small">جاري التحميل...</span>
                </div>
                {{-- Hidden select to hold values --}}
                <select name="choice_id[]" id="choices-select" multiple style="display:none"></select>
            </div>
        </div>

        {{-- Additional images --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-image-multiple-outline me-2 text-primary"></i>صور إضافية للمنتج</h6>
                <p class="text-muted small mb-3">يمكنك إضافة عدة صور للمنتج</p>
                <div id="extra-images-container">
                    <div class="extra-image-row d-flex align-items-center gap-2 mb-2">
                        <input type="file" name="header[0][image]" accept="image/*" class="form-control extra-image-input">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn" style="display:none">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-image-btn">
                    <i class="mdi mdi-plus me-1"></i> إضافة صورة أخرى
                </button>
            </div>
        </div>

        {{-- Product features --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-star-outline me-2 text-primary"></i>مميزات المنتج <span class="text-muted fw-normal" style="font-size:12px">(اختياري)</span></h6>
                <p class="text-muted small mb-3">أضف مميزات وخصائص المنتج</p>
                <div id="features-container">
                    <div class="feature-row row g-2 mb-3 align-items-start">
                        <div class="col-md-4">
                            <input type="text" name="product_features[0][feature_name]" class="form-control" placeholder="اسم الميزة (عربي)">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="product_features[0][feature_name_en]" class="form-control" placeholder="Feature name" dir="ltr">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="product_features[0][feature_description]" class="form-control" placeholder="الوصف">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-feature-btn" style="display:none">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature-btn">
                    <i class="mdi mdi-plus me-1"></i> إضافة ميزة
                </button>
            </div>
        </div>

    </div>

    {{-- ===== Right: Category + Image + Status ===== --}}
    <div class="col-lg-4">

        {{-- Status --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-toggle-switch-outline me-2 text-primary"></i>الحالة</h6>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status', 'active') === 'active')>✅ نشط</option>
                    <option value="archived" @selected(old('status') === 'archived')>❌ غير نشط</option>
                </select>
            </div>
        </div>

        {{-- Category --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-shape-outline me-2 text-primary"></i>القسم <span class="text-danger">*</span></h6>
                @php
                    function vendorRenderCats($cats, $prefix = '') {
                        $html = '';
                        foreach ($cats as $cat) {
                            $html .= '<option value="' . $cat->id . '">' . $prefix . $cat->name . '</option>';
                            if ($cat->children->isNotEmpty()) {
                                $html .= vendorRenderCats($cat->children, $prefix . '— ');
                            }
                        }
                        return $html;
                    }
                @endphp
                <select name="parent_id" class="form-select" required>
                    <option value="">اختر القسم</option>
                    {!! vendorRenderCats($subCategories) !!}
                </select>
            </div>
        </div>

        {{-- Main image --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-image-outline me-2 text-primary"></i>صورة المنتج</h6>
                <div class="image-upload-area" id="imageUploadArea">
                    <img id="imagePreview" src="" alt="" style="display:none; width:100%; border-radius:8px; margin-bottom:10px">
                    <div id="imageUploadPlaceholder" class="text-center py-3">
                        <i class="mdi mdi-cloud-upload-outline text-muted" style="font-size:36px"></i>
                        <p class="text-muted small mb-0">اضغط لاختيار صورة</p>
                        <p class="text-muted" style="font-size:11px">PNG, JPG حتى 2MB</p>
                    </div>
                    <input type="file" name="image" id="imageInput" accept="image/*" class="form-control mt-2">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                <i class="mdi mdi-content-save me-2"></i>
                حفظ المنتج
            </button>
            <a href="{{ route('vendor.products') }}" class="btn btn-outline-secondary">إلغاء</a>
        </div>

    </div>
</div>

</form>

@endsection

@push('styles')
<style>
.color-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 12px; border-radius: 20px;
    border: 2px solid #e5e7eb; cursor: pointer;
    transition: all 0.15s; user-select: none;
    background: white;
}
.color-chip:hover { border-color: #3949ab; }
.color-chip-input { display: none; }
.color-chip-input:checked ~ .color-chip-dot { box-shadow: 0 0 0 2px white, 0 0 0 4px #3949ab; }
.color-chip-input:checked + .color-chip-dot + .color-chip-label { color: #1a237e; font-weight: 700; }
.color-chip:has(.color-chip-input:checked) { border-color: #3949ab; background: #f0f2ff; }
.color-chip-dot { width: 16px; height: 16px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.15); flex-shrink: 0; }
.color-chip-label { font-size: 13px; color: #374151; }

.choice-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 12px; border-radius: 20px;
    border: 2px solid #e5e7eb; cursor: pointer;
    transition: all 0.15s; user-select: none;
    background: white; font-size: 13px; color: #374151;
}
.choice-chip:hover { border-color: #3949ab; }
.choice-chip.selected { border-color: #3949ab; background: #f0f2ff; color: #1a237e; font-weight: 700; }

.image-upload-area { border: 2px dashed #e5e7eb; border-radius: 10px; padding: 12px; cursor: pointer; transition: border-color 0.15s; }
.image-upload-area:hover { border-color: #3949ab; }
</style>
@endpush

@push('scripts')
<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('imagePreview');
        preview.src = ev.target.result;
        preview.style.display = 'block';
        document.getElementById('imageUploadPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(file);
});

// Load choices as chips
const oldChoices = @json(old('choice_id', []));
fetch('{{ route('vendor.fetch.choices') }}', {
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
})
.then(r => r.json())
.then(function(choices) {
    const container = document.getElementById('choices-container');
    const select    = document.getElementById('choices-select');
    container.innerHTML = '';
    if (!choices.length) { container.innerHTML = '<span class="text-muted small">لا توجد خيارات متاحة</span>'; return; }
    choices.forEach(function(choice) {
        const opt = document.createElement('option');
        opt.value = choice.id; opt.textContent = choice.name;
        select.appendChild(opt);
        const chip = document.createElement('div');
        chip.className = 'choice-chip' + (oldChoices.includes(String(choice.id)) ? ' selected' : '');
        chip.textContent = choice.name; chip.dataset.id = choice.id;
        chip.addEventListener('click', function() {
            chip.classList.toggle('selected');
            const sel = chip.classList.contains('selected');
            for (let o of select.options) { if (o.value == choice.id) { o.selected = sel; break; } }
        });
        if (oldChoices.includes(String(choice.id))) {
            for (let o of select.options) { if (o.value == choice.id) { o.selected = true; break; } }
        }
        container.appendChild(chip);
    });
});

// Dynamic extra images
let imageIndex = 1;
document.getElementById('add-image-btn').addEventListener('click', function() {
    const container = document.getElementById('extra-images-container');
    const row = document.createElement('div');
    row.className = 'extra-image-row d-flex align-items-center gap-2 mb-2';
    row.innerHTML = `<input type="file" name="header[${imageIndex}][image]" accept="image/*" class="form-control extra-image-input">
        <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn"><i class="mdi mdi-close"></i></button>`;
    row.querySelector('.remove-image-btn').addEventListener('click', () => row.remove());
    container.appendChild(row);
    imageIndex++;
});

// Dynamic features
let featureIndex = 1;
document.getElementById('add-feature-btn').addEventListener('click', function() {
    const container = document.getElementById('features-container');
    const row = document.createElement('div');
    row.className = 'feature-row row g-2 mb-3 align-items-start';
    row.innerHTML = `
        <div class="col-md-4"><input type="text" name="product_features[${featureIndex}][feature_name]" class="form-control" placeholder="اسم الميزة (عربي)"></div>
        <div class="col-md-3"><input type="text" name="product_features[${featureIndex}][feature_name_en]" class="form-control" placeholder="Feature name" dir="ltr"></div>
        <div class="col-md-4"><input type="text" name="product_features[${featureIndex}][feature_description]" class="form-control" placeholder="الوصف"></div>
        <div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-sm remove-feature-btn"><i class="mdi mdi-close"></i></button></div>`;
    row.querySelector('.remove-feature-btn').addEventListener('click', () => row.remove());
    container.appendChild(row);
    featureIndex++;
});</script>
@endpush
