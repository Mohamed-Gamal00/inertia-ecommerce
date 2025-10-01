<template>
  <div class="products-swiper pt-16 pb-5 px-5">
    <div class="title mb-10 px-5 d-flex align-center justify-space-between">
      <h2
        style="font-weight: 900; font-size: 30px"
        :class="[`text-${titleColor}`]"
      >
        {{ title }}
      </h2>
      <a href="#" class="text-black" style="font-size: 14px"> Shop All</a>
    </div>
    <v-container fluid v-if="!products.length">
      <VRow>
        <v-col cols="12" class="pt-14">
          <v-row>
            <v-col cols="3" v-for="num in 4" :key="num">
              <v-skeleton-loader type="image,article,button">
              </v-skeleton-loader>
            </v-col>
          </v-row>
        </v-col>
      </VRow>
    </v-container>
    <Swiper
      :modules="modules"
      :pagination="{ el: '.swiper-pagination', clickable: true }"
      :slides-per-view="4"
      :space-between="35"
      :navigation="{ prevIcon: '.swiper-prev', nextIcon: '.swiper-next' }"
      :autoplay="{ delay: 3000 }"
      class="pb-9"
    >
      <swiper-slide v-for="item in products" :key="item.id">
        <v-card elevation="0">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="img-parent position-relative"
              style="height: 200px; overflow: hidden"
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
                width="60"
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

          <v-card-text class="pl-0 pb-1 pr-10">
            {{
              `(${item.title})${item.description}`.length <= 40
                ? `(${item.title})${item.description}`
                : `(${item.title})${item.description}`.substring(0, 40) + "..."
            }}
            <!-- ({{ item.title }}) -->
            <!-- {{
              item.description + " " + item.title.split(" ").length <= 9
                ? item.description
                : item.description
                    .split(" ")
                    .slice(0, 9 - item.title.split(" ").length)
                    .join(" ") + "...."
            }} -->
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
            <span class="text-red" style="font-weight: 900; font-size: 16px">
              ${{
                Math.ceil(
                  item.price - item.price * (item.discountPercentage / 100)
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
              density="compact"
              variant="outlined"
              @click="
                $router.push({
                  name: 'products_details',
                  params: { productId: item.id },
                })
              "
              class="py-3 px-12"
              >Choose Options</v-btn
            >
          </div>
        </v-card>
      </swiper-slide>
      <div class="swiper-prev"></div>
      <div class="swiper-next"></div>
      <div class="swiper-pagination"></div>
    </Swiper>
  </div>
</template>

<script>
// import "swiper/css";
// import { Swiper, SwiperSlide } from "vue-awesome-swiper";
// import { Navigation, Pagination, Autoplay } from "swiper/modules";
// import { VSkeletonLoader } from "vuetify/lib/labs/components.mjs";

export default {
  inject: ["Emitter"],
  methods: {
    openQuickView(product) {
      this.Emitter.emit("openQuickView", product);
    },
  },
  props: {
    products: {
      type: Array,
    },
    title: {
      type: String,
    },
    titleColor: {
      type: String,
    },
  },
  setup() {
    return {
      modules: [Pagination, Navigation, Autoplay],
    };
  },
  components: {
    Swiper,
    SwiperSlide,
    VSkeletonLoader,
  },
  data() {
    return {
      showenItem: {},
    };
  },
};
</script>

<style lang="scss">
.products-swiper {
  .swiper-button-next,
  .swiper-button-prev {
    width: 35px;
    height: 35px;
    border: 2px solid black;
    border-radius: 50%;
    background-color: white;
    top: 43%;
    &::after {
      font-size: 13px;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: 900;
      color: rgb(97, 97, 97);
    }
  }
  .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
  }
  .img-parent:hover {
    .quick-view-btn {
      opacity: 1 !important;
    }
  }
}
</style>
