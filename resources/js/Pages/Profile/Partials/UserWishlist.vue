<template>
  <div>
    <h3 class="mb-4">قائمة المفضلة</h3>

    <v-row v-if="wishlists.length" class="justify-center">
      <v-col
        v-for="product in wishlists"
        :key="product.id"
        cols="6"
        sm="4"
        md="4"
        lg="4"
        class="d-flex justify-center"
      >
        <ProductCard :item="product" @quick-view="openQuickView" />
      </v-col>
    </v-row>

    <v-alert
      v-else
      type="info"
      variant="outlined"
      text="لا توجد منتجات في المفضلة حتى الآن."
      class="text-center mt-6"
    />
  </div>
</template>

<script setup>
import { computed } from "vue";
import ProductCard from "../../../components/Shared/ProductCard.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const wishlists = computed(() => props.user?.wishlist_products ?? []);

import { inject } from "vue";
const Emitter = inject("Emitter");

function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}

</script>
