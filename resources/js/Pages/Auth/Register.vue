<template>
    <div class="auth-page">
        <!-- Left panel: branding -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <v-icon size="56" color="white" class="mb-4">mdi-storefront</v-icon>
                <h1 class="text-white font-weight-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white mb-8" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
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

        <!-- Right panel: form -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <!-- Mobile logo -->
                <div class="d-flex d-md-none align-center mb-6">
                    <v-icon size="32" color="primary" class="me-2">mdi-storefront</v-icon>
                    <span class="font-weight-bold text-h6">{{ siteName }}</span>
                </div>

                <h2 class="font-weight-bold mb-1" style="font-size:26px">{{ t('register_title') }}</h2>
                <p class="text-grey-darken-1 mb-6" style="font-size:14px">{{ t('register_subtitle') }}</p>

                <v-form @submit.prevent="submit">
                    <v-row dense>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('first_name') }}</label>
                            <v-text-field v-model="form.first_name" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.first_name" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('last_name') }}</label>
                            <v-text-field v-model="form.family_name" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.family_name" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('phone') }}</label>
                            <v-text-field v-model="form.phone_number" placeholder="05xxxxxxxx" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" prepend-inner-icon="mdi-phone-outline" dir="ltr" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.phone_number" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('email') }}</label>
                            <v-text-field v-model="form.email" placeholder="example@email.com" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" prepend-inner-icon="mdi-email-outline" dir="ltr" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.email" />
                        </v-col>
                        <v-col cols="12">
                            <label class="field-label">{{ t('address') }}</label>
                            <v-text-field v-model="form.address" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" prepend-inner-icon="mdi-map-marker-outline" rounded="lg" bg-color="grey-lighten-5" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('country') }}</label>
                            <v-select v-model="form.country_id" :items="countries" item-title="name_ar" item-value="id" :placeholder="t('select_country')" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.country_id" @update:model-value="form.city_id = ''" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('city') }}</label>
                            <v-select v-model="form.city_id" :items="filteredCities" item-title="name_ar" item-value="id" :placeholder="t('select_city')" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.city_id" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('login_password') }}</label>
                            <v-text-field v-model="form.password" placeholder="••••••••" :type="showPass ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showPass ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPass = !showPass" rounded="lg" bg-color="grey-lighten-5" :error-messages="form.errors.password" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">{{ t('reset_confirm_password') }}</label>
                            <v-text-field v-model="form.password_confirmation" placeholder="••••••••" :type="showPass2 ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-check-outline" :append-inner-icon="showPass2 ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPass2 = !showPass2" rounded="lg" bg-color="grey-lighten-5" />
                        </v-col>
                    </v-row>

                    <v-btn type="submit" color="primary" block height="48" rounded="lg" :loading="loading" class="mt-2" style="font-size:15px; font-weight:600; text-transform:none">
                        {{ t('register_btn') }}
                    </v-btn>
                </v-form>

                <v-divider class="my-5"><span class="text-grey" style="font-size:13px">{{ t('login_or') }}</span></v-divider>
                <div class="text-center" style="font-size:14px">
                    {{ t('register_have_account') }}
                    <a href="/login" class="text-primary font-weight-bold text-decoration-none ms-1">{{ t('login_btn') }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';

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
    background: rgba(255,255,255,0.2);
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
}
</style>
