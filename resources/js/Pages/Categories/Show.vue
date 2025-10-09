<template>
  <v-container>
    <h1 class="text-h5 mb-4">{{ category.name }}</h1>

    <v-row>
      <v-col
        v-for="product in products"
        :key="product.id"
        cols="12"
        sm="6"
        md="4"
      >
        <ProductCard :item="product" @quick-view="openQuickView" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import ProductCard from "@/Components/Shared/ProductCard.vue";

defineProps({
  category: Object,
  products: Array
});

// Emitter
import { inject } from "vue";
const Emitter = inject("Emitter");

// Methods
function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}
</script>
