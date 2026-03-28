<template>
    <div class="profile-page">
        <!-- Hero banner -->
        <div class="profile-hero">
            <div class="profile-hero-overlay" />
            <v-container class="profile-hero-content">
                <div class="d-flex align-center" style="gap:20px">
                    <div class="avatar-wrapper">
                        <v-avatar size="88" color="white" class="avatar-ring">
                            <v-img v-if="user?.image_url" :src="user.image_url" cover />
                            <span v-else class="text-primary font-weight-bold" style="font-size:32px">
                                {{ user?.first_name?.charAt(0) }}
                            </span>
                        </v-avatar>
                    </div>
                    <div>
                        <h2 class="text-white font-weight-bold" style="font-size:22px">
                            {{ user?.first_name }} {{ user?.family_name }}
                        </h2>
                        <p class="text-white" style="opacity:0.8; font-size:14px">{{ user?.email }}</p>
                        <div class="d-flex mt-2" style="gap:16px">
                            <div class="stat-chip">
                                <span class="stat-num">{{ user?.orders?.length || 0 }}</span>
                                <span class="stat-label">طلب</span>
                            </div>
                            <div class="stat-chip">
                                <span class="stat-num">{{ user?.addresses?.length || 0 }}</span>
                                <span class="stat-label">عنوان</span>
                            </div>
                            <div class="stat-chip">
                                <span class="stat-num">{{ user?.wishlist_products?.length || 0 }}</span>
                                <span class="stat-label">مفضلة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </v-container>
        </div>

        <v-container class="mt-n4">
            <v-row>
                <!-- Sidebar -->
                <v-col cols="12" md="3">
                    <v-card rounded="xl" elevation="2" class="sidebar-card">
                        <v-list nav density="compact" class="pa-2">
                            <v-list-item
                                v-for="item in tabs"
                                :key="item.value"
                                :prepend-icon="item.icon"
                                :title="item.label"
                                rounded="lg"
                                class="mb-1 sidebar-item"
                                :class="{ 'sidebar-item--active': tab === item.value }"
                                @click="tab = item.value"
                            >
                                <template #append>
                                    <v-badge
                                        v-if="item.badge"
                                        :content="item.badge"
                                        color="primary"
                                        inline
                                    />
                                </template>
                            </v-list-item>
                        </v-list>

                        <v-divider class="mx-3 mb-2" />

                        <div class="pa-3">
                            <v-btn
                                block
                                variant="tonal"
                                color="error"
                                rounded="lg"
                                style="text-transform:none"
                                prepend-icon="mdi-logout"
                                @click="logout"
                            >
                                تسجيل الخروج
                            </v-btn>
                        </div>
                    </v-card>
                </v-col>

                <!-- Content -->
                <v-col cols="12" md="9">
                    <v-card rounded="xl" elevation="2" class="content-card">
                        <!-- Tab header -->
                        <div class="content-header">
                            <v-icon :color="activeTab?.color || 'primary'" size="22" class="me-2">
                                {{ activeTab?.icon }}
                            </v-icon>
                            <span class="font-weight-bold" style="font-size:17px">{{ activeTab?.label }}</span>
                        </div>
                        <v-divider />

                        <div class="pa-5">
                            <v-tabs-window v-model="tab">
                                <v-tabs-window-item value="account">
                                    <UserAccount :user="page.props.user" />
                                </v-tabs-window-item>
                                <v-tabs-window-item value="wishlist">
                                    <UserWishlist :user="page.props.user" />
                                </v-tabs-window-item>
                                <v-tabs-window-item value="orders">
                                    <UserOrders :user="page.props.user" />
                                </v-tabs-window-item>
                                <v-tabs-window-item value="returns">
                                    <UserReturns :user="page.props.user" />
                                </v-tabs-window-item>
                                <v-tabs-window-item value="addresses">
                                    <UserAddresses :user="page.props.user" />
                                </v-tabs-window-item>
                            </v-tabs-window>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import UserAccount   from './Partials/UserAccount.vue';
import UserWishlist  from './Partials/UserWishlist.vue';
import UserOrders    from './Partials/UserOrders.vue';
import UserAddresses from './Partials/UserAddresses.vue';
import UserReturns   from './Partials/UserReturns.vue';

const page = usePage();
const user = computed(() => page.props.user);
const tab  = ref('account');

const tabs = computed(() => [
    { value: 'account',   label: 'بياناتي',   icon: 'mdi-account-outline',    color: 'primary' },
    { value: 'orders',    label: 'طلباتي',    icon: 'mdi-package-variant',     color: 'blue',   badge: user.value?.orders?.length || null },
    { value: 'wishlist',  label: 'المفضلة',   icon: 'mdi-heart-outline',       color: 'red',    badge: user.value?.wishlist_products?.length || null },
    { value: 'addresses', label: 'عناويني',   icon: 'mdi-map-marker-outline',  color: 'green' },
    { value: 'returns',   label: 'المرتجعات', icon: 'mdi-arrow-u-left-top',    color: 'orange' },
]);

const activeTab = computed(() => tabs.value.find(t => t.value === tab.value));

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const t = urlParams.get('tab');
    if (t) tab.value = t;
});

watch(tab, (val) => {
    const url = new URL(window.location.href);
    url.searchParams.set('tab', val);
    window.history.replaceState({}, '', url);
});

const logout = () => router.post(route('logout'));
</script>

<style scoped>
.profile-page {
    background: #f5f6fa;
    min-height: 100vh;
    padding-bottom: 48px;
}

.profile-hero {
    background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
    padding: 40px 0 60px;
    position: relative;
    overflow: hidden;
}

.profile-hero::before {
    content: '';
    position: absolute;
    width: 350px;
    height: 350px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -120px;
    left: -80px;
}

.profile-hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.08);
}

.profile-hero-content {
    position: relative;
    z-index: 1;
}

.avatar-ring {
    border: 3px solid rgba(255,255,255,0.6) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.stat-chip {
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    padding: 4px 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-num {
    color: white;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.2;
}

.stat-label {
    color: rgba(255,255,255,0.75);
    font-size: 11px;
}

.sidebar-card {
    position: sticky;
    top: 80px;
}

.sidebar-item {
    cursor: pointer;
    transition: all 0.15s;
}

.sidebar-item--active {
    background: #e8eaf6 !important;
    color: #1a237e !important;
}

.sidebar-item--active :deep(.v-list-item__prepend .v-icon) {
    color: #1a237e !important;
}

.content-card {
    min-height: 500px;
}

.content-header {
    display: flex;
    align-items: center;
    padding: 16px 20px;
}
</style>
