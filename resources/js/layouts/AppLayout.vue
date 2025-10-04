<template>
  <v-app>
    <v-layout class="d-flex flex-column min-h-screen position-relative">

      <!-- مكونات ثابتة -->
      <CartDrawer />
      <AppHeader />

      <!-- المحتوى الرئيسي -->
      <v-main class="flex-grow-1 py-15" style="overflow-y: auto;">
        <slot></slot>
      </v-main>

      <!-- الفوتر -->
      <AppFooter />

    </v-layout>
  </v-app>
</template>

<script setup>
import AppHeader from "../components/layout/AppHeader.vue";
import AppFooter from "../components/layout/AppFooter.vue";
import CartDrawer from "../components/layout/CartDrawer.vue";
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}
</style>
