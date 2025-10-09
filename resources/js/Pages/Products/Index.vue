<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3';
import ProductCard from "@/Components/Shared/ProductCard.vue";

const props = defineProps({
  products: Object
})

// هنا بنستخدم ref زي المثال بتاع Vuetify
const page = ref(props.products.current_page)

// لما الصفحة تتغير → اعمل زيارة جديدة
const goto = (val) => {
  router.visit(`/products?page=${val}`, {
    preserveState: true,
    preserveScroll: true,
  })
}

// Emitter
import { inject } from "vue";
const Emitter = inject("Emitter");

// Methods
function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}

// لو السيرفر رجع بيانات جديدة نحدّث الـ ref
watch(
  () => props.products.current_page,
  (val) => page.value = val
)
</script>

<template>
  <div class="px-4 py-6">
    <h1 class="text-h5 mb-6 text-center">قائمة المنتجات</h1>

    <v-row class="justify-center">
      <v-col
        v-for="product in products.data"
        :key="product.id"
        cols="6"
        sm="4"
        md="3"
        lg="2"
        class="d-flex justify-center"
      >
        <ProductCard :item="product" @quick-view="openQuickView" />

      </v-col>
    </v-row>

    <div class="d-flex justify-center mt-6">
      <v-pagination
        v-model="page"
        :length="products.last_page"
        total-visible="5"
        @update:model-value="goto"
      />
    </div>
  </div>
</template>
