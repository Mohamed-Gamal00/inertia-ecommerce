@extends('dashboard.index')

@section('title', 'إعدادات الموقع')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">إعدادات الموقع</li>
@endsection

@section('section')

<form action="{{ route('settings.update', $setting->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('put')

{{-- ── Alerts ── --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4">
    <i class="mdi mdi-alert-circle-outline me-2"></i>
    <strong>يرجى تصحيح الأخطاء:</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
<x-alert type='success' />

{{-- ── Page header ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            <i class="mdi mdi-cog-outline me-2 text-primary"></i>
            إعدادات الموقع
        </h4>
        <small class="text-muted">تحكم في جميع إعدادات المتجر من مكان واحد</small>
    </div>
    <button type="submit" class="btn btn-primary px-4">
        <i class="mdi mdi-content-save me-1"></i>
        حفظ جميع الإعدادات
    </button>
</div>

{{-- ── Tabs nav ── --}}
<ul class="nav nav-tabs nav-tabs-custom mb-4" id="settingsTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-general">
            <i class="mdi mdi-store-outline me-1"></i> المتجر
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-social">
            <i class="mdi mdi-share-variant-outline me-1"></i> التواصل الاجتماعي
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-media">
            <i class="mdi mdi-image-outline me-1"></i> الشعار والصور
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-payment">
            <i class="mdi mdi-credit-card-outline me-1"></i> الدفع والرسائل
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-seo">
            <i class="mdi mdi-magnify me-1"></i> SEO
        </a>
    </li>
</ul>

<div class="tab-content">

    {{-- ══════════════════════════════════════
         TAB 1: General Store Info
    ══════════════════════════════════════ --}}
    <div class="tab-pane fade show active" id="tab-general">
        <div class="row g-4">

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-information-outline me-2 text-primary"></i>
                        معلومات المتجر
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">اسم المتجر <span class="text-danger">*</span></label>
                            <input type="text" name="website_name" class="form-control @error('website_name') is-invalid @enderror"
                                value="{{ old('website_name', $setting->website_name) }}" placeholder="اسم المتجر بالعربي" />
                            @error('website_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold">اسم المتجر بالإنجليزية</label>
                            <input type="text" name="website_name_en" class="form-control"
                                value="{{ old('website_name_en', $setting->website_name_en) }}" dir="ltr" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">نص الاشتراك في النشرة</label>
                            <input type="text" name="subscription_title" class="form-control"
                                value="{{ old('subscription_title', $setting->subscription_title) }}"
                                placeholder="اشترك للحصول على أحدث العروض..." />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-map-marker-outline me-2 text-primary"></i>
                        بيانات التواصل
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">البريد الإلكتروني</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $setting->email) }}" dir="ltr" />
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">رقم الجوال</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', $setting->phone_number) }}" dir="ltr" />
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">عنوان المتجر</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $setting->address) }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-cash-multiple me-2 text-primary"></i>
                        الضرائب
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">الرقم الضريبي</label>
                            <input type="text" name="tax_number" class="form-control"
                                value="{{ old('tax_number', $setting->tax_number) }}" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">ضريبة القيمة المضافة (%)</label>
                            <div class="input-group">
                                <input type="number" name="value_added_tax" step="0.01" min="0" max="100"
                                    class="form-control" value="{{ old('value_added_tax', $setting->value_added_tax) }}" />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-cellphone me-2 text-primary"></i>
                        روابط التطبيق
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">رابط Google Play</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-google-play"></i></span>
                                <input type="text" name="google_play" class="form-control"
                                    value="{{ old('google_play', $setting->google_play) }}" dir="ltr" placeholder="https://play.google.com/..." />
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">رابط App Store</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-apple"></i></span>
                                <input type="text" name="apple_store" class="form-control"
                                    value="{{ old('apple_store', $setting->apple_store) }}" dir="ltr" placeholder="https://apps.apple.com/..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 2: Social Media
    ══════════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-social">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-share-variant-outline me-2 text-primary"></i>
                روابط التواصل الاجتماعي
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $socials = [
                            'facebook'  => ['label' => 'فيسبوك',    'icon' => 'mdi-facebook',  'placeholder' => 'https://facebook.com/...'],
                            'twitter'   => ['label' => 'تويتر',     'icon' => 'mdi-twitter',   'placeholder' => 'https://twitter.com/...'],
                            'instagram' => ['label' => 'إنستجرام',  'icon' => 'mdi-instagram', 'placeholder' => 'https://instagram.com/...'],
                            'snap'      => ['label' => 'سناب شات',  'icon' => 'mdi-snapchat',  'placeholder' => 'https://snapchat.com/add/...'],
                            'tiktok'    => ['label' => 'تيك توك',   'icon' => 'mdi-music-note', 'placeholder' => 'https://tiktok.com/@...'],
                        ];
                    @endphp
                    @foreach($socials as $name => $info)
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ $info['label'] }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi {{ $info['icon'] }}"></i></span>
                            <input type="text" name="{{ $name }}" class="form-control"
                                value="{{ old($name, $setting->$name) }}"
                                placeholder="{{ $info['placeholder'] }}" dir="ltr" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 3: Logo & Images
    ══════════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-media">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-image-outline me-2 text-primary"></i>
                        شعار المتجر (Logo)
                    </div>
                    <div class="card-body">
                        @if($setting->logo)
                        <div class="mb-3 p-3 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $setting->logo) }}" style="max-height:80px; max-width:200px; object-fit:contain" />
                            <div class="text-muted small mt-2">الشعار الحالي</div>
                        </div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*" />
                        <div class="form-text">PNG أو SVG — يُفضل خلفية شفافة</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-tab me-2 text-primary"></i>
                        أيقونة التبويب (Favicon)
                    </div>
                    <div class="card-body">
                        @if($setting->image)
                        <div class="mb-3 p-3 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $setting->image) }}" style="width:32px; height:32px; object-fit:contain" />
                            <div class="text-muted small mt-2">الأيقونة الحالية</div>
                        </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*" />
                        <div class="form-text">ICO أو PNG — 32×32 بكسل</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 4: Payment & SMS
    ══════════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-payment">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-credit-card-outline me-2 text-primary"></i>
                        بوابة الدفع
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">المفتاح العام (Publishable Key)</label>
                            <input type="text" name="publishable_key" class="form-control"
                                value="{{ old('publishable_key', $setting->publishable_key) }}" dir="ltr" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">المفتاح السري (Secret Key)</label>
                            <div class="input-group">
                                <input type="password" name="secret_key" id="secretKeyInput" class="form-control"
                                    value="{{ old('secret_key', $setting->secret_key) }}" dir="ltr" />
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="toggleSecret()">
                                    <i class="mdi mdi-eye-outline" id="secretEyeIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-message-text-outline me-2 text-primary"></i>
                        بوابة الرسائل (SMS)
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">مفتاح API</label>
                            <input type="text" name="sms_api_key" class="form-control"
                                value="{{ old('sms_api_key', $setting->sms_api_key) }}" dir="ltr" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">اسم المستخدم</label>
                            <input type="text" name="sms_user_name" class="form-control"
                                value="{{ old('sms_user_name', $setting->sms_user_name) }}" dir="ltr" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">اسم المُرسِل</label>
                            <input type="text" name="sms_sender" class="form-control"
                                value="{{ old('sms_sender', $setting->sms_sender) }}" dir="ltr" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 5: SEO
    ══════════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-seo">
        <div class="row g-4">

            {{-- Basic Meta --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-tag-outline me-2 text-primary"></i>
                        البيانات الأساسية
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                عنوان الصفحة (Meta Title)
                                <span class="text-muted fw-normal small">— الحد الأقصى 160 حرف</span>
                            </label>
                            <input type="text" name="seo_meta_title" class="form-control"
                                value="{{ old('seo_meta_title', $setting->seo_meta_title) }}"
                                maxlength="160" placeholder="عنوان يظهر في نتائج جوجل..." />
                            <div class="form-text">{{ strlen($setting->seo_meta_title ?? '') }}/160</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                وصف الصفحة (Meta Description)
                                <span class="text-muted fw-normal small">— الحد الأقصى 320 حرف</span>
                            </label>
                            <textarea name="seo_meta_description" class="form-control" rows="3"
                                maxlength="320">{{ old('seo_meta_description', $setting->seo_meta_description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">الكلمات المفتاحية <span class="text-muted fw-normal small">— مفصولة بفاصلة</span></label>
                            <input type="text" name="seo_meta_keywords" class="form-control"
                                value="{{ old('seo_meta_keywords', $setting->seo_meta_keywords) }}"
                                placeholder="متجر, تسوق, منتجات, ..." />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Robots Index</label>
                            <select name="robots_index" class="form-select">
                                @foreach(['index,follow' => 'index, follow — مرئي لجوجل (الافتراضي)', 'noindex,nofollow' => 'noindex, nofollow — مخفي تماماً', 'index,nofollow' => 'index, nofollow', 'noindex,follow' => 'noindex, follow'] as $val => $label)
                                    <option value="{{ $val }}" @selected(($setting->robots_index ?? 'index,follow') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Canonical URL</label>
                            <input type="url" name="canonical_url" class="form-control"
                                value="{{ old('canonical_url', $setting->canonical_url) }}"
                                placeholder="https://yourstore.com" dir="ltr" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Open Graph --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-facebook me-2 text-primary"></i>
                        Open Graph (فيسبوك / واتساب)
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">عنوان OG</label>
                            <input type="text" name="og_title" class="form-control"
                                value="{{ old('og_title', $setting->og_title) }}" maxlength="160" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">وصف OG</label>
                            <textarea name="og_description" class="form-control" rows="2"
                                maxlength="320">{{ old('og_description', $setting->og_description) }}</textarea>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">صورة OG <span class="text-muted fw-normal small">1200×630</span></label>
                            @if($setting->og_image)
                                <img src="{{ asset('storage/' . $setting->og_image) }}" class="img-thumbnail mb-2 d-block" style="max-height:100px" />
                            @endif
                            <input type="file" name="og_image" class="form-control" accept="image/*" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Twitter Card --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-twitter me-2 text-primary"></i>
                        Twitter Card
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-semibold">نوع البطاقة</label>
                            <select name="twitter_card" class="form-select">
                                <option value="summary_large_image" @selected(($setting->twitter_card ?? 'summary_large_image') === 'summary_large_image')>صورة كبيرة (summary_large_image)</option>
                                <option value="summary" @selected($setting->twitter_card === 'summary')>صورة صغيرة (summary)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">عنوان Twitter</label>
                            <input type="text" name="twitter_title" class="form-control"
                                value="{{ old('twitter_title', $setting->twitter_title) }}" maxlength="160" />
                        </div>
                        <div>
                            <label class="form-label fw-semibold">وصف Twitter</label>
                            <textarea name="twitter_description" class="form-control" rows="2"
                                maxlength="320">{{ old('twitter_description', $setting->twitter_description) }}</textarea>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">صورة Twitter</label>
                            @if($setting->twitter_image)
                                <img src="{{ asset('storage/' . $setting->twitter_image) }}" class="img-thumbnail mb-2 d-block" style="max-height:100px" />
                            @endif
                            <input type="file" name="twitter_image" class="form-control" accept="image/*" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Technical --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom fw-bold">
                        <i class="mdi mdi-google me-2 text-primary"></i>
                        أدوات جوجل
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Google Analytics ID</label>
                            <input type="text" name="google_analytics_id" class="form-control"
                                value="{{ old('google_analytics_id', $setting->google_analytics_id) }}"
                                placeholder="G-XXXXXXXXXX" dir="ltr" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Google Tag Manager ID</label>
                            <input type="text" name="google_tag_manager_id" class="form-control"
                                value="{{ old('google_tag_manager_id', $setting->google_tag_manager_id) }}"
                                placeholder="GTM-XXXXXXX" dir="ltr" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Google Site Verification</label>
                            <input type="text" name="google_site_verification" class="form-control"
                                value="{{ old('google_site_verification', $setting->google_site_verification) }}" dir="ltr" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>{{-- end tab-content --}}

{{-- Sticky save bar --}}
<div class="d-flex justify-content-end mt-4 pt-3 border-top">
    <button type="submit" class="btn btn-primary px-5">
        <i class="mdi mdi-content-save me-1"></i>
        حفظ جميع الإعدادات
    </button>
</div>

</form>

<script>
function toggleSecret() {
    const input = document.getElementById('secretKeyInput');
    const icon  = document.getElementById('secretEyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'mdi mdi-eye-off-outline';
    } else {
        input.type = 'password';
        icon.className = 'mdi mdi-eye-outline';
    }
}

// Remember active tab across page reloads
document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('settingsActiveTab');
    if (saved) {
        const tab = document.querySelector('[href="' + saved + '"]');
        if (tab) new bootstrap.Tab(tab).show();
    }
    document.querySelectorAll('#settingsTabs .nav-link').forEach(function (el) {
        el.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('settingsActiveTab', e.target.getAttribute('href'));
        });
    });
});
</script>

@endsection
