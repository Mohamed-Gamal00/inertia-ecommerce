<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
;

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
        <v-card
          class="text-center py-3 px-2 w-100"
          elevation="2"
          rounded="xl"
        >
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="img-parent mx-auto"
              style="
                overflow: hidden;
                width: 100%;
                aspect-ratio: 1 / 1;
                border-radius: 50%;
                background: #f9f9f9;
              "
            >
              <img
                :src="product.image_url"
                alt="image"
                :style="`
                  cursor: pointer;
                  height: 100%;
                  width: 100%;
                  object-fit: cover;
                  transition: transform 0.3s ease-in-out;
                  transform: scale(${isHovering ? 1.05 : 1});
                `"
                v-bind="props"
              />
            </div>
          </v-hover>

          <v-card-text class="mt-3 font-weight-medium">
            {{ product.name }}
          </v-card-text>
        </v-card>
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
