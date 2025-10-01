<template>
  <div class="quick-view mt-16">
    <v-dialog v-model="dialog" max-width="900" max-height="500">
      <v-icon
        style="
          position: absolute;
          right: -14px;
          top: -14px;
          background-color: black;
          color: white;
          font-size: 18px;
          padding: 13px;
          z-index: 10;
        "
        @click="dialog = false"
        >mdi-close</v-icon
      >
      <v-card elevation="0" class="content_card">
        <v-container fluid class="bg-white pt-10 px-10">
          <v-row>
            <v-col cols="7">
              <img
                :src="tab ? tab : product.thumbnail"
                class="w-100"
                style="width: 100%; height: 400px"
                alt="thumbnail"
                v-if="!loading"
              />
              <v-skeleton-loader
                v-if="loading"
                type="image,image,image"
              ></v-skeleton-loader>
              <v-tabs center-active height="130" v-model="tab" class="mt-10">
                <v-tab
                  v-for="(img, i) in product.images"
                  :key="i"
                  :value="img"
                  class="mx-10"
                >
                  <img
                    style="object-fit: contain"
                    width="70"
                    height="100"
                    contain
                    :src="img"
                    alt="img"
                  />
                </v-tab>
              </v-tabs>
            </v-col>
            <v-col cols="5" class="pt-0 pl-6">
              <v-skeleton-loader
                v-if="loading"
                type="article,article,article"
              ></v-skeleton-loader>
              <v-card elevation="0" v-if="!loading">
                <v-card-title
                  class="px-0"
                  style="
                    font-size: 15px;
                    font-weight: bold;
                    white-space: pre-wrap;
                  "
                >
                  {{ product.title }} Sample - {{ product.category }} For Sale
                </v-card-title>
                <div
                  class="rating-parent d-flex aling-center"
                  style="gap: 10px"
                >
                  <v-rating
                    v-model="product.rating"
                    half-increments
                    readonly
                    color="yellow-darken-2"
                    size="x-small"
                    density="compact"
                  ></v-rating>
                  <span
                    class="mt-1"
                    style="color: rgb(97, 97, 97); font-size: 13px"
                    >Stock: {{ product.stock }}</span
                  >
                </div>
                <v-card-text
                  style="color: rgb(97, 97, 97); font-size: 13px"
                  class="px-0"
                >
                  {{ product.description }}
                </v-card-text>
                <v-card-text
                  style="color: rgb(97, 97, 97); font-size: 13px"
                  class="px-0 pt-0"
                >
                  Brand: {{ product.brand }}
                </v-card-text>
                <v-card-text
                  style="color: rgb(97, 97, 97); font-size: 13px"
                  class="px-0 pt-0"
                >
                  Availabilty:
                  {{ product.stock > 0 ? "In Stock" : "Out Of stock" }}
                </v-card-text>

                <v-card-text class="pl-0 pt-0">
                  <del>${{ product.price }}</del>

                  from
                  <span style="font-weight: 900; font-size: 16px">
                    ${{
                      Math.ceil(
                        product.price -
                          product.price * (product.discountPercentage / 100)
                      )
                    }}
                  </span>
                </v-card-text>
                <v-card-text class="pl-0 pt-0">Quantity</v-card-text>
                <div
                  class="counter px-1"
                  style="
                    border: 1px solid rgb(187, 187, 187);
                    border-radius: 30px;
                    width: fit-content;
                  "
                >
                  <v-icon size="20" @click="quantity > 1 ? quantity-- : false"
                    >mdi-minus</v-icon
                  >
                  <input
                    type="number"
                    style="
                      border: none;
                      outline: none;
                      width: 60px;
                      font-size: 13px;
                    "
                    class="text-center py-2"
                    min="1"
                    v-model="quantity"
                  />
                  <VIcon size="20" @click="quantity++">mdi-plus</VIcon>
                </div>
                <v-card-text class="pl-0">
                  Subtotal:${{
                    Math.ceil(
                      product.price -
                        product.price * (product.discountPercentage / 100)
                    ) * quantity
                  }}
                </v-card-text>
                <v-card-actions class="mt-2 w-100 px-0">
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
                    @click="addToCart(product)"
                    :loading="btnLoading"
                    >Add To Cart</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { VSkeletonLoader } from "vuetify/lib/labs/components.mjs";
import { mapActions } from "pinia";
import { createStore } from "@/stores/cart.js";
export default {
  inject: ["Emitter"],
  components: {
    VSkeletonLoader,
  },
  methods: {
    ...mapActions(createStore, ["addItem"]),
    addToCart(item) {
      item.quantity = this.quantity;
      this.btnLoading = true;
      setTimeout(() => {
        this.btnLoading = false;
      }, 1000);
      this.addItem(item);
      this.Emitter.emit("openCart");
      this.Emitter.emit("showMsg", item.title);
      this.dialog = false;
    },
  },
  data() {
    return {
      loading: false,
      tab: "",
      quantity: 1,
      dialog: false,
      product: "",
      btnLoading: false,
    };
  },
  mounted() {
    this.Emitter.on("openQuickView", (data) => {
      this.loading = true;
      this.product = data;
      this.dialog = true;
      setTimeout(() => {
        this.loading = false;
      }, 1000);
    });
  },
};
</script>

<style lang="scss" scoped>
.content_card {
  &::-webkit-scrollbar {
    width: 5px;
  }
  &::-webkit-scrollbar-track {
    width: 5px;
    background: #f1f1f1;
  }
  &::-webkit-scrollbar-thumb {
    width: 5px;
    background: #888;
  }
}
</style>
