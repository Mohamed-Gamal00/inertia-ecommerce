
<template>
  <v-container>
    <h1 class="text-h5 mb-4">الأقسام</h1>

    <v-row>
      <v-col
        v-for="category in categories"
        :key="category.id"
        cols="12"
        sm="6"
        md="4"
      >
        <Link
          :href="route('categories.show', category.slug)"
          class="no-underline"
        >
          <v-card class="pa-4 text-center hover:bg-grey-lighten-4">
            <v-card-title>{{ category.name }}</v-card-title>
          </v-card>
        </Link>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  categories: Array
});
</script>

















<!-- <template>
  <div class="products-category">
    <h1 class="text-center mt-10">{{ $route.params.title }}</h1>
    <v-container>
      <v-card elevation="0" class="pt-5" min-height="700px">
        <v-row v-if="loading">
          <v-col cols="3" v-for="num in 4" :key="num">
            <v-skeleton-loader type="image,article,button"> </v-skeleton-loader>
          </v-col>
        </v-row>
        <v-row v-if="!loading">
          <v-col
            cols="3"
            v-for="item in categoryProducts.products"
            :key="item.id"
            class="px-5"
          >
            <v-lazy>
              <v-card elevation="0">
                <v-hover v-slot="{ isHovering, props }">
                  <div
                    class="img-parent position-relative"
                    style="height: 160px; overflow: hidden"
                  >
                    <img
                      :src="
                        showenItem[item.title]
                          ? showenItem[item.title]
                          : item.thumbnail
                      "
                      :alt="item.brand"
                      class="w-100"
                      :style="`height: 100%;transition: all 0.3s ease-in-out;cursor:pointer;scale:${
                        isHovering ? 1.05 : 1
                      }`"
                      v-bind="props"
                    />
                    <v-btn
                      density="compact"
                      width="80"
                      height="30"
                      variant="outlined"
                      class="bg-white quick-view-btn"
                      style="
                        text-transform: none;
                        position: absolute;
                        left: 50%;
                        top: 50%;
                        transform: translate(-50%, -50%);
                        font-size: 12px;
                        transition: 0.2 all ease-in-out;
                        opacity: 0;
                      "
                      @click="openQuickView(item)"
                    >
                      Quic View
                    </v-btn>
                  </div>
                </v-hover>

                <v-card-text class="pl-0 pb-1">
                  {{
                    `(${item.title})${item.description}`.length <= 40
                      ? `(${item.title})${item.description}`
                      : `(${item.title})${item.description}`.substring(0, 40) +
                        "..."
                  }}

                </v-card-text>
                <v-rating
                  v-model="item.rating"
                  half-increments
                  readonly
                  color="yellow-darken-2"
                  size="x-small"
                  density="compact"
                ></v-rating>
                <v-card-text class="pl-0 pt-0">
                  <del>${{ item.price }}</del>

                  from
                  <span
                    class="text-red"
                    style="font-weight: 900; font-size: 16px"
                  >
                    ${{
                      Math.ceil(
                        item.price -
                          item.price * (item.discountPercentage / 100)
                      )
                    }}
                  </span>
                </v-card-text>
                <v-btn-toggle v-model="showenItem[item.title]">
                  <v-btn
                    v-for="(pic, i) in item.images"
                    :value="pic"
                    :key="i"
                    size="x-small"
                    rounded="xl"
                    :ripple="false"
                  >
                    <img
                      :src="pic"
                      width="30"
                      height="30"
                      style="
                        border: 1px solid rgba(110, 110, 110, 0.377);
                        border-radius: 50%;
                      "
                      alt="img"
                  /></v-btn>
                </v-btn-toggle>
                <div class="mt-5">
                  <v-btn
                    style="text-transform: none; border-radius: 30px"
                    width="220"
                    height="40"
                    variant="outlined"
                    class="py-3 px-12"
                    @click="
                      $router.push({
                        name: 'products_details',
                        params: { productId: item.id },
                      })
                    "
                    >Choose Options</v-btn
                  >
                </div>
              </v-card>
            </v-lazy>
          </v-col>
        </v-row>
      </v-card>
    </v-container>
  </div>
</template>

<script>
import { productModules } from "@/stores/products";
import { mapActions, mapState } from "pinia";
import { VSkeletonLoader } from "vuetify/lib/labs/components.mjs";

export default {
  inject: ["Emitter"],
  components: { VSkeletonLoader },
  data() {
    return {
      showenItem: {},
      loading: false,
    };
  },
  methods: {
    ...mapActions(productModules, ["getProductsByCategory"]),
    openQuickView(product) {
      this.Emitter.emit("openQuickView", product);
    },
  },
  computed: {
    ...mapState(productModules, ["categoryProducts"]),
  },
  watch: {
    async $route() {
      document.documentElement.scrollTo(0, 0);
      this.loading = true;

      await this.getProductsByCategory(this.$route.params.category);
      this.loading = false;
    },
  },
  async mounted() {
    this.loading = true;
    await this.getProductsByCategory(this.$route.params.category);
    this.loading = false;
  },
};
</script>

<style lang="scss" scoped>
.products-category {
  .img-parent:hover {
    .quick-view-btn {
      opacity: 1 !important;
    }
  }
}
</style> -->
