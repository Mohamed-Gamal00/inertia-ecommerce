<template>
  <v-app>      <!-- مكونات ثابتة -->
      <CartDrawer />
      <AppHeader />

      <!-- المحتوى الرئيسي -->
      <v-main >
        <v-container>
            <slot></slot>
        </v-container>
      </v-main>

      <!-- الفوتر -->
      <AppFooter />

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
