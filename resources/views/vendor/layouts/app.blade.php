<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة البائع') | متجري</title>

    {{-- Reuse admin theme assets --}}
    <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" rel="stylesheet">

    <style>
        /* Vendor-specific accent */
        .vendor-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,0.15); color: white;
            font-size: 11px; font-weight: 700; padding: 3px 10px;
            border-radius: 20px; border: 1px solid rgba(255,255,255,0.25);
        }
        .metismenu .vendor-section-title {
            font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 12px 20px 4px; display: block;
        }
    </style>

    @stack('styles')
</head>

<body data-sidebar="dark">

<div id="layout-wrapper">

    {{-- ===== Top bar ===== --}}
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="{{ route('vendor.dashboard') }}" class="logo logo-light d-flex align-items-center gap-2 text-decoration-none" style="padding:12px 16px">
                        <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">🏪</div>
                        <span class="logo-lg text-white fw-bold" style="font-size:15px">{{ Auth::guard('vendor')->user()->name }}</span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>
            </div>

            <div class="d-flex align-items-center">

                @php
                    $vendorAuth = Auth::guard('vendor')->user();
                    $vendorUnreadCount = $vendorAuth ? $vendorAuth->unreadNotifications()->count() : 0;
                    $vendorRecentNotifs = $vendorAuth ? $vendorAuth->notifications()->latest()->take(8)->get() : collect();
                @endphp

                {{-- Notifications --}}
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect position-relative" data-bs-toggle="dropdown">
                        <i class="mdi mdi-bell-outline"></i>
                        @if($vendorUnreadCount > 0)
                            <span class="badge bg-danger rounded-pill position-absolute" style="top:8px;right:8px;font-size:9px;padding:2px 5px">
                                {{ $vendorUnreadCount > 9 ? '9+' : $vendorUnreadCount }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0 shadow" style="min-width:300px;max-height:380px;overflow-y:auto">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">التنبيهات</h6>
                            @if($vendorUnreadCount > 0)
                                <form action="{{ route('vendor.notifications.read-all') }}" method="post" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none" style="font-size:12px">تعليم الكل كمقروء</button>
                                </form>
                            @endif
                        </div>
                        @forelse($vendorRecentNotifs as $n)
                            @php $d = $n->data; $href = $d['url'] ?? route('vendor.orders'); @endphp
                            <form action="{{ route('vendor.notifications.read', $n->id) }}" method="post" class="m-0">
                                @csrf
                                <input type="hidden" name="redirect" value="{{ $href }}">
                                <button type="submit" class="dropdown-item py-2 text-start border-bottom {{ $n->read_at ? '' : 'fw-semibold bg-light' }}" style="white-space:normal">
                                    <span class="d-block small">{{ $d['title'] ?? 'تنبيه' }}</span>
                                    <span class="text-muted" style="font-size:11px">{{ $d['body'] ?? '' }}</span>
                                </button>
                            </form>
                        @empty
                            <div class="p-4 text-center text-muted small">لا توجد تنبيهات</div>
                        @endforelse
                    </div>
                </div>

                {{-- User dropdown --}}
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-primary"
                             style="width:36px;height:36px;background:#e8eaf6;font-size:14px">
                            {{ strtoupper(substr($vendorAuth->name, 0, 1)) }}
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="px-3 py-2 border-bottom">
                            <div class="fw-semibold small">{{ $vendorAuth->name }}</div>
                            <div class="text-muted" style="font-size:11px" dir="ltr">{{ $vendorAuth->email }}</div>
                        </div>
                        <a class="dropdown-item" href="{{ route('vendor.profile') }}">
                            <i class="mdi mdi-account-outline me-2"></i> الملف الشخصي
                        </a>
                        <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                            <i class="mdi mdi-storefront-outline me-2"></i> زيارة المتجر
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('vendor.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="mdi mdi-logout me-2"></i> تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- ===== Sidebar ===== --}}
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">

                    <li class="menu-title">
                        <span class="vendor-badge">🏪 بائع</span>
                    </li>

                    <li>
                        <a href="{{ route('vendor.dashboard') }}" class="waves-effect {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>

                    <li class="menu-title">المتجر</li>

                    <li>
                        <a href="{{ route('vendor.products') }}" class="waves-effect {{ request()->routeIs('vendor.products*') ? 'active' : '' }}">
                            <i class="mdi mdi-shopping-outline"></i>
                            <span>منتجاتي</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vendor.orders') }}" class="waves-effect {{ request()->routeIs('vendor.orders*') ? 'active' : '' }}">
                            <i class="mdi mdi-package-variant"></i>
                            <span>الطلبات</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vendor.returns') }}" class="waves-effect {{ request()->routeIs('vendor.returns') ? 'active' : '' }}">
                            <i class="mdi mdi-keyboard-return"></i>
                            <span>الإرجاع</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vendor.discount_code.index') }}" class="waves-effect {{ request()->routeIs('vendor.discount_code*') ? 'active' : '' }}">
                            <i class="mdi mdi-ticket-percent-outline"></i>
                            <span>كوبونات الخصم</span>
                        </a>
                    </li>

                    <li class="menu-title">التقارير</li>

                    <li>
                        <a href="{{ route('vendor.reports.index') }}" class="waves-effect {{ request()->routeIs('vendor.reports*') ? 'active' : '' }}">
                            <i class="mdi mdi-chart-box-outline"></i>
                            <span>التقارير</span>
                        </a>
                    </li>

                    <li class="menu-title">الحساب</li>

                    <li>
                        <a href="{{ route('vendor.customers') }}" class="waves-effect {{ request()->routeIs('vendor.customers') ? 'active' : '' }}">
                            <i class="mdi mdi-account-group-outline"></i>
                            <span>عملائي</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vendor.profile') }}" class="waves-effect {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
                            <i class="mdi mdi-account-outline"></i>
                            <span>الملف الشخصي</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    {{-- ===== Main content ===== --}}
    <div class="main-content">
        <div class="page-content">

            {{-- Breadcrumb --}}
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="page-title">@yield('title', 'لوحة التحكم')</h5>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">البائع</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('dark'))
                <div class="alert alert-warning alert-dismissible fade show">
                    {{ session('dark') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </div>

        {{-- Footer --}}
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">© {{ date('Y') }} متجري</div>
                    <div class="col-sm-6 text-end">
                        <span class="vendor-badge" style="background:#e8eaf6;color:#1a237e;border-color:#c5cae9">🏪 لوحة البائع</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</div>

{{-- Scripts --}}
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

@stack('scripts')
</body>
</html>
