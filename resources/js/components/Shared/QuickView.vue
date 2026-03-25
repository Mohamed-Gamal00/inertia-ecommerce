<template>
  <div class="quick-view mt-16">
    <v-dialog v-model="dialog" max-width="900">
      <v-icon
        style="position:absolute; right:-14px; top:-14px; background-color:black; color:white; font-size:18px; padding:13px; z-index:10;"
        @click="dialog = false"
      >mdi-close</v-icon>

      <v-card elevation="0" class="content_card">
        <v-container fluid class="bg-white pt-10 px-10">
          <v-row>
            <!-- Images -->
            <v-col cols="7">
              <v-skeleton-loader v-if="loading" type="image,image,image" />
              <template v-else>
                <img
                  :src="tab || product.image_url"
                  class="w-100"
                  style="width:100%; height:400px; object-fit:cover"
                  alt="product"
                />
                <v-tabs center-active height="130" v-model="tab" class="mt-10">
                  <v-tab v-for="(img, i) in product.images" :key="i" :value="img.image_url" class="mx-10">
                    <img style="object-fit:contain" width="70" height="100" :src="img.image_url" alt="img" />
                  </v-tab>
                </v-tabs>
              </template>
            </v-col>

            <!-- Details -->
            <v-col cols="5" class="pt-0 pl-6">
              <v-skeleton-loader v-if="loading" type="article,article,article" />
              <v-card elevation="0" v-else>
                <v-card-title class="px-0" style="font-size:15px; font-weight:bold; white-space:pre-wrap">
                  {{ product.name }}
                  <span v-if="product.parent"> - {{ product.parent.name }}</span>
                </v-card-title>

                <v-card-text style="color:rgb(97,97,97); font-size:13px" class="px-0 pt-0">
                  {{ product.description }}
                </v-card-text>

                <v-card-text style="color:rgb(97,97,97); font-size:13px" class="px-0 pt-0">
                  Availability:
                  <strong>{{ product.quantity > 0 ? 'In Stock' : 'Out Of Stock' }}</strong>
                </v-card-text>

                <!-- Price -->
                <v-card-text class="pl-0 pt-0">
                  <template v-if="product.discount_price && product.discount_price < product.price">
                    <del class="text-grey">${{ product.price }}</del>
                    <span class="text-red ml-2" style="font-weight:900; font-size:16px">
                      ${{ Math.ceil(product.discount_price) }}
                    </span>
                  </template>
                  <template v-else>
                    <span style="font-weight:900; font-size:16px">${{ Math.ceil(product.price) }}</span>
                  </template>
                </v-card-text>

                <!-- Quantity -->
                <v-card-text class="pl-0 pt-0">Quantity</v-card-text>
                <div class="counter px-1" style="border:1px solid #bbb; border-radius:30px; width:fit-content">
                  <v-icon size="20" @click="quantity > 1 ? quantity-- : false">mdi-minus</v-icon>
                  <input
                    type="number" v-model="quantity" min="1"
                    style="border:none; outline:none; width:60px; font-size:13px"
                    class="text-center py-2"
                  />
                  <v-icon size="20" @click="quantity++">mdi-plus</v-icon>
                </div>

                <v-card-text class="pl-0">
                  Subtotal: <strong>${{ subtotal }}</strong>
                </v-card-text>

                <v-card-actions class="mt-2 w-100 px-0">
                  <v-btn
                    variant="elevated"
                    style="text-transform:none; border-radius:30px; background-color:rgb(32,32,32)"
                    class="w-75 text-white"
                    density="compact"
                    height="45"
                    :loading="btnLoading"
                    :disabled="!product.id || product.quantity < 1"
                    @click="addToCart"
                  >Add To Cart</v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
      {{ snackbarMessage }}
    </v-snackbar>
  </div>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import axios from 'axios';

const Emitter = inject('Emitter');

const dialog    = ref(false);
const loading   = ref(false);
const tab       = ref('');
const quantity  = ref(1);
const btnLoading = ref(false);
const product   = ref({});
const snackbar  = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');

const effectivePrice = computed(() =>
    product.value.discount_price && product.value.discount_price < product.value.price
        ? product.value.discount_price
        : product.value.price
);

const subtotal = computed(() => Math.ceil(effectivePrice.value || 0) * quantity.value);

async function addToCart() {
    btnLoading.value = true;
    try {
        const { data } = await axios.post('/cart/add', {
            product_id: product.value.id,
            quantity: quantity.value,
        });
        Emitter.emit('cart-item-added', data.items);
        snackbarMessage.value = 'تم إضافة المنتج للسلة';
        snackbarColor.value = 'success';
        dialog.value = false;
    } catch (e) {
        snackbarMessage.value = e.response?.data?.message || 'حدث خطأ';
        snackbarColor.value = 'error';
    } finally {
        btnLoading.value = false;
        snackbar.value = true;
    }
}

onMounted(() => {
    Emitter.on('openQuickView', (data) => {
        loading.value = true;
        product.value = data;
        quantity.value = 1;
        tab.value = '';
        dialog.value = true;
        setTimeout(() => { loading.value = false; }, 800);
    });
});
</script>

<style lang="scss" scoped>
.content_card {
    &::-webkit-scrollbar { width: 5px; }
    &::-webkit-scrollbar-track { background: #f1f1f1; }
    &::-webkit-scrollbar-thumb { background: #888; }
}
</style>
