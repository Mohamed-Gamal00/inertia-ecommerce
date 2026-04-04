<template>
    <div class="auth-page">
        <!-- Left panel: branding -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <v-icon size="56" color="white" class="mb-4">mdi-storefront</v-icon>
                <h1 class="text-white font-weight-bold mb-3" style="font-size:32px">{{ siteName }}</h1>
                <p class="text-white mb-8" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    انضم إلى آلاف العملاء واستمتع بتجربة تسوق لا مثيل لها.
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

                <h2 class="font-weight-bold mb-1" style="font-size:26px">إنشاء حساب جديد</h2>
                <p class="text-grey-darken-1 mb-6" style="font-size:14px">أنشئ حسابك وابدأ التسوق الآن</p>

                <v-form @submit.prevent="submit">
                    <v-row dense>
                        <v-col cols="12" md="6">
                            <label class="field-label">الاسم الأول</label>
                            <v-text-field
                                v-model="form.first_name"
                                placeholder="محمد"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.first_name"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">اسم العائلة</label>
                            <v-text-field
                                v-model="form.family_name"
                                placeholder="أحمد"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.family_name"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">رقم الهاتف</label>
                            <v-text-field
                                v-model="form.phone_number"
                                placeholder="05xxxxxxxx"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                prepend-inner-icon="mdi-phone-outline"
                                dir="ltr"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.phone_number"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">البريد الإلكتروني</label>
                            <v-text-field
                                v-model="form.email"
                                placeholder="example@email.com"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                prepend-inner-icon="mdi-email-outline"
                                dir="ltr"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <label class="field-label">العنوان</label>
                            <v-text-field
                                v-model="form.address"
                                placeholder="الرياض، حي النزهة"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                prepend-inner-icon="mdi-map-marker-outline"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">الدولة</label>
                            <v-select
                                v-model="form.country_id"
                                :items="countries"
                                item-title="name_ar"
                                item-value="id"
                                placeholder="اختر الدولة"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.country_id"
                                @update:model-value="form.city_id = ''"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">المدينة</label>
                            <v-select
                                v-model="form.city_id"
                                :items="filteredCities"
                                item-title="name_ar"
                                item-value="id"
                                placeholder="اختر المدينة"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.city_id"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">كلمة المرور</label>
                            <v-text-field
                                v-model="form.password"
                                placeholder="••••••••"
                                :type="showPass ? 'text' : 'password'"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                prepend-inner-icon="mdi-lock-outline"
                                :append-inner-icon="showPass ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="showPass = !showPass"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                                :error-messages="form.errors.password"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">تأكيد كلمة المرور</label>
                            <v-text-field
                                v-model="form.password_confirmation"
                                placeholder="••••••••"
                                :type="showPass2 ? 'text' : 'password'"
                                variant="outlined"
                                density="comfortable"
                                hide-details="auto"
                                class="mt-1 mb-3"
                                prepend-inner-icon="mdi-lock-check-outline"
                                :append-inner-icon="showPass2 ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="showPass2 = !showPass2"
                                rounded="lg"
                                bg-color="grey-lighten-5"
                            />
                        </v-col>
                    </v-row>

                    <v-btn
                        type="submit"
                        color="primary"
                        block
                        height="48"
                        rounded="lg"
                        :loading="loading"
                        class="mt-2"
                        style="font-size:15px; font-weight:600; text-transform:none"
                    >
                        إنشاء الحساب
                    </v-btn>
                </v-form>

                <v-divider class="my-5">
                    <span class="text-grey" style="font-size:13px">أو</span>
                </v-divider>

                <div class="text-center" style="font-size:14px">
                    لديك حساب بالفعل؟
                    <a href="/login" class="text-primary font-weight-bold text-decoration-none ms-1">
                        تسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineOptions({ layout: null });

const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');

const props = defineProps({
    countries: Array,
    cities: Array,
});

const form = useForm({
    first_name: '',
    family_name: '',
    phone_number: '',
    email: '',
    password: '',
    password_confirmation: '',
    address: '',
    country_id: '',
    city_id: '',
});

const loading = ref(false);
const showPass = ref(false);
const showPass2 = ref(false);

const steps = [
    'أنشئ حسابك في دقيقة واحدة',
    'تصفح آلاف المنتجات',
    'استلم طلبك بأمان',
];

const filteredCities = computed(() =>
    form.country_id
        ? props.cities.filter(c => c.country_id === form.country_id)
        : props.cities
);

const submit = () => {
    loading.value = true;
    form.post('/register', {
        preserveState: true,
        onFinish: () => (loading.value = false),
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
