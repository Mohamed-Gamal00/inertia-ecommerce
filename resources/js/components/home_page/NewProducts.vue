<!-- resources/js/Components/home_page/NewProducts.vue -->
<template>
    <div class="new-products pt-15">
        <!-- العنوان -->
        <div class="title px-5 d-flex align-center justify-space-between">
            <h2 style="font-weight: 900; font-size: 30px">New Products</h2>
            <Link
                href="/products"
                class="text-black"
                style="font-size: 14px; text-decoration: none"
            >
                Shop All
            </Link>
        </div>

        <v-container fluid>
            <v-row>
                <!-- حالة التحميل -->
                <v-col cols="7" class="pt-14" v-if="!products || !products.length">
                    <v-row>
                        <v-col cols="4" v-for="num in 3" :key="num">
                            <v-skeleton-loader type="image,article,button" />
                        </v-col>
                    </v-row>
                </v-col>

                <!-- عند وجود منتجات -->
                <v-col cols="7" class="pt-14" v-else>
                    <Swiper
                        :modules="modules"
                        :pagination="{ el: '.swiper-pagination', clickable: true }"
                        :slides-per-view="3"
                        :space-between="20"
                        class="pb-9"
                    >
                        <swiper-slide v-for="item in products" :key="item.id">
                            <v-card elevation="0">
                                <v-hover v-slot="{ isHovering, props }">
                                    <div
                                        class="img-parent position-relative"
                                        style="height: 160px; overflow: hidden"
                                    >
                                        <img
                                            :src="showenItem[item.title] || item.image_url"
                                            :alt="item.brand"
                                            class="w-100"
                                            :style="{
                        height: '100%',
                        transition: 'all 0.3s ease-in-out',
                        cursor: 'pointer',
                        scale: isHovering ? 1.05 : 1,
                      }"
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
                        transition: 0.2s all ease-in-out;
                        opacity: 0;
                      "
                                            @click="openQuickView(item)"
                                        >
                                            Quick View
                                        </v-btn>
                                    </div>
                                </v-hover>

                                <v-card-text class="pl-0 pb-1">
                                    {{
                                        (`(${item.title}) ${item.description}`).length <= 40
                                            ? `(${item.title}) ${item.description}`
                                            : `(${item.title}) ${item.description}`.substring(0, 40) +
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
                                />

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
                                        />
                                    </v-btn>
                                </v-btn-toggle>

                                <div class="mt-5">
                                    <v-btn
                                        style="text-transform: none; border-radius: 30px"
                                        density="compact"
                                        variant="outlined"
                                        class="py-3 px-12"
                                        @click="goToDetails(item.id)"
                                    >
                                        Choose Options
                                    </v-btn>
                                </div>
                            </v-card>
                        </swiper-slide>

                        <div class="swiper-pagination"></div>
                    </Swiper>
                </v-col>

                <v-col cols="5">
                    <img
                        src="@/assets/images/vr-banner.webp"
                        class="w-100"
                        alt="vr-banner"
                    />
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
// Inertia
import { Link, router } from "@inertiajs/vue3";

// Swiper
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";

// Vue
import { reactive, inject } from "vue";

// Props
const props = defineProps({
    products: Array,
});

// Emitter
const Emitter = inject("Emitter");

// Data
const showenItem = reactive({});

// Methods
function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}

function goToDetails(productId) {
    router.visit(`/products/${productId}`);
}

// Swiper modules
const modules = [Pagination];
</script>

<style lang="scss" scoped>
.new-products {
    .img-parent:hover {
        .quick-view-btn {
            opacity: 1 !important;
        }
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
    }
}
</style>
