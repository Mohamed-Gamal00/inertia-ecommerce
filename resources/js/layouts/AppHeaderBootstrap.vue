<template>
  <!-- Main Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="min-height: 64px;">
    <div class="container-fluid px-3">

      <!-- Mobile Hamburger -->
      <button
        class="navbar-toggler border-0 d-lg-none"
        type="button"
        @click="mobileDrawer = !mobileDrawer"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Logo -->
      <Link href="/" class="navbar-brand d-flex align-items-center text-decoration-none me-4">
        <i class="bi bi-shop text-white me-2" style="font-size: 28px;"></i>
        <span class="fw-bold text-white" style="font-size: 18px;">{{ siteName }}</span>
      </Link>

      <!-- Desktop Nav Links -->
      <div class="d-none d-lg-flex align-items-center" style="gap: 4px;">
        <Link
          v-for="item in menu"
          :key="item.href"
          :href="item.href"
          class="nav-link-custom"
          :class="{ 'nav-link-active': isActive(item.href) }"
        >
          {{ item.title }}
        </Link>

        <!-- Categories Dropdown -->
        <div class="dropdown">
          <button
            class="nav-link-custom dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            {{ t('categories') }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li v-for="cat in categories" :key="cat.id">
              <a
                :href="`/categories/${cat.slug}`"
                class="dropdown-item"
              >
                {{ pick(cat, 'name') }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Spacer -->
      <div class="flex-grow-1"></div>

      <!-- Desktop Search -->
      <GlobalSearch class="d-none d-lg-flex me-2" />

      <!-- Language Switcher -->
      <button
        class="btn btn-sm btn-link text-white text-decoration-none d-none d-lg-flex ms-1"
        style="text-transform: none; font-size: 12px; font-weight: 700; min-width: 0; padding: 0 8px;"
        @click="switchLocale(locale === 'ar' ? 'en' : 'ar')"
        :title="t('switch_language')"
      >
        {{ locale === 'ar' ? 'EN' : 'ع' }}
      </button>

      <!-- Cart Icon -->
      <button
        class="btn btn-link text-white position-relative ms-2"
        @click="openCart"
        data-cart-icon
        aria-label="Shopping Cart"
      >
        <i class="bi bi-cart3" style="font-size: 20px;"></i>
        <span
          v-if="cartCount > 0"
          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
          style="font-size: 10px;"
        >
          {{ cartCount }}
        </span>
      </button>

      <!-- Auth: Logged In -->
      <div v-if="user" class="dropdown d-none d-lg-block ms-2">
        <button
          class="btn btn-link text-white text-decoration-none d-flex align-items-center"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          style="text-transform: none;"
        >
          <span
            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white me-2"
            style="width: 32px; height: 32px; font-size: 13px; font-weight: 700;"
          >
            {{ user.first_name?.charAt(0) }}
          </span>
          {{ user.first_name }}
          <i class="bi bi-chevron-down ms-1" style="font-size: 12px;"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow">
          <li>
            <a href="/user-profile" class="dropdown-item">
              <i class="bi bi-person me-2"></i>
              {{ t('my_account') }}
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <Link
              href="/logout"
              method="post"
              as="button"
              class="dropdown-item text-danger"
            >
              <i class="bi bi-box-arrow-right me-2"></i>
              {{ t('logout') }}
            </Link>
          </li>
        </ul>
      </div>

      <!-- Auth: Guest -->
      <div v-else class="d-none d-lg-flex align-items-center ms-2" style="gap: 8px;">
        <Link href="/login">
          <button class="btn btn-sm btn-link text-white text-decoration-none" style="text-transform: none; font-size: 13px;">
            {{ t('login') }}
          </button>
        </Link>
        <Link href="/register">
          <button class="btn btn-sm btn-light text-primary" style="text-transform: none; font-size: 13px; border-radius: 8px;">
            {{ t('register') }}
          </button>
        </Link>
      </div>

    </div>
  </nav>

  <!-- Mobile Offcanvas -->
  <div
    class="offcanvas offcanvas-end"
    :class="{ show: mobileDrawer }"
    :style="{ visibility: mobileDrawer ? 'visible' : 'hidden' }"
    tabindex="-1"
    id="mobileMenu"
  >
    <!-- Header -->
    <div class="offcanvas-header border-bottom">
      <div class="d-flex align-items-center">
        <i class="bi bi-shop text-primary me-2" style="font-size: 20px;"></i>
        <span class="fw-bold text-primary">{{ siteName }}</span>
      </div>
      <button
        type="button"
        class="btn-close"
        @click="mobileDrawer = false"
        aria-label="Close"
      ></button>
    </div>

    <!-- Mobile Search -->
    <div class="p-3">
      <div class="input-group">
        <span class="input-group-text bg-light border-end-0">
          <i class="bi bi-search"></i>
        </span>
        <input
          v-model="search"
          type="text"
          class="form-control border-start-0"
          :placeholder="t('search_placeholder')"
          @keyup.enter="handleMobileSearch"
        >
      </div>
    </div>

    <!-- Mobile Menu -->
    <div class="offcanvas-body">
      <ul class="list-unstyled">
        <li v-for="item in menu" :key="item.href" class="mb-2">
          <a
            :href="item.href"
            class="mobile-menu-link"
            @click="mobileDrawer = false"
          >
            <i :class="`bi ${item.icon} me-2`"></i>
            {{ item.title }}
          </a>
        </li>

        <!-- Categories (Collapsible) -->
        <li class="mb-2">
          <button
            class="mobile-menu-link w-100 text-start border-0 bg-transparent"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mobileCategories"
          >
            <i class="bi bi-grid me-2"></i>
            {{ t('categories') }}
            <i class="bi bi-chevron-down float-end"></i>
          </button>
          <div class="collapse" id="mobileCategories">
            <ul class="list-unstyled ps-4 mt-2">
              <li v-for="cat in categories" :key="cat.id" class="mb-2">
                <a
                  :href="`/categories/${cat.slug}`"
                  class="mobile-menu-link"
                  @click="mobileDrawer = false"
                >
                  {{ pick(cat, 'name') }}
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>

      <hr>

      <!-- Mobile Auth -->
      <div v-if="user">
        <div class="d-flex align-items-center mb-3 px-2">
          <span
            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white me-3"
            style="width: 36px; height: 36px; font-weight: 700;"
          >
            {{ user.first_name?.charAt(0) }}
          </span>
          <div>
            <div class="fw-bold" style="font-size: 14px;">{{ user.first_name }} {{ user.family_name }}</div>
            <div class="text-muted" style="font-size: 12px;">{{ user.email }}</div>
          </div>
        </div>
        <a href="/user-profile" class="btn btn-outline-primary w-100 mb-2" style="text-transform: none;">
          {{ t('my_account') }}
        </a>
        <Link href="/logout" method="post" as="button" class="w-100">
          <button class="btn btn-danger w-100" style="text-transform: none;">
            {{ t('logout') }}
          </button>
        </Link>
      </div>
      <div v-else>
        <a href="/login" class="btn btn-primary w-100 mb-2" style="text-transform: none;">
          {{ t('login') }}
        </a>
        <a href="/register" class="btn btn-outline-primary w-100" style="text-transform: none;">
          {{ t('register') }}
        </a>
      </div>
    </div>
  </div>

  <!-- Backdrop for mobile menu -->
  <div
    v-if="mobileDrawer"
    class="offcanvas-backdrop fade show"
    @click="mobileDrawer = false"
  ></div>
</template>

<script setup>
import { ref, inject, computed, onMounted, onBeforeUnmount } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import GlobalSearch from '../components/Shared/GlobalSearch.vue';
import { useLocale } from '../composables/useLocale';

const Emitter = inject('Emitter');
const mobileDrawer = ref(false);
const search = ref('');
const cartCount = ref(0);

const { props } = usePage();
const categories = computed(() => usePage().props.categories ?? []);
const user = computed(() => usePage().props.auth?.user);
const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { locale, switchLocale, t, pick } = useLocale();

const menu = computed(() => [
  { title: t('home'),       href: '/',          icon: 'bi-house' },
  { title: t('products'),   href: '/products',  icon: 'bi-bag' },
  { title: t('offers'),     href: '/offers',    icon: 'bi-tag' },
  { title: t('brands'),     href: '/brands',    icon: 'bi-shop' },
  { title: t('contact_us'), href: '/contact-us', icon: 'bi-envelope' },
]);

function isActive(href) {
  return window.location.pathname === href;
}

function openCart() {
  Emitter.emit('openCart');
}

function updateCart(count) {
  cartCount.value = count;
}

function handleMobileSearch() {
  if (search.value.trim()) {
    router.visit(`/search?q=${encodeURIComponent(search.value.trim())}`);
    mobileDrawer.value = false;
  }
}

onMounted(() => Emitter.on('cart-updated', updateCart));
onBeforeUnmount(() => Emitter.off('cart-updated', updateCart));
</script>

<style scoped>
/* Custom Nav Links */
.nav-link-custom {
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.85);
  transition: background 0.15s, color 0.15s;
  cursor: pointer;
  border: none;
  background: none;
  display: flex;
  align-items: center;
  text-decoration: none;
}

.nav-link-custom:hover {
  background: rgba(255, 255, 255, 0.15);
  color: #ffffff;
}

.nav-link-active {
  background: rgba(255, 255, 255, 0.2);
  color: #ffffff;
  font-weight: 600;
}

/* Mobile Menu */
.mobile-menu-link {
  display: block;
  padding: 10px 12px;
  color: #374151;
  text-decoration: none;
  border-radius: 8px;
  transition: background 0.15s;
  font-size: 14px;
}

.mobile-menu-link:hover {
  background: #f3f4f6;
  color: #1976d2;
}

/* Offcanvas Customization */
.offcanvas {
  width: 280px !important;
}

.offcanvas.show {
  transform: none;
}

/* Cart Bounce */
:global(.cart-bounce) {
  animation: cartBounce 0.6s ease !important;
}

@keyframes cartBounce {
  0%   { transform: scale(1); }
  30%  { transform: scale(1.4) rotate(-10deg); }
  60%  { transform: scale(0.9) rotate(5deg); }
  80%  { transform: scale(1.1); }
  100% { transform: scale(1); }
}
</style>
