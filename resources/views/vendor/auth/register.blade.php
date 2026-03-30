<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل بائع جديد</title>
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <style>
        body { background:linear-gradient(135deg,#1a237e,#3949ab); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
        .card { border-radius:16px; padding:40px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .brand-icon { width:64px; height:64px; background:#e8eaf6; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; }
    </style>
</head>
<body>
<div class="card bg-white">
    <div class="brand-icon">🏪</div>
    <h4 class="text-center fw-bold mb-1">انضم كبائع</h4>
    <p class="text-center text-muted mb-4" style="font-size:13px">سيتم مراجعة طلبك من قِبل الإدارة قبل التفعيل</p>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('vendor.register.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">اسم المتجر / الشركة</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required dir="ltr">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" dir="ltr">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">إرسال طلب التسجيل</button>
    </form>
    <p class="text-center text-muted mt-3" style="font-size:13px">
        لديك حساب؟ <a href="{{ route('vendor.login') }}" class="text-primary fw-bold">تسجيل الدخول</a>
    </p>
</div>
</body>
</html>
