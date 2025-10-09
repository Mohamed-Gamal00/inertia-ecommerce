<template>
  <v-container class="mt-16 product-details">
    <v-row>
      <!-- الصور -->
      <!-- <v-col cols="12" md="7">
        <v-skeleton-loader v-if="loading" type="image" />
        <v-img
          v-else
          :src="product.image_url"
          height="450"
          class="rounded-lg"
          cover
        />

        <v-tabs
          v-model="selectedImage"
          align-tabs="center"
          class="mt-6"
          height="120"
        >
          <v-tab
            v-for="(img, i) in product.images"
            :key="i"
            :value="img"
            class="mx-2"
          >
            <v-img :src="img.image_url" height="100" width="100" cover class="rounded-lg" />
          </v-tab>
        </v-tabs>
      </v-col> -->
            <v-col cols="7">
              <img
                :src="selectedImage || product.image_url"

                class="w-100"
                style="width: 100%; height: 400px"
                alt="thumbnail"
                v-if="!loading"
              />
              <v-skeleton-loader
                v-if="loading"
                type="image,image,image"
              ></v-skeleton-loader>
                <v-tabs center-active height="130" class="mt-10">
                    <v-tab
                        v-for="(img, i) in product.images"
                        :key="i"
                        :value="img.image_url"
                        class="mx-10"
                        @click="selectedImage = img.image_url"

                    >
                        <img
                            style="object-fit: contain"
                            width="70"
                            height="100"
                            :src="img.image_url"
                            alt="img"
                        />
                    </v-tab>
                </v-tabs>
            </v-col>
      <!-- التفاصيل -->
      <v-col cols="12" md="5">
        <v-card elevation="0" class="pt-2">
          <v-card-title class="px-0 text-h6 font-weight-bold">
            {{ product.name }} - {{ product.parent?.name }}
          </v-card-title>

          <div class="d-flex align-center my-2" style="gap: 10px">
            <v-rating
              v-model="product.rating"
              half-increments
              readonly
              color="yellow-darken-2"
              size="small"
              density="compact"
            />
            <span class="text-grey-darken-1 text-caption">
              Stock: {{ product.quantity }}
            </span>
          </div>

          <v-card-text class="px-0 text-body-2 text-grey-darken-1">
            {{ product.description }}
          </v-card-text>

          <v-card-text class="px-0 text-body-2 text-grey-darken-1">
            Brand: {{ product.parent.name }}
          </v-card-text>

          <v-card-text class="px-0 text-body-2 text-grey-darken-1">
            Availability:
            <strong>
              {{ product.quantity > 0 ? "In Stock" : "Out of Stock" }}
            </strong>
          </v-card-text>

          <!-- السعر -->
          <v-card-text class="pl-0 pt-0">
            <del class="text-grey">${{ product.price }}</del>
            <span class="ml-2 font-weight-bold text-h6">${{product.discount_price }}</span>
          </v-card-text>

          <!-- الكمية -->
          <v-card-text class="pl-0 pt-0">Quantity</v-card-text>
          <div
            class="d-flex align-center pa-1"
            style="border: 1px solid #bbb; border-radius: 30px; width: fit-content;"
          >
            <v-icon size="20" @click="quantity > 1 ? quantity-- : null">mdi-minus</v-icon>
            <input
              type="number"
              v-model="quantity"
              min="1"
              class="text-center py-2"
              style="border: none; outline: none; width: 60px; font-size: 13px"
            />
            <v-icon size="20" @click="quantity++">mdi-plus</v-icon>
          </div>

          <!-- المجموع الفرعي -->
          <v-card-text class="pl-0 pt-0 my-4">
            Subtotal: <strong>${{ subtotal }}</strong>
          </v-card-text>

          <!-- زر الإضافة للسلة -->
            <v-card-actions class="mt-7 w-100 px-0">
              <v-btn
                variant="elevated"
                style="
                  text-transform: none;
                  border-radius: 30px;
                  background-color: rgb(32, 32, 32);
                "
                class="w-75 text-white"
                density="compact"
                height="45"
                @click="addToCart(singleProduct)"
                :loading="btnLoading"
                >Add To Cart</v-btn
              >
            </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const product = props.product;

const loading = ref(false);
const selectedImage = ref(null);
const quantity = ref(1);
const btnLoading = ref(false);

const discount_price = computed(() =>
  Math.ceil(
    product.price -
      product.price * (product.discount_price / 100)
  )
);

const subtotal = computed(() => discount_price.value * quantity.value);

const addToCart = (product) => {
  btnLoading.value = true;
  setTimeout(() => {
    btnLoading.value = false;
    alert(`${product.title} added to cart!`);
  }, 800);
};
</script>

<style scoped>
.product-details {
  min-height: 80vh;
}
</style>
