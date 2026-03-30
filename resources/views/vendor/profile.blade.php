@extends('vendor.layouts.app')
@section('title', 'الملف الشخصي')

@section('content')

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-store-edit-outline me-2 text-primary"></i>
                    بيانات المتجر
                </h5>
                <form method="POST" action="{{ route('vendor.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <img src="{{ $vendor->image_url }}" alt="{{ $vendor->name }}" class="rounded-circle border p-1" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <label class="btn btn-sm btn-outline-primary position-relative">
                            <i class="mdi mdi-camera me-1"></i> تغيير الشعار
                            <input type="file" name="image" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;">
                        </label>
                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم المتجر</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vendor->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $vendor->phone) }}" dir="ltr">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">وصف المتجر</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $vendor->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="mdi mdi-content-save me-1"></i> حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
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
                        <span class="badge {{ $vendor->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $vendor->status === 'active' ? 'نشط' : 'قيد المراجعة' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted small">تاريخ الانضمام</span>
                        <span class="fw-semibold small">{{ $vendor->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
