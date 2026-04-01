@extends('dashboard.index')

@section('title', 'الاعدادات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">الاعدادات</li>
@endsection

@section('section')

    <form action="{{ route('settings.update', $setting->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <x-alert type='success' />

                    <x-alert type='dark' />
                    <div class="card-body">
                        {{-- Form Start --}}

                        {{-- <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">نبذه عن
                                                                                                    المنتجات</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="title" :value="$setting->title"/>
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم المتجر</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="website_name" :value="$setting->website_name" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم المتجر بالانجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="website_name_en" :value="$setting->website_name_en" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">نص الاشتراك</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="subscription_title" :value="$setting->subscription_title" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">البريد الالكتروني</label>
                            <div class="col-sm-10">
                                <x-form.input type="email" name="email" :value="$setting->email" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">رقم الجوال</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="phone_number" :value="$setting->phone_number" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">عنوان المتجر</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="address" :value="$setting->address" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الرقم
                                الضريبي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="tax_number" :value="$setting->tax_number" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">ضريبة القيمة
                                المضافة</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="value_added_tax" :value="$setting->value_added_tax" />
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                جوجل بلاي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="google_play" :value="$setting->google_play" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                ابل </label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="apple_store" :value="$setting->apple_store" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                الفيسبوك</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="facebook" :value="$setting->facebook" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                سناب</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="snap" :value="$setting->snap" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                تويتر</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="twitter" :value="$setting->twitter" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                الانستجرام</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="instagram" :value="$setting->instagram" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رابط
                                تيك توك</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="tiktok" :value="$setting->tiktok" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">
                                مفتاح بوابة الدفع</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="publishable_key" :value="$setting->publishable_key" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">
                                الرقم السري لبوبة الدفع</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="secret_key" :value="$setting->secret_key" />
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">
                                مفتاح بوابة الرسائل</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="sms_api_key" :value="$setting->sms_api_key" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">
                                اسم مستخدم بوابة الرسائل</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="sms_user_name" :value="$setting->sms_user_name" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">
                                اسم الراسل</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="sms_sender" :value="$setting->sms_sender" />
                            </div>
                        </div>

                        <x-dashboard.image-preview image="{{ asset('storage/' . $setting->image) }}" fileName="image"
                            heigh="32" width="32" title="ايقونة تبويب المتجر في المتصفح" />

                        <x-dashboard.image-preview image="{{ asset('storage/' . $setting->logo) }}" fileName="logo"
                            heigh="80" width="200" title="اللوجو" />


                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div> <!-- end col -->
        </div>

        {{-- ═══════════════════════════════════════════════════════
             SEO SETTINGS CARD
        ════════════════════════════════════════════════════════ --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                        <i class="mdi mdi-magnify fs-5"></i>
                        <h5 class="mb-0 fw-bold">إعدادات SEO وتحسين محركات البحث</h5>
                    </div>
                    <div class="card-body">

                        {{-- ── Basic Meta ── --}}
                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                            <i class="mdi mdi-tag-outline me-1"></i> البيانات الأساسية
                        </h6>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                عنوان الصفحة (Meta Title)
                                <small class="d-block text-muted fw-normal" style="font-size:11px">الحد الأقصى 160 حرف</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="seo_meta_title" class="form-control"
                                    value="{{ $setting->seo_meta_title }}"
                                    maxlength="160" placeholder="عنوان يظهر في نتائج جوجل..." />
                                <div class="form-text">{{ strlen($setting->seo_meta_title ?? '') }}/160 حرف</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                وصف الصفحة (Meta Description)
                                <small class="d-block text-muted fw-normal" style="font-size:11px">الحد الأقصى 320 حرف</small>
                            </label>
                            <div class="col-sm-10">
                                <textarea name="seo_meta_description" class="form-control" rows="3"
                                    maxlength="320" placeholder="وصف مختصر يظهر تحت العنوان في جوجل...">{{ $setting->seo_meta_description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label fw-bold">
                                الكلمات المفتاحية (Keywords)
                                <small class="d-block text-muted fw-normal" style="font-size:11px">مفصولة بفاصلة</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="seo_meta_keywords" class="form-control"
                                    value="{{ $setting->seo_meta_keywords }}"
                                    placeholder="متجر, تسوق, منتجات, ..." />
                            </div>
                        </div>

                        {{-- ── Open Graph ── --}}
                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                            <i class="mdi mdi-share-variant-outline me-1"></i> Open Graph (فيسبوك / واتساب / لينكدإن)
                        </h6>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">عنوان OG</label>
                            <div class="col-sm-10">
                                <input type="text" name="og_title" class="form-control"
                                    value="{{ $setting->og_title }}" maxlength="160"
                                    placeholder="يُستخدم عند مشاركة الرابط..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">وصف OG</label>
                            <div class="col-sm-10">
                                <textarea name="og_description" class="form-control" rows="2"
                                    maxlength="320">{{ $setting->og_description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label fw-bold">صورة OG</label>
                            <div class="col-sm-10">
                                @if($setting->og_image)
                                    <img src="{{ asset('storage/' . $setting->og_image) }}"
                                        class="img-thumbnail mb-2" style="max-height:120px">
                                @endif
                                <input type="file" name="og_image" class="form-control" accept="image/*" />
                                <div class="form-text">الحجم المثالي: 1200×630 بكسل</div>
                            </div>
                        </div>

                        {{-- ── Twitter Card ── --}}
                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                            <i class="mdi mdi-twitter me-1"></i> Twitter Card
                        </h6>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">نوع البطاقة</label>
                            <div class="col-sm-10">
                                <select name="twitter_card" class="form-select">
                                    <option value="summary_large_image" @selected($setting->twitter_card === 'summary_large_image')>
                                        summary_large_image (صورة كبيرة)
                                    </option>
                                    <option value="summary" @selected($setting->twitter_card === 'summary')>
                                        summary (صورة صغيرة)
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">عنوان Twitter</label>
                            <div class="col-sm-10">
                                <input type="text" name="twitter_title" class="form-control"
                                    value="{{ $setting->twitter_title }}" maxlength="160" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">وصف Twitter</label>
                            <div class="col-sm-10">
                                <textarea name="twitter_description" class="form-control" rows="2"
                                    maxlength="320">{{ $setting->twitter_description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label fw-bold">صورة Twitter</label>
                            <div class="col-sm-10">
                                @if($setting->twitter_image)
                                    <img src="{{ asset('storage/' . $setting->twitter_image) }}"
                                        class="img-thumbnail mb-2" style="max-height:120px">
                                @endif
                                <input type="file" name="twitter_image" class="form-control" accept="image/*" />
                            </div>
                        </div>

                        {{-- ── Technical SEO ── --}}
                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                            <i class="mdi mdi-cog-outline me-1"></i> الإعدادات التقنية
                        </h6>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                Google Analytics ID
                                <small class="d-block text-muted fw-normal" style="font-size:11px">مثال: G-XXXXXXXXXX</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="google_analytics_id" class="form-control"
                                    value="{{ $setting->google_analytics_id }}" placeholder="G-XXXXXXXXXX" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                Google Tag Manager ID
                                <small class="d-block text-muted fw-normal" style="font-size:11px">مثال: GTM-XXXXXXX</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="google_tag_manager_id" class="form-control"
                                    value="{{ $setting->google_tag_manager_id }}" placeholder="GTM-XXXXXXX" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                Google Site Verification
                                <small class="d-block text-muted fw-normal" style="font-size:11px">كود التحقق من Search Console</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="google_site_verification" class="form-control"
                                    value="{{ $setting->google_site_verification }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">
                                Canonical URL
                                <small class="d-block text-muted fw-normal" style="font-size:11px">الرابط الأساسي للموقع</small>
                            </label>
                            <div class="col-sm-10">
                                <input type="url" name="canonical_url" class="form-control"
                                    value="{{ $setting->canonical_url }}" placeholder="https://yourstore.com" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Robots Index</label>
                            <div class="col-sm-10">
                                <select name="robots_index" class="form-select">
                                    @foreach(['index,follow' => 'index, follow (الافتراضي — مرئي لجوجل)', 'noindex,nofollow' => 'noindex, nofollow (مخفي تماماً)', 'index,nofollow' => 'index, nofollow', 'noindex,follow' => 'noindex, follow'] as $val => $label)
                                        <option value="{{ $val }}" @selected($setting->robots_index === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="card">

                    {{--                    <div class="row mb-3"> --}}
                    {{--                        <label class="col-sm-2 col-form-label fw-bold">حالة الطلب الافتراضيه</label> --}}
                    {{--                        <div class="col-sm-8"> --}}
                    {{--                            <select class="form-select" name="order_status" --}}
                    {{--                                    aria-label="Default select example"> --}}
                    {{--                                <option selected hidden>اختر الحالة الافتراضيه للطلب</option> --}}
                    {{--                                @forelse($orderStatus as $status) --}}
                    {{--                                    <option --}}
                    {{--                                            value="{{$status->id}}" @selected($status->id == $currentOrderStatus->id)>{{$status->name}}</option> --}}
                    {{--                                @empty --}}
                    {{--                                @endforelse --}}
                    {{--                            </select> --}}
                    {{--                            @error('order_status') --}}
                    {{--                            <span class="error">{{ $message }}</span> --}}
                    {{--                            @enderror --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}

                    <div>
                        <button id="submitBtn" class="btn btn-primary mt-5 mb-2" type="submit">حفظ التعديلات</button>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
        </div>
    </form>

@endsection
