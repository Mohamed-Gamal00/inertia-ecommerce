@extends('dashboard.index')
@section('title', 'تعديل بيانات العميل')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">العملاء</a></li>
    <li class="breadcrumb-item active">تعديل بيانات العميل</li>
@endsection

@section('section')

{{-- Page header --}}
<div class="row mb-4 align-items-center">
    <div class="col d-flex align-items-center gap-3">
        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
             style="width:52px; height:52px; flex-shrink:0">
            <span class="fw-bold text-primary fs-5">{{ strtoupper(substr($client->first_name ?? 'U', 0, 1)) }}</span>
        </div>
        <div>
            <h4 class="mb-0 fw-bold">{{ $client->first_name }} {{ $client->family_name }}</h4>
            <small class="text-muted">{{ $client->email }}</small>
        </div>
    </div>
    <div class="col-auto">
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="mdi mdi-arrow-right me-1"></i> العودة
        </a>
    </div>
</div>

<x-alert type="success"/>
<x-alert type="dark"/>

<div class="row g-4">

    {{-- ===== Personal Info ===== --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-account-edit me-2 text-primary"></i>
                    البيانات الشخصية
                </h5>

                <form method="post" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method('put')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">الاسم الأول</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name" value="{{ old('first_name', $client->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">اسم العائلة</label>
                            <input type="text" class="form-control @error('family_name') is-invalid @enderror"
                                   name="family_name" value="{{ old('family_name', $client->family_name) }}" required>
                            @error('family_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $client->email) }}" dir="ltr" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">رقم الهاتف</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                   name="phone_number" value="{{ old('phone_number', $client->phone_number) }}" dir="ltr">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save me-1"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== Right: Quick info + Password ===== --}}
    <div class="col-lg-5 d-flex flex-column gap-4">

        {{-- Client info card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">
                    <i class="mdi mdi-information-outline me-2 text-primary"></i>
                    معلومات الحساب
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">تاريخ التسجيل</span>
                        <span class="fw-semibold small">{{ $client->created_at->format('d/m/Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">عدد الطلبات</span>
                        <span class="badge bg-primary">{{ $client->orders()->count() }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">عدد العناوين</span>
                        <span class="badge bg-secondary">{{ $client->addresses()->count() }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted small">المفضلة</span>
                        <span class="badge bg-danger">{{ $client->wishlistProducts()->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Change password --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-lock-reset me-2 text-warning"></i>
                    تغيير كلمة المرور
                </h5>

                <form method="post" action="{{ route('client.update_password', $client->id) }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                               name="new_password" placeholder="••••••••">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control"
                               name="new_password_confirmation" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold">
                        <i class="mdi mdi-lock-check me-1"></i>
                        تحديث كلمة المرور
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
