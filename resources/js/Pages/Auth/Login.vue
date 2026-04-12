<template>
    <div class="auth-page">
        <!-- Left panel: branding -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <v-icon size="56" color="white" class="mb-4">mdi-storefront</v-icon>
                <h1 class="text-white font-weight-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    {{ t('login_tagline') }}
                </p>
                <div class="auth-features mt-8">
                    <div class="feature-item" v-for="f in features" :key="f.text">
                        <v-icon color="white" size="20" class="me-2">{{ f.icon }}</v-icon>
                        <span class="text-white" style="font-size:14px">{{ f.text }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel: form -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <!-- Mobile logo -->
                <div class="d-flex d-md-none align-center mb-6">
                    <v-icon size="32" color="primary" class="me-2">mdi-storefront</v-icon>
                    <span class="font-weight-bold text-h6">{{ siteName }}</span>
                </div>

                <h2 class="font-weight-bold mb-1" style="font-size:26px">{{ t('login_welcome') }}</h2>
                <p class="text-grey-darken-1 mb-6" style="font-size:14px">{{ t('login_subtitle') }}</p>

                <v-alert v-if="errorMessage" type="error" variant="tonal" rounded="lg" class="mb-5" density="compact">
                    {{ errorMessage }}
                </v-alert>

                <v-form @submit.prevent="submit">
                    <label class="field-label">{{ t('login_email') }}</label>
                    <v-text-field v-model="form.email" placeholder="example@email.com" variant="outlined" density="comfortable" hide-details="auto" class="mb-4 mt-1" prepend-inner-icon="mdi-email-outline" dir="ltr" rounded="lg" bg-color="grey-lighten-5" />

                    <label class="field-label">{{ t('login_password') }}</label>
                    <v-text-field v-model="form.password" placeholder="••••••••" :type="showPassword ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" class="mb-2 mt-1" prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPassword = !showPassword" rounded="lg" bg-color="grey-lighten-5" />

                    <div class="d-flex justify-end mb-5">
                        <a :href="route('forgot')" class="text-primary text-decoration-none" style="font-size:13px">
                            {{ t('login_forgot') }}
                        </a>
                    </div>

                    <v-btn type="submit" color="primary" block height="48" rounded="lg" :loading="loading" style="font-size:15px; font-weight:600; text-transform:none">
                        {{ t('login_btn') }}
                    </v-btn>
                </v-form>

                <v-divider class="my-6"><span class="text-grey" style="font-size:13px">{{ t('login_or') }}</span></v-divider>
                <div class="text-center" style="font-size:14px">
                    {{ t('login_no_account') }}
                    <a :href="route('register')" class="text-primary font-weight-bold text-decoration-none ms-1">{{ t('login_create') }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { useLocale } from '../../composables/useLocale';

defineOptions({ layout: null });

const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { t } = useLocale();

const form = useForm({ email: '', password: '' });
const loading = ref(false);
const showPassword = ref(false);
const errorMessage = ref(null);

const features = computed(() => [
    { icon: 'mdi-truck-fast-outline',   text: t('login_feature_shipping') },
    { icon: 'mdi-shield-check-outline', text: t('login_feature_payment') },
    { icon: 'mdi-refresh',              text: t('login_feature_returns') },
]);

const submit = () => {
    loading.value = true;
    errorMessage.value = null;
    form.post('/login', {
        onFinish: () => (loading.value = false),
        onError: (errors) => {
            errorMessage.value = errors.email || errors.password || t('error_occurred');
        },
    });
};
</script>

<style scoped>
.auth-page {
    display: flex;
    min-height: 100vh;
    direction: rtl;
}

.auth-left {
    width: 42%;
    background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    position: relative;
    overflow: hidden;
}

.auth-left::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -80px;
    right: -80px;
}

.auth-left::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    bottom: -60px;
    left: -60px;
}

.auth-left-content {
    position: relative;
    z-index: 1;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 14px;
}

.auth-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 32px;
}

.auth-form-wrapper {
    width: 100%;
    max-width: 400px;
}

.field-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
</style>
