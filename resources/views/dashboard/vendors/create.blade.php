@extends('dashboard.index')
@section('title', 'إضافة بائع جديد')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">البائعون</a></li>
    <li class="breadcrumb-item active">إضافة بائع جديد</li>
@endsection

@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="mdi mdi-store-plus-outline me-2 text-primary"></i>
        إضافة بائع جديد
    </h4>
    <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">
        <i class="mdi mdi-arrow-right me-1"></i>
        العودة للقائمة
    </a>
</div>

<x-alert type="success"/>
<x-alert type="error"/>

<form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">المعلومات الأساسية</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المتجر <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المتجر بالإنجليزية</label>
                            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                   value="{{ old('name_en') }}">
                            @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">وصف المتجر</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">إعدادات المتجر</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رابط المتجر <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/store') }}/</span>
                                <input type="text" name="store_slug" class="form-control @error('store_slug') is-invalid @enderror"
                                       value="{{ old('store_slug') }}" required>
                            </div>
                            <small class="text-muted">يجب أن يحتوي على أحرف صغيرة وأرقام وشرطات فقط</small>
                            @error('store_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">لون البانر</label>
                            <input type="color" name="banner_color" class="form-control form-control-color @error('banner_color') is-invalid @enderror"
                                   value="{{ old('banner_color', '#007bff') }}">
                            @error('banner_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نسبة العمولة (%) <span class="text-danger">*</span></label>
                            <input type="number" name="commission_rate" step="0.01" min="0" max="100"
                                   class="form-control @error('commission_rate') is-invalid @enderror"
                                   value="{{ old('commission_rate', '10') }}" required>
                            @error('commission_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة البائع <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>موقوف</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">المعلومات التجارية</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الترخيص التجاري</label>
                            <input type="text" name="business_license" class="form-control @error('business_license') is-invalid @enderror"
                                   value="{{ old('business_license') }}">
                            @error('business_license')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الرقم الضريبي</label>
                            <input type="text" name="tax_number" class="form-control @error('tax_number') is-invalid @enderror"
                                   value="{{ old('tax_number') }}">
                            @error('tax_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الحساب البنكي</label>
                            <input type="text" name="bank_account" class="form-control @error('bank_account') is-invalid @enderror"
                                   value="{{ old('bank_account') }}">
                            @error('bank_account')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم البنك</label>
                            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"
                                   value="{{ old('bank_name') }}">
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">الصور</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">صورة الملف الشخصي</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">الحد الأقصى: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">صورة الغلاف</label>
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">الحد الأقصى: 2MB</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">روابط التواصل الاجتماعي</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">فيسبوك</label>
                        <input type="url" name="social_links[facebook]" class="form-control @error('social_links.facebook') is-invalid @enderror"
                               value="{{ old('social_links.facebook') }}">
                        @error('social_links.facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تويتر</label>
                        <input type="url" name="social_links[twitter]" class="form-control @error('social_links.twitter') is-invalid @enderror"
                               value="{{ old('social_links.twitter') }}">
                        @error('social_links.twitter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">إنستغرام</label>
                        <input type="url" name="social_links[instagram]" class="form-control @error('social_links.instagram') is-invalid @enderror"
                               value="{{ old('social_links.instagram') }}">
                        @error('social_links.instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">لينكد إن</label>
                        <input type="url" name="social_links[linkedin]" class="form-control @error('social_links.linkedin') is-invalid @enderror"
                               value="{{ old('social_links.linkedin') }}">
                        @error('social_links.linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-semibold">السياسات</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">سياسة الإرجاع</label>
                    <textarea name="return_policy" rows="4" class="form-control @error('return_policy') is-invalid @enderror">{{ old('return_policy') }}</textarea>
                    @error('return_policy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">سياسة الشحن</label>
                    <textarea name="shipping_policy" rows="4" class="form-control @error('shipping_policy') is-invalid @enderror">{{ old('shipping_policy') }}</textarea>
                    @error('shipping_policy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">إلغاء</a>
        <button type="submit" class="btn btn-primary">
            <i class="mdi mdi-content-save me-1"></i>
            حفظ البائع
        </button>
    </div>
</form>

@endsection
