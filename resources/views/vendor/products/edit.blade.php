@extends('vendor.layouts.app')
@section('title', 'تعديل المنتج')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('vendor.products') }}" class="btn btn-outline-secondary btn-sm">
        <i class="mdi mdi-arrow-right me-1"></i> المنتجات
    </a>
    <h5 class="fw-bold mb-0">تعديل: {{ $product->name }}</h5>
</div>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('vendor.products.update', $product) }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')

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
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">الاسم بالإنجليزية</label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $product->name_en) }}" dir="ltr">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
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
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">سعر الخصم</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}" min="0">
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الكمية</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الوزن (كجم)</label>
                        <input type="number" step="0.001" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">حالة التوفر</label>
                        <select name="product_availability_id" class="form-select">
                            <option value="">— اختر —</option>
                            @foreach ($availability_status as $a)
                                <option value="{{ $a->id }}" @selected(old('product_availability_id', $product->product_availability_id) == $a->id)>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">نوع المنتج</label>
                        <select name="is_special" class="form-select">
                            <option value="0" @selected(old('is_special', $product->is_special ? '1' : '0') == '0')>عادي</option>
                            <option value="1" @selected(old('is_special', $product->is_special ? '1' : '0') == '1')>مميز ⭐</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colors --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-palette-outline me-2 text-primary"></i>الألوان المتاحة</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($colors as $color)
                    <label class="color-chip" title="{{ $color->name }}">
                        <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                               @checked(in_array($color->id, old('colors', $productColors)))
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
                <div id="choices-container" class="d-flex flex-wrap gap-2">
                    <span class="text-muted small">جاري التحميل...</span>
                </div>
                <select name="choice_id[]" id="choices-select" multiple style="display:none"></select>
            </div>
        </div>

        {{-- Additional images --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-image-multiple-outline me-2 text-primary"></i>صور إضافية للمنتج</h6>

                {{-- Existing images --}}
                @if($product->images->count())
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($product->images as $img)
                    <div class="position-relative">
                        <img src="{{ $img->image_url }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb" alt="">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-0 p-0 delete-img-btn"
                                style="width:20px;height:20px;font-size:10px;border-radius:50%"
                                data-id="{{ $img->id }}">×</button>
                    </div>
                    @endforeach
                </div>
                @endif

                <p class="text-muted small mb-2">إضافة صور جديدة</p>
                <div id="extra-images-container">
                    <div class="extra-image-row d-flex align-items-center gap-2 mb-2">
                        <input type="file" name="header[0][image]" accept="image/*" class="form-control">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn" style="display:none"><i class="mdi mdi-close"></i></button>
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
                <div id="features-container">
                    @forelse($product->features as $i => $feature)
                    <div class="feature-row row g-2 mb-3 align-items-start">
                        <input type="hidden" name="product_features[{{ $i }}][feature_id]" value="{{ $feature->id }}">
                        <input type="hidden" name="product_features[{{ $i }}][feature_delete]" value="{{ $feature->id }}">
                        <div class="col-md-4">
                            <input type="text" name="product_features[{{ $i }}][feature_name]" class="form-control" value="{{ $feature->feature_name }}" placeholder="اسم الميزة (عربي)">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="product_features[{{ $i }}][feature_name_en]" class="form-control" value="{{ $feature->feature_name_en }}" placeholder="Feature name" dir="ltr">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="product_features[{{ $i }}][feature_description]" class="form-control" value="{{ $feature->feature_description }}" placeholder="الوصف">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-feature-btn"><i class="mdi mdi-close"></i></button>
                        </div>
                    </div>
                    @empty
                    <div class="feature-row row g-2 mb-3 align-items-start">
                        <div class="col-md-4"><input type="text" name="product_features[0][feature_name]" class="form-control" placeholder="اسم الميزة (عربي)"></div>
                        <div class="col-md-3"><input type="text" name="product_features[0][feature_name_en]" class="form-control" placeholder="Feature name" dir="ltr"></div>
                        <div class="col-md-4"><input type="text" name="product_features[0][feature_description]" class="form-control" placeholder="الوصف"></div>
                        <div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-sm remove-feature-btn" style="display:none"><i class="mdi mdi-close"></i></button></div>
                    </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature-btn">
                    <i class="mdi mdi-plus me-1"></i> إضافة ميزة
                </button>
            </div>
        </div>

    </div>

    {{-- ===== Right ===== --}}
    <div class="col-lg-4">

        {{-- Status --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-toggle-switch-outline me-2 text-primary"></i>الحالة</h6>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status', $product->status) === 'active')>✅ نشط</option>
                    <option value="archived" @selected(old('status', $product->status) === 'archived')>❌ غير نشط</option>
                </select>
            </div>
        </div>

        {{-- Category --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-shape-outline me-2 text-primary"></i>القسم <span class="text-danger">*</span></h6>
                @php
                    function vendorEditCats($cats, $selectedId, $prefix = '') {
                        $html = '';
                        foreach ($cats as $cat) {
                            $sel = (int)$cat->id === (int)$selectedId ? ' selected' : '';
                            $html .= '<option value="' . $cat->id . '"' . $sel . '>' . $prefix . $cat->name . '</option>';
                            if ($cat->children->isNotEmpty()) {
                                $html .= vendorEditCats($cat->children, $selectedId, $prefix . '— ');
                            }
                        }
                        return $html;
                    }
                @endphp
                <select name="parent_id" class="form-select" required>
                    <option value="">اختر القسم</option>
                    {!! vendorEditCats($subCategories, old('parent_id', $product->parent_id ?? $product->category_id)) !!}
                </select>
            </div>
        </div>

        {{-- Image --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="mdi mdi-image-outline me-2 text-primary"></i>صورة المنتج</h6>
                @if($product->image)
                    <img id="imagePreview" src="{{ $product->image_url }}" alt="" style="width:100%; border-radius:8px; margin-bottom:10px">
                @else
                    <img id="imagePreview" src="" alt="" style="display:none; width:100%; border-radius:8px; margin-bottom:10px">
                @endif
                <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
                <small class="text-muted">اتركه فارغاً للإبقاء على الصورة الحالية</small>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                <i class="mdi mdi-content-save me-2"></i>
                حفظ التعديلات
            </button>
            <a href="{{ route('vendor.products') }}" class="btn btn-outline-secondary">إلغاء</a>
        </div>

    </div>
</div>

</form>

@endsection

@push('styles')
<style>
.color-chip { display:flex; align-items:center; gap:6px; padding:6px 12px; border-radius:20px; border:2px solid #e5e7eb; cursor:pointer; transition:all 0.15s; user-select:none; background:white; }
.color-chip:hover { border-color:#3949ab; }
.color-chip-input { display:none; }
.color-chip:has(.color-chip-input:checked) { border-color:#3949ab; background:#f0f2ff; }
.color-chip-input:checked ~ .color-chip-dot { box-shadow:0 0 0 2px white, 0 0 0 4px #3949ab; }
.color-chip-dot { width:16px; height:16px; border-radius:50%; border:1px solid rgba(0,0,0,0.15); flex-shrink:0; }
.color-chip-label { font-size:13px; color:#374151; }
.choice-chip { display:flex; align-items:center; gap:6px; padding:6px 12px; border-radius:20px; border:2px solid #e5e7eb; cursor:pointer; transition:all 0.15s; user-select:none; background:white; font-size:13px; color:#374151; }
.choice-chip:hover { border-color:#3949ab; }
.choice-chip.selected { border-color:#3949ab; background:#f0f2ff; color:#1a237e; font-weight:700; }
</style>
@endpush

@push('scripts')
<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        const p = document.getElementById('imagePreview');
        p.src = ev.target.result;
        p.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// Load choices as chips
const selectedChoices = @json(old('choice_id', $productChoices));
fetch('{{ route('vendor.fetch.choices') }}', {
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
})
.then(r => r.json())
.then(function(choices) {
    const container = document.getElementById('choices-container');
    const select    = document.getElementById('choices-select');
    container.innerHTML = '';
    if (!choices.length) { container.innerHTML = '<span class="text-muted small">لا توجد خيارات</span>'; return; }
    choices.forEach(function(choice) {
        const isSelected = selectedChoices.map(String).includes(String(choice.id));
        const opt = document.createElement('option');
        opt.value = choice.id; opt.textContent = choice.name; opt.selected = isSelected;
        select.appendChild(opt);
        const chip = document.createElement('div');
        chip.className = 'choice-chip' + (isSelected ? ' selected' : '');
        chip.textContent = choice.name; chip.dataset.id = choice.id;
        chip.addEventListener('click', function() {
            chip.classList.toggle('selected');
            const sel = chip.classList.contains('selected');
            for (let o of select.options) { if (o.value == choice.id) { o.selected = sel; break; } }
        });
        container.appendChild(chip);
    });
});

// Delete existing image via AJAX
document.querySelectorAll('.delete-img-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const id = btn.dataset.id;
        if (!confirm('حذف هذه الصورة؟')) return;
        fetch('{{ route('image.delete') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ image_id: id })
        }).then(r => r.json()).then(function(res) {
            if (res.message && res.message.includes('Successfully')) {
                btn.closest('.position-relative').remove();
            }
        });
    });
});

// Dynamic extra images
let imageIndex = 1;
document.getElementById('add-image-btn').addEventListener('click', function() {
    const container = document.getElementById('extra-images-container');
    const row = document.createElement('div');
    row.className = 'extra-image-row d-flex align-items-center gap-2 mb-2';
    row.innerHTML = `<input type="file" name="header[${imageIndex}][image]" accept="image/*" class="form-control">
        <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn"><i class="mdi mdi-close"></i></button>`;
    row.querySelector('.remove-image-btn').addEventListener('click', () => row.remove());
    container.appendChild(row);
    imageIndex++;
});

// Dynamic features
let featureIndex = {{ $product->features->count() ?: 1 }};
document.getElementById('add-feature-btn').addEventListener('click', function() {
    const container = document.getElementById('features-container');
    const row = document.createElement('div');
    row.className = 'feature-row row g-2 mb-3 align-items-start';
    row.innerHTML = `
        <div class="col-md-4"><input type="text" name="product_features[${featureIndex}][feature_name]" class="form-control" placeholder="اسم الميزة (عربي)"></div>
        <div class="col-md-3"><input type="text" name="product_features[${featureIndex}][feature_name_en]" class="form-control" placeholder="Feature name" dir="ltr"></div>
        <div class="col-md-4"><input type="text" name="product_features[${featureIndex}][feature_description]" class="form-control" placeholder="الوصف"></div>
        <input type="hidden" name="product_features[${featureIndex}][feature_id]" value="">
        <div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-sm remove-feature-btn"><i class="mdi mdi-close"></i></button></div>`;
    row.querySelector('.remove-feature-btn').addEventListener('click', () => row.remove());
    container.appendChild(row);
    featureIndex++;
});

// Remove feature row
document.querySelectorAll('.remove-feature-btn').forEach(btn => {
    btn.addEventListener('click', () => btn.closest('.feature-row').remove());
});
</script>
@endpush
