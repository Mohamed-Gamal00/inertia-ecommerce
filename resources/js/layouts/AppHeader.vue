<template>
    <!-- Main App Bar -->
    <v-app-bar elevation="0" color="primary" height="64">
        <v-container fluid class="d-flex align-center" style="gap:8px">

            <!-- Mobile: hamburger -->
            <v-app-bar-nav-icon class="d-md-none" @click="mobileDrawer = !mobileDrawer" />

            <!-- Logo -->
            <Link href="/" class="d-flex align-center text-decoration-none me-4">
                <v-icon color="white" size="28" class="me-1">mdi-storefront</v-icon>
                <span class="font-weight-bold text-white" style="font-size:18px">متجري</span>
            </Link>

            <!-- Desktop nav links -->
            <div class="d-none d-md-flex align-center" style="gap:4px">
                <Link
                    v-for="item in menu"
                    :key="item.href"
                    :href="item.href"
                    class="nav-link text-decoration-none"
                    :class="{ 'nav-link--active': isActive(item.href) }"
                >
                    {{ item.title }}
                </Link>

                <!-- Categories dropdown -->
                <v-menu open-on-hover :close-on-content-click="true">
                    <template #activator="{ props: menuProps }">
                        <button class="nav-link" v-bind="menuProps">
                            الأقسام
                            <v-icon size="16" class="ms-1">mdi-chevron-down</v-icon>
                        </button>
                    </template>
                    <v-card min-width="180" elevation="3" rounded="lg">
                        <v-list density="compact" nav>
                            <v-list-item
                                v-for="cat in categories"
                                :key="cat.id"
                                :title="cat.name"
                                rounded="lg"
                                :href="`/categories/${cat.slug}`"
                            />
                        </v-list>
                    </v-card>
                </v-menu>
            </div>

            <v-spacer />

            <!-- Search bar (desktop) -->
            <v-text-field
                v-model="search"
                placeholder="ابحث عن منتج..."
                hide-details
                single-line
                variant="outlined"
                density="compact"
                rounded="lg"
                prepend-inner-icon="mdi-magnify"
                class="d-none d-md-flex search-field"
                style="max-width:260px"
                bg-color="grey-lighten-5"
            />

            <!-- Cart icon -->
            <v-btn icon variant="text" @click="openCart" class="ms-1" color="white">
                <v-badge :content="cartCount || ''" :model-value="cartCount > 0" color="red" floating>
                    <v-icon>mdi-cart-outline</v-icon>
                </v-badge>
            </v-btn>

            <!-- Auth: logged in -->
            <template v-if="user">
                <v-menu :close-on-content-click="true">
                    <template #activator="{ props: menuProps }">
                        <v-btn variant="text" v-bind="menuProps" class="ms-1 d-none d-md-flex text-white" style="text-transform:none">
                            <v-avatar color="primary" size="32" class="me-2">
                                <span class="text-white" style="font-size:13px; font-weight:700">
                                    {{ user.first_name?.charAt(0) }}
                                </span>
                            </v-avatar>
                            {{ user.first_name }}
                            <v-icon size="16" class="ms-1">mdi-chevron-down</v-icon>
                        </v-btn>
                    </template>
                    <v-card min-width="180" elevation="3" rounded="lg">
                        <v-list density="compact" nav>
                            <v-list-item prepend-icon="mdi-account-outline" title="حسابي" rounded="lg" href="/user-profile" />
                            <v-divider class="my-1" />
                            <v-list-item prepend-icon="mdi-logout" rounded="lg" base-color="red">
                                <Link href="/logout" method="post" as="button" class="text-decoration-none text-red" style="font-size:14px">
                                    تسجيل الخروج
                                </Link>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-menu>
            </template>

            <!-- Auth: guest -->
            <template v-else>
                <div class="d-none d-md-flex align-center ms-2" style="gap:8px">
                    <Link href="/login">
                        <v-btn variant="text" size="small" style="text-transform:none; font-size:13px; color:white">
                            دخول
                        </v-btn>
                    </Link>
                    <Link href="/register">
                        <v-btn color="white" size="small" rounded="lg" style="text-transform:none; font-size:13px; color:#1a237e">
                            حساب جديد
                        </v-btn>
                    </Link>
                </div>
            </template>

        </v-container>
    </v-app-bar>

    <!-- Mobile Drawer -->
    <v-navigation-drawer v-model="mobileDrawer" temporary location="right" width="280">
        <div class="pa-4 d-flex align-center border-b">
            <v-icon color="primary" class="me-2">mdi-storefront</v-icon>
            <span class="font-weight-bold text-primary">متجري</span>
            <v-spacer />
            <v-btn icon variant="text" size="small" @click="mobileDrawer = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </div>

        <!-- Mobile search -->
        <div class="pa-3">
            <v-text-field
                v-model="search"
                placeholder="ابحث عن منتج..."
                hide-details
                variant="outlined"
                density="compact"
                rounded="lg"
                prepend-inner-icon="mdi-magnify"
                bg-color="grey-lighten-5"
            />
        </div>

        <v-list nav density="compact">
            <v-list-item
                v-for="item in menu"
                :key="item.href"
                :title="item.title"
                :prepend-icon="item.icon"
                :href="item.href"
                rounded="lg"
                @click="mobileDrawer = false"
            />

            <v-list-group value="categories">
                <template #activator="{ props: groupProps }">
                    <v-list-item v-bind="groupProps" title="الأقسام" prepend-icon="mdi-shape-outline" rounded="lg" />
                </template>
                <v-list-item
                    v-for="cat in categories"
                    :key="cat.id"
                    :title="cat.name"
                    :href="`/categories/${cat.slug}`"
                    rounded="lg"
                    @click="mobileDrawer = false"
                />
            </v-list-group>
        </v-list>

        <v-divider class="my-2" />

        <!-- Mobile auth -->
        <div class="pa-3">
            <template v-if="user">
                <div class="d-flex align-center mb-3 px-2">
                    <v-avatar color="primary" size="36" class="me-3">
                        <span class="text-white font-weight-bold">{{ user.first_name?.charAt(0) }}</span>
                    </v-avatar>
                    <div>
                        <div class="font-weight-bold" style="font-size:14px">{{ user.first_name }} {{ user.family_name }}</div>
                        <div class="text-grey" style="font-size:12px">{{ user.email }}</div>
                    </div>
                </div>
                <v-btn block variant="outlined" color="primary" rounded="lg" href="/user-profile" style="text-transform:none" class="mb-2">
                    حسابي
                </v-btn>
                <Link href="/logout" method="post" as="button" class="w-100">
                    <v-btn block variant="tonal" color="red" rounded="lg" style="text-transform:none">
                        تسجيل الخروج
                    </v-btn>
                </Link>
            </template>
            <template v-else>
                <v-btn block color="primary" rounded="lg" href="/login" style="text-transform:none" class="mb-2">
                    تسجيل الدخول
                </v-btn>
                <v-btn block variant="outlined" color="primary" rounded="lg" href="/register" style="text-transform:none">
                    إنشاء حساب
                </v-btn>
            </template>
        </div>
    </v-navigation-drawer>
</template>

<script setup>
import { ref, inject, computed, onMounted, onBeforeUnmount } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const Emitter = inject('Emitter');
const mobileDrawer = ref(false);
const search = ref('');
const cartCount = ref(0);

const { props } = usePage();
const categories = computed(() => usePage().props.categories ?? []);
const user = computed(() => usePage().props.auth?.user);

const menu = [
    { title: 'الرئيسية',  href: '/',          icon: 'mdi-home-outline' },
    { title: 'المنتجات',  href: '/products',   icon: 'mdi-shopping-outline' },
    { title: 'العروض',    href: '/offers',     icon: 'mdi-tag-outline' },
    { title: 'الماركات',  href: '/brands',     icon: 'mdi-store-outline' },
    { title: 'تواصل معنا', href: '/contact-us', icon: 'mdi-email-outline' },
];

function isActive(href) {
    return window.location.pathname === href;
}

function openCart() {
    Emitter.emit('openCart');
}

function updateCart(count) {
    cartCount.value = count;
}

onMounted(() => Emitter.on('cart-updated', updateCart));
onBeforeUnmount(() => Emitter.off('cart-updated', updateCart));
</script>

<style scoped>
.nav-link {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: rgba(255,255,255,0.85);
    transition: background 0.15s, color 0.15s;
    cursor: pointer;
    border: none;
    background: none;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.nav-link:hover {
    background: rgba(255,255,255,0.15);
    color: #ffffff;
}

.nav-link--active {
    background: rgba(255,255,255,0.2);
    color: #ffffff;
    font-weight: 600;
}

.search-field :deep(.v-field) {
    font-size: 13px;
}

.border-b {
    border-bottom: 1px solid #e5e7eb;
}
</style>
