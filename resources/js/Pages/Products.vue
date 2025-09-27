<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

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
  <div>
    <h1>Products List</h1>
    <v-row>
        <v-col cols="2" v-for="product in products.data" :key="product.id">
          <v-card class="text-center py-3 px-2" elevation="0">
            <v-hover v-slot="{ isHovering, props }">
              <div
                class="img-parent"
                style="
                  overflow: hidden;
                  width: 100%;
                  height: 170px;
                  border-radius: 50%;
                "
              >
                <img
                  :src="product.image_url"
                  alt="image"
                  :style="`
                    cursor: pointer;
                    height:100%;
                    width:100%;
                    transition: all 0.3s ease-in-out;
                    scale: ${isHovering ? 1.05 : 1};
                    `"
                  v-bind="props"
                />
              </div>
            </v-hover>
            <v-card-text>{{ product.name }}</v-card-text>
          </v-card>
        </v-col>
      </v-row>
    <!-- <ul>
      <li v-for="product in products.data" :key="product.id">
        {{ product.name }}
      </li>
    </ul> -->

    <!-- نفس فكرة المثال: v-model مع ref -->
    <v-pagination
      v-model="page"
      :length="products.last_page"
      total-visible="7"
      @update:model-value="goto"
    />
  </div>
</template>
