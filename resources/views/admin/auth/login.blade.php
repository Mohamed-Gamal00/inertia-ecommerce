<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة التحكم</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f0f2f8;
        }

        /* ── Left panel: branding ── */
        .al-brand {
            flex: 1;
            background: linear-gradient(145deg, #1a237e 0%, #283593 50%, #3949ab 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .al-brand::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -100px; left: -100px;
        }

        .al-brand::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px; right: -80px;
        }

        .al-brand-logo {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            z-index: 1;
        }

        .al-brand-logo img {
            width: 48px; height: 48px; object-fit: contain;
        }

        .al-brand-title {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 12px;
            z-index: 1;
        }

        .al-brand-sub {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            text-align: center;
            line-height: 1.6;
            max-width: 280px;
            z-index: 1;
        }

        .al-brand-features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            z-index: 1;
            width: 100%;
            max-width: 300px;
        }

        .al-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 12px 16px;
            backdrop-filter: blur(4px);
        }

        .al-feature-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
            color: #fff;
        }

        .al-feature-text {
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Right panel: form ── */
        .al-form-panel {
            width: 480px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: #fff;
        }

        .al-form-wrap {
            width: 100%;
            max-width: 380px;
        }

        .al-form-header {
            margin-bottom: 36px;
        }

        .al-form-header h2 {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .al-form-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .al-field {
            margin-bottom: 20px;
        }

        .al-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .al-input-wrap {
            position: relative;
        }

        .al-input {
            width: 100%;
            padding: 12px 44px 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            direction: ltr;
            text-align: right;
        }

        .al-input:focus {
            border-color: #3949ab;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(57,73,171,0.1);
        }

        .al-input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .al-input-toggle {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            font-size: 16px;
            line-height: 1;
        }

        .al-input-toggle:hover { color: #3949ab; }

        .al-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .al-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 8px;
            letter-spacing: 0.3px;
        }

        .al-btn:hover { opacity: 0.92; }
        .al-btn:active { transform: scale(0.99); }

        .al-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .al-brand { padding: 32px 24px; min-height: 220px; }
            .al-brand-features { display: none; }
            .al-form-panel { width: 100%; padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <!-- Left: Branding -->
    <div class="al-brand">
        <div class="al-brand-logo">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'mdi mdi-store\' style=\'font-size:32px; color:white\'></i>'">
        </div>
        <div class="al-brand-title">لوحة التحكم</div>
        <div class="al-brand-sub">منصة إدارة متكاملة للتحكم في متجرك الإلكتروني بكل سهولة واحترافية</div>

        <div class="al-brand-features">
            <div class="al-feature">
                <div class="al-feature-icon"><i class="mdi mdi-shopping"></i></div>
                <div class="al-feature-text">إدارة المنتجات والمخزون</div>
            </div>
            <div class="al-feature">
                <div class="al-feature-icon"><i class="mdi mdi-chart-line"></i></div>
                <div class="al-feature-text">تقارير المبيعات والإحصائيات</div>
            </div>
            <div class="al-feature">
                <div class="al-feature-icon"><i class="mdi mdi-account-group"></i></div>
                <div class="al-feature-text">إدارة العملاء والطلبات</div>
            </div>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="al-form-panel">
        <div class="al-form-wrap">

            <div class="al-form-header">
                <h2>مرحباً بعودتك 👋</h2>
                <p>سجّل دخولك للوصول إلى لوحة التحكم</p>
            </div>

            @if (session('error'))
                <div class="al-error">
                    <i class="mdi mdi-alert-circle-outline"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="al-error">
                    <i class="mdi mdi-alert-circle-outline"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div class="al-field">
                    <label class="al-label" for="email">البريد الإلكتروني</label>
                    <div class="al-input-wrap">
                        <i class="mdi mdi-email-outline al-input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="al-input"
                            placeholder="admin@example.com"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        />
                    </div>
                </div>

                <div class="al-field">
                    <label class="al-label" for="password">كلمة المرور</label>
                    <div class="al-input-wrap">
                        <i class="mdi mdi-lock-outline al-input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="al-input"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" class="al-input-toggle" onclick="togglePassword()" id="toggleBtn">
                            <i class="mdi mdi-eye-outline" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="al-btn">
                    <i class="mdi mdi-login me-1"></i>
                    تسجيل الدخول
                </button>
            </form>

            <div class="al-footer">
                &copy; {{ date('Y') }} — جميع الحقوق محفوظة
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'mdi mdi-eye-off-outline';
            } else {
                input.type = 'password';
                icon.className = 'mdi mdi-eye-outline';
            }
        }
    </script>
</body>
</html>
