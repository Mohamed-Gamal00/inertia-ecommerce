<template>
    <div class="auth-page">
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <i class="bi bi-shop text-white mb-4" style="font-size: 56px;"></i>
                <h1 class="text-white fw-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    {{ t('forgot_tagline') }}
                </p>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="d-flex d-md-none align-items-center mb-4">
                    <i class="bi bi-shop text-primary me-2" style="font-size: 32px;"></i>
                    <span class="fw-bold fs-5">{{ siteName }}</span>
                </div>

                <h2 class="fw-bold mb-1" style="font-size:26px">{{ t('forgot_title') }}</h2>
                <p class="text-secondary mb-4" style="font-size:14px">{{ t('forgot_subtitle') }}</p>

                <BAlert v-if="success" variant="success" class="mb-4">
                    {{ success }}
                </BAlert>
                <BAlert v-if="error" variant="danger" class="mb-4">
                    {{ error }}
                </BAlert>

                <form @submit.prevent="submit">
                    <label class="field-label">{{ t('forgot_phone') }}</label>
                    <BInput
                        v-model="form.phone_number"
                        placeholder="05xxxxxxxx"
                        class="mb-4 mt-1"
                        dir="ltr"
                        :error="form.errors.phone_number"
                    >
                        <template #prepend>
                            <i class="bi bi-telephone"></i>
                        </template>
                    </BInput>

                    <BButton
                        type="submit"
                        variant="primary"
                        size="lg"
                        block
                        :loading="form.processing"
                        class="fw-semibold"
                        style="text-transform:none; height: 48px"
                    >
                        {{ t('forgot_send') }}
                    </BButton>
                </form>

                <div class="divider my-4">
                    <span class="divider-text text-secondary">{{ t('login_or') }}</span>
                </div>

                <div class="text-center" style="font-size:14px">
                    {{ t('forgot_remember') }}
                    <a href="/login" class="text-primary fw-bold text-decoration-none ms-1">
                        {{ t('login_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
import { BInput, BButton, BAlert } from '../../components/bootstrap';

defineOptions({ layout: null });

const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { t } = useLocale();
const form = useForm({ phone_number: '' });
const page = usePage();
const success = computed(() => page.props.flash?.success);
const error = computed(() => page.props.flash?.error);

const submit = () => form.post('/forgot-password');
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
    background: rgba(255, 255, 255, 0.05);
    top: -80px;
    right: -80px;
}

.auth-left-content {
    position: relative;
    z-index: 1;
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

@media (max-width: 767.98px) {
    .auth-page {
        flex-direction: column;
    }

    .auth-right {
        padding: 24px 16px;
    }
}
</style>
