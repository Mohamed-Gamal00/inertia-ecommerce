<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدارة</title>
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f5f6fa;
        }

        /* Left: branding panel */
        .login-left {
            width: 45%;
            background: linear-gradient(145deg, #0d1b6e 0%, #1a237e 40%, #283593 70%, #3949ab 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -150px; right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px; left: -60px;
        }

        .login-left-content { position: relative; z-index: 1; text-align: center; }

        .brand-icon {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-title {
            color: white;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .brand-sub {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            line-height: 1.7;
            max-width: 260px;
            margin: 0 auto 32px;
        }

        .stat-cards {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 14px 20px;
            text-align: center;
            backdrop-filter: blur(8px);
            min-width: 90px;
        }

        .stat-card .num {
            color: white;
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-card .label {
            color: rgba(255,255,255,0.65);
            font-size: 11px;
            margin-top: 4px;
        }

        /* Right: form panel */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: white;
        }

        .login-form-wrap {
            width: 100%;
            max-width: 400px;
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8eaf6;
            color: #1a237e;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .login-sub {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 28px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            display: block;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 11px 14px;
            font-size: 14px;
            background: #f9fafb;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-control:focus {
            border-color: #3949ab;
            box-shadow: 0 0 0 3px rgba(57,73,171,0.1);
            background: white;
            outline: none;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 8px;
        }

        .btn-login:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #d1d5db;
            font-size: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .vendor-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: border-color 0.15s, background 0.15s;
        }

        .vendor-link:hover {
            border-color: #3949ab;
            background: #f0f2ff;
            color: #1a237e;
        }

        @media (max-width: 768px) {
            .login-left { display: none; }
        }
    </style>
</head>
<body>

    <!-- Left branding -->
    <div class="login-left">
        <div class="login-left-content">
            <div class="brand-icon">🛒</div>
            <div class="brand-title">لوحة التحكم</div>
            <p class="brand-sub">إدارة متكاملة لمتجرك الإلكتروني — منتجات، طلبات، عملاء، وأكثر.</p>

            <div class="stat-cards">
                @php
                    $pCount = \App\Models\Product::count();
                    $oCount = \App\Models\Order::count();
                    $uCount = \App\Models\User::count();
                @endphp
                <div class="stat-card">
                    <div class="num">{{ $pCount }}</div>
                    <div class="label">منتج</div>
                </div>
                <div class="stat-card">
                    <div class="num">{{ $oCount }}</div>
                    <div class="label">طلب</div>
                </div>
                <div class="stat-card">
                    <div class="num">{{ $uCount }}</div>
                    <div class="label">عميل</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right form -->
    <div class="login-right">
        <div class="login-form-wrap">

            <div class="login-badge">
                <i class="mdi mdi-shield-account-outline"></i>
                منطقة الإدارة
            </div>

            <h1 class="login-title">مرحباً بعودتك 👋</h1>
            <p class="login-sub">سجّل دخولك للوصول إلى لوحة التحكم</p>

            @if(session('error') || $errors->any())
                <div class="alert alert-danger mb-4" style="border-radius:10px; font-size:13px">
                    {{ session('error') ?? $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="field-label">البريد الإلكتروني</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="admin@example.com"
                        value="{{ old('email') }}"
                        required
                        dir="ltr"
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label class="field-label">كلمة المرور</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn-login">
                    <i class="mdi mdi-login me-2"></i>
                    تسجيل الدخول
                </button>
            </form>

            <div class="divider">أو</div>

            <a href="{{ route('vendor.login') }}" class="vendor-link">
                <i class="mdi mdi-store-outline" style="font-size:18px"></i>
                تسجيل دخول البائعين
            </a>

            <p class="text-center mt-4" style="font-size:12px; color:#9ca3af">
                © {{ date('Y') }} متجري — جميع الحقوق محفوظة
            </p>
        </div>
    </div>

</body>
</html>
