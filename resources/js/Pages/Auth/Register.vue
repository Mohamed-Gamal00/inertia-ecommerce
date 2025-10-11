<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

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
  country_id: "",
  city_id: "",
});

const loading = ref(false);

const submit = () => {
  loading.value = true;
  form.post(route("auth.register"), {
    onFinish: () => (loading.value = false),
  });
};
</script>

<template>
  <div class="d-flex align-center justify-center" style="min-height: 100vh; background-color: #f7f7f7">
    <v-card class="pa-6" max-width="600" elevation="4" rounded="xl">
      <v-card-title class="text-h5 font-weight-bold text-center mb-4">
        إنشاء حساب جديد
      </v-card-title>

      <v-form @submit.prevent="submit">
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field v-model="form.first_name" label="الاسم الأول" outlined dense />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="form.family_name" label="اسم العائلة" outlined dense />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="form.phone_number" label="رقم الهاتف" outlined dense />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="form.email" label="البريد الإلكتروني" outlined dense />
          </v-col>

          <v-col cols="12">
            <v-text-field v-model="form.address" label="العنوان" outlined dense />
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="form.country_id"
              :items="props.countries"
              item-title="name"
              item-value="id"
              label="الدولة"
              outlined dense
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="form.city_id"
              :items="props.cities.filter(c => c.country_id === form.country_id)"
              item-title="name"
              item-value="id"
              label="المدينة"
              outlined dense
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="form.password" type="password" label="كلمة المرور" outlined dense />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="form.password_confirmation" type="password" label="تأكيد كلمة المرور" outlined dense />
          </v-col>

          <v-col cols="12" class="text-center mt-4">
            <v-btn type="submit" color="primary" block size="large" class="rounded-pill" :loading="loading">
              تسجيل الحساب
            </v-btn>
          </v-col>

          <v-col cols="12" class="text-center mt-2">
            <p>
              لديك حساب بالفعل؟
              <a :href="route('auth.login')" class="text-primary text-decoration-none">
                تسجيل الدخول
              </a>
            </p>
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </div>
</template>
