<script setup>
import { ref, inject, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";

const Emitter = inject("Emitter");
const drawer = ref(false);
const search = ref("");
const cartCount = ref(0);

const menu = [
  { title: "الرئيسية", href: "/" },
  { title: "المنتجات", href: "/products" },
  { title: "الفئات", href: "/categories" },
  { title: "العروض", href: "/offers" },
];

function openCart() {
  Emitter.emit("openCart"); // 🔔 هيفتح الكارت
}

function updateCart(count) {
  cartCount.value = count;
}

onMounted(() => {
  Emitter.on("cart-updated", updateCart);
});

onBeforeUnmount(() => {
  Emitter.off("cart-updated", updateCart);
});
</script>

<template>
  <v-app-bar color="primary" dark>
    <v-container fluid class="d-flex align-center justify-content-between">
        <!-- Logo -->
        <v-app-bar-nav-icon class="d-md-none" @click="drawer = !drawer" />
        <Link href="/" class="d-flex align-center text-white no-underline">
          <v-icon class="mr-2">mdi-storefront</v-icon>
          <span class="font-bold text-lg">متجري</span>
        </Link>

        <!-- Desktop Menu -->
        <v-spacer />
        <div class="d-none d-md-flex">
          <Link
            v-for="item in menu"
            :key="item.href"
            :href="item.href"
            class="mx-3 text-white no-underline"
          >
            {{ item.title }}
          </Link>
        </div>

        <!-- Search -->
        <v-text-field
          v-model="search"
          placeholder="ابحث عن المنتجات..."
          hide-details
          single-line
          prepend-inner-icon="mdi-magnify"
          class="mx-4 d-none d-md-flex"
        />

        <!-- Actions -->
        <v-badge :style="`cursor: pointer;pointer-events: `" @click="openCart" :content="cartCount" color="red" overlap>
          <v-icon>mdi-cart</v-icon>
        </v-badge>


        <Link href="/account" class="text-white mx-2">
          <v-icon>mdi-account</v-icon>
        </Link>

    </v-container>
  </v-app-bar>

<!-- Drawer (Responsive Menu) -->
    <v-navigation-drawer v-model="drawer" app temporary location="right">
    <v-list>
        <v-list-item
        v-for="item in menu"
        :key="item.href"
        @click="drawer = false"
        >
        <Link
            :href="item.href"
            class="w-full block py-2 px-4 text-black no-underline"
        >
            {{ item.title }}
        </Link>
        </v-list-item>
    </v-list>
    </v-navigation-drawer>

</template>
