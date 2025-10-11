<script setup>
import { reactive, ref } from "vue";
import { useForm, router ,usePage } from "@inertiajs/vue3";
import { VTextField, VBtn, VCard, VCardTitle, VCardText, VAlert } from "vuetify/components";

const form = useForm({
    email: "",
    password: "",
});

const loading = ref(false);
const errorMessage = ref(null);

const submit = () => {
    loading.value = true;
    errorMessage.value = null;

    form.post("/auth/login", {
        onFinish: () => (loading.value = false),
        onError: (errors) => {
            if (errors.email) {
                errorMessage.value = errors.email;
            } else if (errors.password) {
                errorMessage.value = errors.password;
            } else {
                errorMessage.value = "حدث خطأ أثناء تسجيل الدخول، حاول مرة أخرى.";
            }
        },
    });
};
</script>

<template>
  <div class="d-flex align-center justify-center" style="min-height: 100vh; background-color: #f7f7f7">
    <v-card class="pa-6" max-width="420" elevation="4" rounded="xl">
      <v-card-title class="text-h5 font-weight-bold text-center mb-4">
        تسجيل الدخول
      </v-card-title>

      <v-card-text>
        <div>{{ usePage().props.errors }}</div>
        <v-alert
          v-if="errorMessage"
          type="error"
          class="mb-4"
          border="start"
          elevation="2"
          density="comfortable"
        >
          {{ errorMessage }}
        </v-alert>

        <v-form @submit.prevent="submit">
          <v-text-field
            v-model="form.email"
            label="البريد الإلكتروني"
            variant="outlined"
            density="comfortable"
            hide-details="auto"
            class="mb-4"
            prepend-inner-icon="mdi-phone"
            dir="ltr"
          ></v-text-field>

          <v-text-field
            v-model="form.password"
            label="كلمة المرور"
            type="password"
            variant="outlined"
            density="comfortable"
            hide-details="auto"
            prepend-inner-icon="mdi-lock"
            class="mb-6"
          ></v-text-field>

          <v-btn
            type="submit"
            color="primary"
            block
            size="large"
            class="rounded-pill"
            :loading="loading"
            :disabled="loading"
          >
            تسجيل الدخول
          </v-btn>

          <div class="text-center mt-5">
            <p>
              ليس لديك حساب؟
              <a :href="route('auth.register')" class="text-primary text-decoration-none">
                إنشاء حساب جديد
              </a>
            </p>
            <p class="mt-2">
              <a :href="route('auth.forgot')" class="text-primary text-decoration-none">
                هل نسيت كلمة المرور؟
              </a>
            </p>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>
