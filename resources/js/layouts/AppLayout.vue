<template>
  <v-app>
      <CartDrawer />
      <AppHeader />
      <QuickView />

      <!-- المحتوى الرئيسي -->
      <v-main class="pa-0">
        <v-container fluid>
            <slot></slot>
        </v-container>
      </v-main>

      <!-- الفوتر -->
      <AppFooter />

  </v-app>
</template>

<script setup>
import AppHeader from "../layouts/AppHeader.vue";
import AppFooter from "../layouts/AppFooter.vue";
import QuickView from "../components/Shared/QuickView.vue";
import CartDrawer from "../components/Shared/CartDrawer.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const user = computed(() => usePage().props.auth.user);
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}
</style>
