<template>
  <v-app>
      <CartDrawer />
      <AppHeader />
      <QuickView />
      <BackToTop />
      <CompareBar />
      <ToastContainer />

      <v-main>
        <slot></slot>
      </v-main>

      <AppFooter />
  </v-app>
</template>

<script setup>
import AppHeader from "../layouts/AppHeader.vue";
import AppFooter from "../layouts/AppFooter.vue";
import QuickView from "../components/Shared/QuickView.vue";
import CartDrawer from "../components/Shared/CartDrawer.vue";
import BackToTop from "../components/Shared/BackToTop.vue";
import CompareBar from "../components/Shared/CompareBar.vue";
import ToastContainer from "../components/Shared/ToastContainer.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const user = computed(() => usePage().props.auth.user);
</script>

<style scoped>
.min-h-screen { min-height: 100vh; }
</style>

<style>
@keyframes cartBounce {
    0%   { transform: scale(1); }
    30%  { transform: scale(1.5) rotate(-15deg); }
    60%  { transform: scale(0.85) rotate(8deg); }
    80%  { transform: scale(1.15); }
    100% { transform: scale(1); }
}
.cart-bounce { animation: cartBounce 0.6s ease !important; }

@keyframes cartMagic {
    0%   { transform: scale(1) rotate(0deg); }
    20%  { transform: scale(1.4) rotate(-12deg); }
    40%  { transform: scale(0.9) rotate(8deg); }
    60%  { transform: scale(1.2) rotate(-4deg); }
    80%  { transform: scale(0.95); }
    100% { transform: scale(1) rotate(0deg); }
}
@keyframes ringExpand {
    0%   { transform: scale(0.5); opacity: 1; }
    100% { transform: scale(2.5); opacity: 0; }
}
@keyframes floatUp {
    0%   { transform: translateY(0) scale(1); opacity: 1; }
    60%  { transform: translateY(-28px) scale(1.1); opacity: 1; }
    100% { transform: translateY(-44px) scale(0.8); opacity: 0; }
}
.cart-magic { animation: cartMagic 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97) !important; }
</style>
