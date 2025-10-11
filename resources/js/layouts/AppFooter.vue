<template>
<v-footer color="primary" dark class="pa-0">
  <v-container fluid >
    <v-row>
      <!-- Logo & About -->
      <v-col cols="12" md="4" class="mb-6 mb-md-0">
        <div class="d-flex align-center mb-3">
          <v-icon class="mr-2">mdi-storefront</v-icon>
          <span class="font-weight-bold text-h6">متجري</span>
        </div>
        <p class="text-body-2">
          أفضل متجر إلكتروني يقدم منتجات عالية الجودة مع عروض وخصومات مميزة. هدفنا هو رضاك وتقديم تجربة تسوق ممتعة.
        </p>
        <!-- Social Icons -->
        <div class="d-flex mt-3">
          <v-btn icon variant="text" class="mx-1"><v-icon size="20">mdi-facebook</v-icon></v-btn>
          <v-btn icon variant="text" class="mx-1"><v-icon size="20">mdi-twitter</v-icon></v-btn>
          <v-btn icon variant="text" class="mx-1"><v-icon size="20">mdi-instagram</v-icon></v-btn>
          <v-btn icon variant="text" class="mx-1"><v-icon size="20">mdi-youtube</v-icon></v-btn>
        </div>
      </v-col>

      <!-- Quick Links -->
      <v-col cols="6" md="2">
        <h4 class="text-h6 mb-3">روابط سريعة</h4>
        <ul class="list-none pa-0">
          <li><Link href="/" class="text-white text-body-2">الرئيسية</Link></li>
          <li><Link href="/products" class="text-white text-body-2">المنتجات</Link></li>
          <li><Link href="/categories" class="text-white text-body-2">الفئات</Link></li>
          <li><Link href="/offers" class="text-white text-body-2">العروض</Link></li>
        </ul>
      </v-col>

      <!-- Customer Service -->
      <v-col cols="6" md="2">
        <h4 class="text-h6 mb-3">خدمة العملاء</h4>
        <ul class="list-none pa-0">
          <li><Link href="/faq" class="text-white text-body-2">الأسئلة الشائعة</Link></li>
          <li><Link href="/contact" class="text-white text-body-2">اتصل بنا</Link></li>
          <li><Link href="/returns" class="text-white text-body-2">سياسة الاسترجاع</Link></li>
          <li><Link href="/privacy" class="text-white text-body-2">سياسة الخصوصية</Link></li>
        </ul>
      </v-col>

      <!-- Newsletter -->
      <v-col cols="12" md="4">
        <h4 class="text-h6 mb-3">اشترك في النشرة البريدية</h4>
        <p class="text-body-2">اشترك ليصلك أحدث العروض والخصومات.</p>
        <v-text-field
          v-model="email"
          placeholder="ادخل بريدك الإلكتروني"
          variant="outlined"
          density="comfortable"
          class="mt-3"
          hide-details
          append-inner-icon="mdi-email"
        ></v-text-field>
        <v-btn color="secondary" class="mt-2 w-100" @click="subscribe">
          اشترك الآن
        </v-btn>
      </v-col>
    </v-row>

    <v-divider class="my-6" light></v-divider>
    <v-row>
      <v-col cols="12" class="text-center py-3">
        <span class="text-body-2">
          © {{ new Date().getFullYear() }} متجري - جميع الحقوق محفوظة
        </span>
      </v-col>
    </v-row>
  </v-container>
</v-footer>

</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const email = ref("");

const subscribe = () => {
  if (email.value) {
    alert(`تم الاشتراك بالنشرة البريدية: ${email.value}`);
    email.value = "";
  } else {
    alert("من فضلك ادخل بريدك الإلكتروني");
  }
};
</script>

<style scoped>
.list-none {
  list-style: none;
}

a {
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
</style>
