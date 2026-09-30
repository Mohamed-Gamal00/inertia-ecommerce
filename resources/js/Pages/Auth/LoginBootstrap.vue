<template>
    <div class="auth-page">
        <!-- Left panel: branding -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <i class="bi bi-shop text-white mb-4" style="font-size: 56px;"></i>
                <h1 class="text-white fw-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    {{ t('login_tagline') }}
                </p>
                <div class="auth-features mt-4">
                    <div class="feature-item" v-for="f in features" :key="f.text">
                        <i :class="`bi ${f.icon} text-white me-2`" style="font-size: 20px;"></i>
                        <span class="text-white" style="font-size:14px">{{ f.text }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel: form -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <!-- Mobile logo -->
                <div class="d-flex d-md-none align-items-center mb-4">
                    <i class="bi bi-shop text-primary me-2" style="font-size: 32px;"></i>
                    <span class="fw-bold fs-5">{{ siteName }}</span>
                </div>

                <h2 class="fw-bold mb-1" style="font-size:26px">{{ t('login_welcome') }}</h2>
                <p class="text-secondary mb-4" style="font-size:14px">{{ t('login_subtitle') }}</p>

                <BAlert v-if="errorMessage" variant="danger" class="mb-4">
                    {{ errorMessage }}
                </BAlert>

                <form @submit.prevent="submit">
                    <label class="field-label">{{ t('login_email') }}</label>
                    <BInput
                        v-model="form.email"
                        type="email"
                        placeholder="example@email.com"
                        class="mb-3 mt-1"
                        dir="ltr"
                    >
                        <template #prepend>
                            <i class="bi bi-envelope"></i>
                        </template>
                    </BInput>

                    <label class="field-label">{{ t('login_password') }}</label>
                    <BInput
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        placeholder="••••••••"
                        class="mb-2 mt-1"
                    >
                        <template #prepend>
                            <i class="bi bi-lock"></i>
                        </template>
                        <template #append>
                            <button
                                type="button"
                                class="btn btn-link p-0 text-secondary"
                                @click="showPassword = !showPassword"
                                tabindex="-1"
                            >
                                <i :class="`bi ${showPassword ? 'bi-eye-slash' : 'bi-eye'}`"></i>
                            </button>
                        </template>
                    </BInput>

                    <div class="d-flex justify-content-end mb-4">
                        <a :href="route('forgot')" class="text-primary text-decoration-none" style="font-size:13px">
                            {{ t('login_forgot') }}
                        </a>
                    </div>

                    <BButton
                        type="submit"
                        variant="primary"
                        size="lg"
                        block
                        :loading="loading"
                        class="fw-semibold"
                        style="text-transform:none; height: 48px"
                    >
                        {{ t('login_btn') }}
                    </BButton>
                </form>

                <div class="divider my-4">
                    <span class="divider-text text-secondary">{{ t('login_or') }}</span>
                </div>

                <div class="text-center" style="font-size:14px">
                    {{ t('login_no_account') }}
                    <a :href="route('register')" class="text-primary fw-bold text-decoration-none ms-1">
                        {{ t('login_create') }}
                    </a>
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
import { BInput, BButton, BAlert } from '../../components/bootstrap';

defineOptions({ layout: null });

const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { t } = useLocale();

const form = useForm({ email: '', password: '' });
const loading = ref(false);
const showPassword = ref(false);
const errorMessage = ref(null);

const features = computed(() => [
    { icon: 'bi-truck',         text: t('login_feature_shipping') },
    { icon: 'bi-shield-check',  text: t('login_feature_payment') },
    { icon: 'bi-arrow-repeat',  text: t('login_feature_returns') },
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
    display: block;
}

.divider {
    position: relative;
    text-align: center;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #dee2e6;
}

.divider-text {
    position: relative;
    display: inline-block;
    padding: 0 12px;
    background: #ffffff;
    font-size: 13px;
}

/* Responsive */
@media (max-width: 767.98px) {
    .auth-page {
        flex-direction: column;
    }

    .auth-right {
        padding: 24px 16px;
    }
}
</style>
