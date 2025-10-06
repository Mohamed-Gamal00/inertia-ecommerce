<template>
  <div>
    <div class="layout">
      <v-layout class="position-relative">
        <CartDrawer />
        <v-main style="padding-top: 160px">
          <slot></slot>
        </v-main>
        <AppHeader />
        <FixedNav />
        <AppFooter />
      </v-layout>
    </div>
  </div>
</template>

<script>
import AppHeader from "./AppHeader.vue";
import AppFooter from "./AppFooter.vue";
import CartDrawer from "./CartDrawer.vue";
import FixedNav from "./FixedNav.vue";
export default {
  components: {
    AppHeader,
    AppFooter,
    CartDrawer,
    FixedNav,
  },
  data() {
    return {
      drawer: false,
    };
  },
};
</script>

<style lang="scss" scoped></style>
