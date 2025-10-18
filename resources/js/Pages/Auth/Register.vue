<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import BaseInput from "../../components/Shared/BaseInput.vue";

const props = defineProps({
    countries: Array,
    cities: Array,
});

const form = useForm({
    first_name: "",
    family_name: "",
    phone_number: "",
    email: "",
    password: "",
    password_confirmation: "",
    address: "",
    city_id: "",
});

const loading = ref(false);

const submit = () => {
    loading.value = true;
    form.post(route("auth.register"), {
        preserveState: true,
        onFinish: () => (loading.value = false),
    });
};


</script>

<template>
    <div
        class="d-flex align-center justify-center"
        style="min-height: 100vh; background-color: #f7f7f7"
    >
        <v-card class="pa-6" max-width="600" elevation="4" rounded="xl">
            <v-card-title class="text-h5 font-weight-bold text-center mb-4">
                إنشاء حساب جديد
            </v-card-title>

            <v-form @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.first_name"
                            label="الاسم الأول"
                            :error="form.errors.first_name"
                        />
                    </v-col>

                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.family_name"
                            label="اسم العائلة"
                            :error="form.errors.family_name"
                        />
                    </v-col>

                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.phone_number"
                            label="رقم الهاتف"
                            type="number"
                            :error="form.errors.phone_number"
                        />
                    </v-col>

                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.email"
                            label="البريد الإلكتروني"
                            type="email"
                            :error="form.errors.email"
                        />
                    </v-col>

                    <v-col cols="12">
                        <BaseInput v-model="form.address" label="العنوان" />
                    </v-col>
                    <v-col cols="12" md="12">
                        <BaseInput
                            v-model="form.city_id"
                            label="المدينة"
                            type="select"
                            :items="props.cities"
                            item-title="name"
                            item-value="id"
                            :error="form.errors.city_id"
                        />
                    </v-col>

                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.password"
                            label="كلمة المرور"
                            type="password"
                            :error="form.errors.password"
                        />
                    </v-col>

                    <v-col cols="12" md="6">
                        <BaseInput
                            v-model="form.password_confirmation"
                            label="تأكيد كلمة المرور"
                            type="password"
                        />
                    </v-col>

                    <v-col cols="12" class="text-center mt-4">
                        <v-btn
                            type="submit"
                            color="primary"
                            block
                            size="large"
                            class="rounded-pill"
                            :loading="loading"
                        >
                            تسجيل الحساب
                        </v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>
    </div>
</template>
