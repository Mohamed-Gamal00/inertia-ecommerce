<template>
    <div class="auth-page">
        <!-- Left panel -->
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <v-icon size="56" color="white" class="mb-4">mdi-storefront</v-icon>
                <h1 class="text-white font-weight-bold mb-3" style="font-size:32px">متجري</h1>
                <p class="text-white mb-8" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    {{ registerType === 'vendor' ? 'انضم كبائع وابدأ بيع منتجاتك لآلاف العملاء.' : 'انضم إلى آلاف العملاء واستمتع بتجربة تسوق لا مثيل لها.' }}
                </p>
                <div class="steps">
                    <div class="step-item" v-for="(s, i) in currentSteps" :key="i">
                        <div class="step-num">{{ i + 1 }}</div>
                        <span class="text-white" style="font-size:14px">{{ s }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="d-flex d-md-none align-center mb-6">
                    <v-icon size="32" color="primary" class="me-2">mdi-storefront</v-icon>
                    <span class="font-weight-bold text-h6">متجري</span>
                </div>

                <h2 class="font-weight-bold mb-1" style="font-size:26px">إنشاء حساب جديد</h2>
                <p class="text-grey-darken-1 mb-4" style="font-size:14px">اختر نوع الحساب</p>

                <!-- Account type toggle -->
                <div class="type-toggle mb-6">
                    <button
                        class="type-btn"
                        :class="{ 'type-btn--active': registerType === 'user' }"
                        @click="registerType = 'user'"
                        type="button"
                    >
                        <v-icon size="20" class="me-2">mdi-account-outline</v-icon>
                        عميل
                    </button>
                    <button
                        class="type-btn"
                        :class="{ 'type-btn--active': registerType === 'vendor' }"
                        @click="registerType = 'vendor'"
                        type="button"
                    >
                        <v-icon size="20" class="me-2">mdi-store-outline</v-icon>
                        بائع
                    </button>
                </div>

                <!-- Vendor pending notice -->
                <v-alert v-if="registerType === 'vendor'" type="info" variant="tonal" rounded="lg" class="mb-5" density="compact">
                    <v-icon size="16" class="me-1">mdi-information-outline</v-icon>
                    سيتم مراجعة طلبك من قِبل الإدارة قبل تفعيل حسابك
                </v-alert>

                <!-- ===== USER FORM ===== -->
                <v-form v-if="registerType === 'user'" @submit.prevent="submitUser">
                    <v-row dense>
                        <v-col cols="12" md="6">
                            <label class="field-label">الاسم الأول</label>
                            <v-text-field v-model="userForm.first_name" placeholder="محمد" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" :error-messages="userForm.errors.first_name" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">اسم العائلة</label>
                            <v-text-field v-model="userForm.family_name" placeholder="أحمد" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" :error-messages="userForm.errors.family_name" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">رقم الهاتف</label>
                            <v-text-field v-model="userForm.phone_number" placeholder="05xxxxxxxx" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-phone-outline" dir="ltr" :error-messages="userForm.errors.phone_number" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">البريد الإلكتروني</label>
                            <v-text-field v-model="userForm.email" placeholder="example@email.com" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-email-outline" dir="ltr" :error-messages="userForm.errors.email" />
                        </v-col>
                        <v-col cols="12">
                            <label class="field-label">العنوان</label>
                            <v-text-field v-model="userForm.address" placeholder="الرياض، حي النزهة" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-map-marker-outline" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">الدولة</label>
                            <v-select v-model="userForm.country_id" :items="countries" item-title="name_ar" item-value="id" placeholder="اختر الدولة" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" :error-messages="userForm.errors.country_id" @update:model-value="userForm.city_id = ''" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">المدينة</label>
                            <v-select v-model="userForm.city_id" :items="filteredCities" item-title="name_ar" item-value="id" placeholder="اختر المدينة" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" :error-messages="userForm.errors.city_id" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">كلمة المرور</label>
                            <v-text-field v-model="userForm.password" placeholder="••••••••" :type="showPass ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showPass ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPass = !showPass" :error-messages="userForm.errors.password" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">تأكيد كلمة المرور</label>
                            <v-text-field v-model="userForm.password_confirmation" placeholder="••••••••" :type="showPass2 ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-check-outline" :append-inner-icon="showPass2 ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPass2 = !showPass2" />
                        </v-col>
                    </v-row>
                    <v-btn type="submit" color="primary" block height="48" rounded="lg" :loading="userForm.processing" class="mt-2" style="font-size:15px; font-weight:600; text-transform:none">
                        إنشاء حساب عميل
                    </v-btn>
                </v-form>

                <!-- ===== VENDOR FORM ===== -->
                <v-form v-else @submit.prevent="submitVendor">
                    <v-row dense>
                        <v-col cols="12">
                            <label class="field-label">اسم المتجر / الشركة</label>
                            <v-text-field v-model="vendorForm.name" placeholder="متجر الإلكترونيات" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-store-outline" :error-messages="vendorErrors.name" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">البريد الإلكتروني</label>
                            <v-text-field v-model="vendorForm.email" placeholder="store@email.com" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-email-outline" dir="ltr" :error-messages="vendorErrors.email" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">رقم الهاتف</label>
                            <v-text-field v-model="vendorForm.phone" placeholder="05xxxxxxxx" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-phone-outline" dir="ltr" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">كلمة المرور</label>
                            <v-text-field v-model="vendorForm.password" placeholder="••••••••" :type="showVendorPass ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showVendorPass ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showVendorPass = !showVendorPass" :error-messages="vendorErrors.password" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <label class="field-label">تأكيد كلمة المرور</label>
                            <v-text-field v-model="vendorForm.password_confirmation" placeholder="••••••••" :type="showVendorPass2 ? 'text' : 'password'" variant="outlined" density="comfortable" hide-details="auto" rounded="lg" bg-color="grey-lighten-5" class="mt-1 mb-3" prepend-inner-icon="mdi-lock-check-outline" :append-inner-icon="showVendorPass2 ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showVendorPass2 = !showVendorPass2" />
                        </v-col>
                    </v-row>

                    <div v-if="vendorErrors.general" class="text-red text-caption mb-3">{{ vendorErrors.general }}</div>

                    <v-btn type="submit" color="primary" block height="48" rounded="lg" :loading="vendorSubmitting" class="mt-2" style="font-size:15px; font-weight:600; text-transform:none">
                        إرسال طلب التسجيل كبائع
                    </v-btn>
                </v-form>

                <v-divider class="my-5">
                    <span class="text-grey" style="font-size:13px">أو</span>
                </v-divider>

                <div class="text-center" style="font-size:14px">
                    لديك حساب بالفعل؟
                    <a href="/login" class="text-primary font-weight-bold text-decoration-none ms-1">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor success dialog -->
    <v-dialog v-model="vendorSuccess" max-width="420" persistent>
        <v-card rounded="xl" class="pa-6 text-center">
            <v-icon size="56" color="success" class="mb-3">mdi-check-circle-outline</v-icon>
            <h3 class="font-weight-bold mb-2">تم إرسال طلبك!</h3>
            <p class="text-grey-darken-1 mb-5" style="font-size:14px">
                سيتم مراجعة طلبك من قِبل الإدارة وسنتواصل معك عبر البريد الإلكتروني عند التفعيل.
            </p>
            <v-btn color="primary" block rounded="lg" style="text-transform:none" href="/login">
                العودة لتسجيل الدخول
            </v-btn>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

defineOptions({ layout: null });

const props = defineProps({ countries: Array, cities: Array });

const registerType = ref('user');
const showPass     = ref(false);
const showPass2    = ref(false);
const showVendorPass  = ref(false);
const showVendorPass2 = ref(false);
const vendorSubmitting = ref(false);
const vendorSuccess    = ref(false);
const vendorErrors     = ref({});

// User form (Inertia)
const userForm = useForm({
    first_name: '', family_name: '', phone_number: '',
    email: '', password: '', password_confirmation: '',
    address: '', country_id: '', city_id: '',
});

// Vendor form (axios)
const vendorForm = ref({
    name: '', email: '', phone: '',
    password: '', password_confirmation: '',
});

const filteredCities = computed(() =>
    userForm.country_id
        ? props.cities.filter(c => c.country_id == userForm.country_id)
        : props.cities
);

const userSteps = ['أنشئ حسابك في دقيقة', 'تصفح آلاف المنتجات', 'استلم طلبك بأمان'];
const vendorSteps = ['سجّل متجرك مجاناً', 'أضف منتجاتك', 'ابدأ البيع لآلاف العملاء'];
const currentSteps = computed(() => registerType.value === 'vendor' ? vendorSteps : userSteps);

function submitUser() {
    userForm.post('/register', { preserveState: true });
}

async function submitVendor() {
    vendorSubmitting.value = true;
    vendorErrors.value = {};
    try {
        await axios.post('/vendor/register', vendorForm.value);
        vendorSuccess.value = true;
    } catch (e) {
        if (e.response?.status === 422) {
            vendorErrors.value = e.response.data.errors || {};
        } else {
            vendorErrors.value = { general: e.response?.data?.message || 'حدث خطأ' };
        }
    } finally {
        vendorSubmitting.value = false;
    }
}
</script>

<style scoped>
.auth-page { display:flex; min-height:100vh; direction:rtl; }
.auth-left { width:38%; background:linear-gradient(135deg,#1a237e 0%,#283593 50%,#3949ab 100%); display:flex; align-items:center; justify-content:center; padding:48px; position:relative; overflow:hidden; }
.auth-left::before { content:''; position:absolute; width:300px; height:300px; border-radius:50%; background:rgba(255,255,255,0.05); top:-80px; right:-80px; }
.auth-left-content { position:relative; z-index:1; }
.steps .step-item { display:flex; align-items:center; margin-bottom:16px; gap:12px; }
.step-num { width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,0.2); color:white; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0; }
.auth-right { flex:1; display:flex; align-items:center; justify-content:center; background:#ffffff; padding:32px; overflow-y:auto; }
.auth-form-wrapper { width:100%; max-width:520px; padding:8px 0; }
.field-label { font-size:13px; font-weight:600; color:#374151; }

/* Type toggle */
.type-toggle { display:flex; background:#f3f4f6; border-radius:12px; padding:4px; gap:4px; }
.type-btn {
    flex:1; display:flex; align-items:center; justify-content:center;
    padding:10px 16px; border-radius:10px; border:none; background:transparent;
    font-size:14px; font-weight:600; color:#6b7280; cursor:pointer;
    transition:all 0.2s;
}
.type-btn--active { background:white; color:#1a237e; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
</style>
