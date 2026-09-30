<template>
    <div class="auth-page">
        <!-- Left panel -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <i class="bi bi-shop text-white mb-4" style="font-size: 56px;"></i>
                <h1 class="text-white fw-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white mb-5" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    {{ t('register_tagline') }}
                </p>
                <div class="steps">
                    <div class="step-item" v-for="(s, i) in steps" :key="i">
                        <div class="step-num">{{ i + 1 }}</div>
                        <span class="text-white" style="font-size:14px">{{ s }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="d-flex d-md-none align-items-center mb-4">
                    <i class="bi bi-shop text-primary me-2" style="font-size: 32px;"></i>
                    <span class="fw-bold fs-5">{{ siteName }}</span>
                </div>

                <h2 class="fw-bold mb-1" style="font-size:26px">{{ t('register_title') }}</h2>
                <p class="text-secondary mb-4" style="font-size:14px">{{ t('register_subtitle') }}</p>

                <form @submit.prevent="submit">
                    <Row>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('first_name') }}</label>
                            <BInput
                                v-model="form.first_name"
                                class="mt-1 mb-3"
                                :error="form.errors.first_name"
                            />
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('last_name') }}</label>
                            <BInput
                                v-model="form.family_name"
                                class="mt-1 mb-3"
                                :error="form.errors.family_name"
                            />
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('phone') }}</label>
                            <BInput
                                v-model="form.phone_number"
                                placeholder="05xxxxxxxx"
                                class="mt-1 mb-3"
                                dir="ltr"
                                :error="form.errors.phone_number"
                            >
                                <template #prepend>
                                    <i class="bi bi-telephone"></i>
                                </template>
                            </BInput>
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('email') }}</label>
                            <BInput
                                v-model="form.email"
                                type="email"
                                placeholder="example@email.com"
                                class="mt-1 mb-3"
                                dir="ltr"
                                :error="form.errors.email"
                            >
                                <template #prepend>
                                    <i class="bi bi-envelope"></i>
                                </template>
                            </BInput>
                        </Col>
                        <Col cols="12">
                            <label class="field-label">{{ t('address') }}</label>
                            <BInput
                                v-model="form.address"
                                class="mt-1 mb-3"
                            >
                                <template #prepend>
                                    <i class="bi bi-geo-alt"></i>
                                </template>
                            </BInput>
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('country') }}</label>
                            <BSelect
                                v-model="form.country_id"
                                :options="countries"
                                value-key="id"
                                label-key="name_ar"
                                :placeholder="t('select_country')"
                                class="mt-1 mb-3"
                                :error="form.errors.country_id"
                                @update:modelValue="form.city_id = ''"
                            />
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('city') }}</label>
                            <BSelect
                                v-model="form.city_id"
                                :options="filteredCities"
                                value-key="id"
                                label-key="name_ar"
                                :placeholder="t('select_city')"
                                class="mt-1 mb-3"
                                :error="form.errors.city_id"
                            />
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('login_password') }}</label>
                            <BInput
                                v-model="form.password"
                                :type="showPass ? 'text' : 'password'"
                                placeholder="••••••••"
                                class="mt-1 mb-3"
                                :error="form.errors.password"
                            >
                                <template #prepend>
                                    <i class="bi bi-lock"></i>
                                </template>
                                <template #append>
                                    <button
                                        type="button"
                                        class="btn btn-link p-0 text-secondary"
                                        @click="showPass = !showPass"
                                        tabindex="-1"
                                    >
                                        <i :class="`bi ${showPass ? 'bi-eye-slash' : 'bi-eye'}`"></i>
                                    </button>
                                </template>
                            </BInput>
                        </Col>
                        <Col cols="12" md="6">
                            <label class="field-label">{{ t('reset_confirm_password') }}</label>
                            <BInput
                                v-model="form.password_confirmation"
                                :type="showPass2 ? 'text' : 'password'"
                                placeholder="••••••••"
                                class="mt-1 mb-3"
                            >
                                <template #prepend>
                                    <i class="bi bi-lock-fill"></i>
                                </template>
                                <template #append>
                                    <button
                                        type="button"
                                        class="btn btn-link p-0 text-secondary"
                                        @click="showPass2 = !showPass2"
                                        tabindex="-1"
                                    >
                                        <i :class="`bi ${showPass2 ? 'bi-eye-slash' : 'bi-eye'}`"></i>
                                    </button>
                                </template>
                            </BInput>
                        </Col>
                    </Row>

                    <BButton
                        type="submit"
                        variant="primary"
                        size="lg"
                        block
                        :loading="loading"
                        class="mt-2 fw-semibold"
                        style="text-transform:none; height: 48px"
                    >
                        {{ t('register_btn') }}
                    </BButton>
                </form>

                <div class="divider my-4">
                    <span class="divider-text text-secondary">{{ t('login_or') }}</span>
                </div>

                <div class="text-center" style="font-size:14px">
                    {{ t('register_have_account') }}
                    <a href="/login" class="text-primary fw-bold text-decoration-none ms-1">
                        {{ t('login_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
import { BInput, BButton, BSelect, Row, Col } from '../../components/bootstrap';

defineOptions({ layout: null });

const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { t } = useLocale();

const props = defineProps({ countries: Array, cities: Array });

const form = useForm({
    first_name: '', family_name: '', phone_number: '', email: '',
    password: '', password_confirmation: '', address: '', country_id: '', city_id: '',
});

const loading = ref(false);
const showPass = ref(false);
const showPass2 = ref(false);

const steps = computed(() => [
    t('register_step1'), t('register_step2'), t('register_step3'),
]);

const filteredCities = computed(() =>
    form.country_id ? props.cities.filter(c => c.country_id === form.country_id) : props.cities
);

const submit = () => {
    loading.value = true;
    form.post('/register', { preserveState: true, onFinish: () => (loading.value = false) });
};
</script>

<style scoped>
.auth-page {
    display: flex;
    min-height: 100vh;
    direction: rtl;
}

.auth-left {
    width: 38%;
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

.steps .step-item {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
    gap: 12px;
}

.step-num {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

.auth-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 32px;
    overflow-y: auto;
}

.auth-form-wrapper {
    width: 100%;
    max-width: 520px;
    padding: 8px 0;
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
