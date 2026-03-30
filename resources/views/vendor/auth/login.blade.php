<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول البائع</title>
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg,#1a237e,#3949ab); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .login-card { background:white; border-radius:16px; padding:40px; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .brand-icon { width:64px; height:64px; background:#e8eaf6; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="brand-icon">🏪</div>
    <h4 class="text-center fw-bold mb-1">بوابة البائعين</h4>
    <p class="text-center text-muted mb-4" style="font-size:14px">سجّل دخولك لإدارة متجرك</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('vendor.login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required dir="ltr">
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">تسجيل الدخول</button>
    </form>

    <hr class="my-4">
    <p class="text-center text-muted" style="font-size:13px">
        ليس لديك حساب؟
        <a href="{{ route('vendor.register') }}" class="text-primary fw-bold">سجّل كبائع</a>
    </p>
</div>
</body>
</html>
