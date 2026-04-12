<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">

        {{-- ══ Dashboard ══ --}}
        <li>
            <a href="{{ route('dashboard.index') }}" class="waves-effect">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span>لوحة التحكم</span>
            </a>
        </li>

        {{-- ══ Catalog ══ --}}
        <li class="menu-title">الكتالوج</li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-shopping-outline"></i>
                <span>المنتجات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('products.index') }}">جميع المنتجات</a></li>
                <li><a href="{{ route('products.create') }}">إضافة منتج</a></li>
                <li><a href="{{ route('out_of_stock') }}">نفذت الكمية</a></li>
                <li><a href="{{ route('products.trash') }}">المحذوفات</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-shape-outline"></i>
                <span>الأقسام والخيارات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('main_categories.index') }}">الأقسام</a></li>
                <li><a href="{{ route('main_choices.index') }}">الخيارات</a></li>
                <li><a href="{{ route('colors.index') }}">الألوان</a></li>
                <li><a href="{{ route('product_availability.index') }}">حالات التوفر</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-domain"></i>
                <span>البراندات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('companies.index') }}">جميع البراندات</a></li>
                <li><a href="{{ route('companies.create') }}">إضافة براند</a></li>
            </ul>
        </li>

        {{-- ══ Sales ══ --}}
        <li class="menu-title">المبيعات</li>

        <li>
            <a href="javascript:void(0);" class="{{ $unreadOrderCreatedCount > 0 ? '' : 'has-arrow' }} waves-effect">
                @if($unreadOrderCreatedCount > 0)
                    <span class="badge rounded-pill bg-danger float-end">{{ $unreadOrderCreatedCount }}</span>
                @endif
                <i class="mdi mdi-package-variant-closed"></i>
                <span>الطلبات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('orders.index') }}">جميع الطلبات</a></li>
                <li><a href="{{ route('return_orders.index') }}">المرتجعات</a></li>
                <li><a href="{{ route('bulk_orders.index') }}">طلبات الجملة</a></li>
                <li><a href="{{ route('representatives_orders.index') }}">طلبات المناديب</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-credit-card-outline"></i>
                <span>المدفوعات والخصومات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('payments.index') }}">سجل المدفوعات</a></li>
                <li><a href="{{ route('discount_code.index') }}">أكواد الخصم</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-truck-delivery-outline"></i>
                <span>الشحن والتوصيل</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('shipping.index') }}">إعدادات الشحن</a></li>
                <li><a href="{{ route('order_status.index') }}">حالات الطلب</a></li>
                <li><a href="{{ route('countries.index') }}">الدول</a></li>
                <li><a href="{{ route('cities.index') }}">المدن</a></li>
            </ul>
        </li>

        {{-- ══ Vendors ══ --}}
        <li class="menu-title">البائعون</li>

        <li>
            <a href="{{ route('vendors.index') }}" class="waves-effect">
                @php $pendingVendors = \App\Models\Company::where('is_vendor', true)->where('status', 'pending')->count(); @endphp
                @if($pendingVendors > 0)
                    <span class="badge rounded-pill bg-warning text-dark float-end">{{ $pendingVendors }}</span>
                @endif
                <i class="mdi mdi-store-outline"></i>
                <span>البائعون</span>
            </a>
        </li>

        {{-- ══ Customers ══ --}}
        <li class="menu-title">العملاء</li>

        <li>
            <a href="{{ route('clients.index') }}" class="waves-effect">
                <i class="mdi mdi-account-group-outline"></i>
                <span>العملاء</span>
            </a>
        </li>

        <li>
            <a href="javascript:void(0);" class="{{ $unreadMessageCount > 0 ? '' : 'has-arrow' }} waves-effect">
                @if($unreadMessageCount > 0)
                    <span class="badge rounded-pill bg-danger float-end">{{ $unreadMessageCount }}</span>
                @endif
                <i class="mdi mdi-email-outline"></i>
                <span>التواصل والنشرة</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('contact_us.index') }}">رسائل التواصل</a></li>
                <li><a href="{{ route('user_news.create') }}">النشرة البريدية</a></li>
            </ul>
        </li>

        {{-- ══ Content ══ --}}
        <li class="menu-title">المحتوى</li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-image-multiple-outline"></i>
                <span>التصميم والمظهر</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('banners.index') }}">البنرات</a></li>
                <li><a href="{{ route('designs.index') }}">التصاميم</a></li>
                <li><a href="{{ route('advertisements.index') }}">الشريط الإعلاني</a></li>
                <li><a href="{{ route('store_featuers.index') }}">ميزات المتجر</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-file-document-outline"></i>
                <span>الصفحات والمحتوى</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('pages.index') }}">صفحات الموقع</a></li>
                <li><a href="{{ route('common_questions.index') }}">الأسئلة الشائعة</a></li>
            </ul>
        </li>

        {{-- ══ Analytics & System ══ --}}
        <li class="menu-title">النظام</li>

        <li>
            <a href="{{ route('reports.index') }}" class="waves-effect">
                <i class="mdi mdi-chart-bar"></i>
                <span>التقارير</span>
            </a>
        </li>

        <li>
            <a href="{{ route('front_settings') }}" class="waves-effect">
                <i class="mdi mdi-cog-outline"></i>
                <span>إعدادات الموقع</span>
            </a>
        </li>

        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-currency-usd"></i>
                <span>العملات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('currencies.index') }}">إدارة العملات</a></li>
            </ul>
        </li>

        @can('admin.view')
        <li>
            <a href="javascript:void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-shield-account-outline"></i>
                <span>إدارة المدراء</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('admins.index') }}">المدراء</a></li>
                <li><a href="{{ route('rules.index') }}">الصلاحيات</a></li>
            </ul>
        </li>
        @endcan

    </ul>
</div>

<style>
/* ── Sidebar polish ── */
#sidebar-menu .menu-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35) !important;
    padding: 18px 20px 6px;
    margin: 0;
}

#sidebar-menu ul li a {
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background 0.15s, color 0.15s;
    border-radius: 0;
}

#sidebar-menu ul li a i {
    font-size: 17px;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
    opacity: 0.85;
}

#sidebar-menu ul li a:hover,
#sidebar-menu ul li a.active {
    color: #fff !important;
    background: rgba(255,255,255,0.08);
}

/* Sub-menu items — slightly indented, smaller */
#sidebar-menu .sub-menu li a {
    font-size: 13px;
    font-weight: 400;
    padding: 8px 20px 8px 36px;
    color: rgba(255,255,255,0.65) !important;
    gap: 0;
}

#sidebar-menu .sub-menu li a::before {
    content: '';
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(255,255,255,0.35);
    margin-left: 10px;
    flex-shrink: 0;
    transition: background 0.15s;
}

#sidebar-menu .sub-menu li a:hover::before,
#sidebar-menu .sub-menu li a.active::before {
    background: #fff;
}

#sidebar-menu .sub-menu li a:hover {
    color: #fff !important;
    background: rgba(255,255,255,0.05);
}

/* Active parent highlight */
#sidebar-menu ul li.mm-active > a {
    color: #fff !important;
    background: rgba(255,255,255,0.1);
}

/* Badge alignment */
#sidebar-menu ul li a .badge {
    margin-top: 2px;
}
</style>
