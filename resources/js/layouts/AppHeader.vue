<script setup>
import { ref, inject, onMounted, onBeforeUnmount, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const Emitter = inject("Emitter");
const drawer = ref(false);
const search = ref("");
const cartCount = ref(0);

const { props } = usePage();
const categories = props.categories ?? [];
const user = computed(()=>usePage().props.auth.user) // ✅ المستخدم الحالي
console.log(user);
const menu = [
  { title: "الرئيسية", href: "/" },
  { title: "المنتجات", href: "/products" },
  { title: "الفئات", href: "/categories" },
  { title: "العروض", href: "/offers" },
];

function openCart() {
  Emitter.emit("openCart");
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

      <!-- الأقسام -->
      <v-menu open-on-hover>
        <template #activator="{ props }">
          <v-btn text v-bind="props" class="text-white">الأقسام</v-btn>
        </template>

        <v-list>
          <v-list-item v-for="cat in categories" :key="cat.id">
            <Link
              :href="route('categories.show', cat.slug)"
              class="text-black no-underline"
            >
              {{ cat.name }}
            </Link>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-spacer />

      <!-- Desktop Menu -->
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

      <!-- Cart -->
      <v-badge
        :content="cartCount"
        color="red"
        overlap
        style="cursor: pointer"
        @click="openCart"
      >
        <v-icon>mdi-cart</v-icon>
      </v-badge>

      <!-- Auth Links -->
      <div class="ml-4">
        <!-- ✅ لو المستخدم داخل -->
        <template v-if="user">
          <v-menu>
            <template #activator="{ props }">
              <v-btn text class="text-white" v-bind="props">
                <v-icon class="mr-1">mdi-account</v-icon>
                {{ user.first_name }} {{ user.family_name }}
              </v-btn>
            </template>

            <v-list>
              <v-list-item>
                <Link href="/account" class="text-black no-underline">
                  الحساب الشخصي
                </Link>
              </v-list-item>
              <v-list-item>
                <Link
                  href="/logout"
                  method="post"
                  as="button"
                  class="text-black no-underline"
                >
                  تسجيل الخروج
                </Link>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>

        <!-- 🚪 لو المستخدم مش داخل -->
        <template v-else>
          <Link href="/auth/login" class="text-white mx-2 no-underline">
            تسجيل الدخول
          </Link>
          <Link href="/auth/register" class="text-white mx-2 no-underline">
            إنشاء حساب
          </Link>
        </template>
      </div>
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
