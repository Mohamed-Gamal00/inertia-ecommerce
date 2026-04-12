@extends('vendor.layouts.app')
@section('title', 'الملف الشخصي')

@section('content')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-store-edit-outline me-2 text-primary"></i>
                    بيانات المتجر
                </h5>
                
                <x-alert type="success"/>
                <x-alert type="dark"/>
                
                <form method="POST" action="{{ route('vendor.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 text-center">
                                <div class="mb-3">
                                    <img src="{{ $vendor->image_url }}" alt="{{ $vendor->name }}" class="rounded-circle border p-1" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <label class="btn btn-sm btn-outline-primary position-relative">
                                    <i class="mdi mdi-camera me-1"></i> تغيير الشعار
                                    <input type="file" name="image" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;" accept="image/*">
                                </label>
                                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4 text-center">
                                <div class="mb-3">
                                    @if($vendor->cover_image)
                                        <img src="{{ $vendor->cover_image_url }}" alt="Cover" class="rounded border" style="width: 150px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="rounded border d-flex align-items-center justify-content-center text-muted" style="width: 150px; height: 80px;">
                                            <i class="mdi mdi-image-outline" style="font-size: 24px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <label class="btn btn-sm btn-outline-secondary position-relative">
                                    <i class="mdi mdi-image me-1"></i> صورة الغلاف
                                    <input type="file" name="cover_image" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;" accept="image/*">
                                </label>
                                @error('cover_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">اسم المتجر (عربي)</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vendor->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">اسم المتجر (إنجليزي)</label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $vendor->name_en) }}" dir="ltr">
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $vendor->email) }}" required dir="ltr">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $vendor->phone) }}" dir="ltr">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">وصف المتجر</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $vendor->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">رابط المتجر</label>
                                <div class="input-group">
                                    <span class="input-group-text" dir="ltr">/store/</span>
                                    <input type="text" name="store_slug" class="form-control @error('store_slug') is-invalid @enderror" value="{{ old('store_slug', $vendor->store_slug) }}" dir="ltr" required>
                                </div>
                                @error('store_slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">رابط متجرك العام: {{ url('/store') }}/{{ $vendor->store_slug ?? 'your-store' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">لون العلامة التجارية</label>
                                <input type="color" name="banner_color" class="form-control form-control-color @error('banner_color') is-invalid @enderror" value="{{ old('banner_color', $vendor->banner_color ?? '#3490dc') }}">
                                @error('banner_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">روابط التواصل الاجتماعي</label>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-instagram text-danger"></i></span>
                                    <input type="url" name="social_links[instagram]" class="form-control" placeholder="رابط الإنستغرام" value="{{ old('social_links.instagram', $vendor->social_links['instagram'] ?? '') }}" dir="ltr">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-twitter text-info"></i></span>
                                    <input type="url" name="social_links[twitter]" class="form-control" placeholder="رابط تويتر" value="{{ old('social_links.twitter', $vendor->social_links['twitter'] ?? '') }}" dir="ltr">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-facebook text-primary"></i></span>
                                    <input type="url" name="social_links[facebook]" class="form-control" placeholder="رابط الفيسبوك" value="{{ old('social_links.facebook', $vendor->social_links['facebook'] ?? '') }}" dir="ltr">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-whatsapp text-success"></i></span>
                                    <input type="text" name="social_links[whatsapp]" class="form-control" placeholder="رقم الواتساب" value="{{ old('social_links.whatsapp', $vendor->social_links['whatsapp'] ?? '') }}" dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">سياسة الإرجاع</label>
                                <textarea name="return_policy" class="form-control @error('return_policy') is-invalid @enderror" rows="3">{{ old('return_policy', $vendor->return_policy) }}</textarea>
                                @error('return_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">سياسة الشحن</label>
                                <textarea name="shipping_policy" class="form-control @error('shipping_policy') is-invalid @enderror" rows="3">{{ old('shipping_policy', $vendor->shipping_policy) }}</textarea>
                                @error('shipping_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">رقم الحساب البنكي</label>
                                <input type="text" name="bank_account" class="form-control @error('bank_account') is-invalid @enderror" value="{{ old('bank_account', $vendor->bank_account) }}" dir="ltr">
                                @error('bank_account') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">اسم البنك</label>
                                <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', $vendor->bank_name) }}">
                                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save me-1"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> العودة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">
                    <i class="mdi mdi-information-outline me-2 text-primary"></i>
                    معلومات الحساب
                </h5>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">البريد الإلكتروني</span>
                        <span class="fw-semibold small" dir="ltr">{{ $vendor->email }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">حالة الحساب</span>
                        <span class="badge {{ $vendor->status === 'active' ? 'bg-success' : ($vendor->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            @if($vendor->status === 'active')
                                نشط
                            @elseif($vendor->status === 'pending')
                                قيد المراجعة
                            @else
                                موقوف
                            @endif
                        </span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">نسبة العمولة</span>
                        <span class="fw-semibold small">{{ $vendor->commission_rate }}%</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">التقييم</span>
                        <span class="fw-semibold small">
                            @if($vendor->rating > 0)
                                {{ number_format($vendor->rating, 1) }} ⭐
                            @else
                                لا يوجد تقييم
                            @endif
                        </span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted small">تاريخ الانضمام</span>
                        <span class="fw-semibold small">{{ $vendor->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">
                    <i class="mdi mdi-lock-outline me-2 text-primary"></i>
                    تغيير كلمة المرور
                </h5>
                <form method="POST" action="{{ route('vendor.profile.password') }}">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="mdi mdi-key-change me-1"></i> تغيير كلمة المرور
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection