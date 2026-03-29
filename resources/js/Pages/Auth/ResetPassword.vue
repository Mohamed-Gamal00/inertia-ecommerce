<template>
    <div class="auth-page">
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <v-icon size="56" color="white" class="mb-4">mdi-storefront</v-icon>
                <h1 class="text-white font-weight-bold mb-3" style="font-size:32px">متجري</h1>
                <p class="text-white" style="opacity:0.85; font-size:15px; max-width:280px; line-height:1.8">
                    أنشئ كلمة مرور جديدة قوية لحماية حسابك.
                </p>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="d-flex d-md-none align-center mb-6">
                    <v-icon size="32" color="primary" class="me-2">mdi-storefront</v-icon>
                    <span class="font-weight-bold text-h6">متجري</span>
                </div>

                <h2 class="font-weight-bold mb-1" style="font-size:26px">إعادة تعيين كلمة المرور</h2>
                <p class="text-grey-darken-1 mb-6" style="font-size:14px">أدخل كلمة المرور الجديدة</p>

                <v-alert v-if="success" type="success" variant="tonal" rounded="lg" class="mb-5" density="compact">
                    {{ success }}
                </v-alert>
                <v-alert v-if="error" type="error" variant="tonal" rounded="lg" class="mb-5" density="compact">
                    {{ error }}
                </v-alert>

                <v-form @submit.prevent="submit">
                    <label class="field-label">كلمة المرور الجديدة</label>
                    <v-text-field
                        v-model="form.password"
                        placeholder="••••••••"
                        :type="showPass ? 'text' : 'password'"
                        variant="outlined"
                        density="comfortable"
                        hide-details="auto"
                        class="mb-4 mt-1"
                        prepend-inner-icon="mdi-lock-outline"
                        :append-inner-icon="showPass ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append-inner="showPass = !showPass"
                        rounded="lg"
                        bg-color="grey-lighten-5"
                        :error-messages="form.errors.password"
                    />

                    <label class="field-label">تأكيد كلمة المرور</label>
                    <v-text-field
                        v-model="form.password_confirmation"
                        placeholder="••••••••"
                        :type="showPass2 ? 'text' : 'password'"
                        variant="outlined"
                        density="comfortable"
                        hide-details="auto"
                        class="mb-5 mt-1"
                        prepend-inner-icon="mdi-lock-check-outline"
                        :append-inner-icon="showPass2 ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append-inner="showPass2 = !showPass2"
                        rounded="lg"
                        bg-color="grey-lighten-5"
                    />

                    <v-btn
                        type="submit"
                        color="primary"
                        block
                        height="48"
                        rounded="lg"
                        :loading="form.processing"
                        style="font-size:15px; font-weight:600; text-transform:none"
                    >
                        تحديث كلمة المرور
                    </v-btn>
                </v-form>

                <div class="text-center mt-5" style="font-size:14px">
                    <a href="/login" class="text-primary font-weight-bold text-decoration-none">العودة لتسجيل الدخول</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineOptions({ layout: null });

const form  = useForm({ password: '', password_confirmation: '' });
const showPass  = ref(false);
const showPass2 = ref(false);
const page = usePage();
const success = computed(() => page.props.flash?.success);
const error   = computed(() => page.props.flash?.error);

const submit = () => form.post('/update-password');
</script>

<style scoped>
.auth-page { display:flex; min-height:100vh; direction:rtl; }
.auth-left { width:42%; background:linear-gradient(135deg,#1a237e 0%,#283593 50%,#3949ab 100%); display:flex; align-items:center; justify-content:center; padding:48px; position:relative; overflow:hidden; }
.auth-left::before { content:''; position:absolute; width:300px; height:300px; border-radius:50%; background:rgba(255,255,255,0.05); top:-80px; right:-80px; }
.auth-left-content { position:relative; z-index:1; }
.auth-right { flex:1; display:flex; align-items:center; justify-content:center; background:#ffffff; padding:32px; }
.auth-form-wrapper { width:100%; max-width:400px; }
.field-label { font-size:13px; font-weight:600; color:#374151; }
</style>
