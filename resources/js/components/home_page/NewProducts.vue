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
                <v-col
                    cols="7"
                    class="pt-14"
                    v-if="!products || !products.length"
                >
                    <v-row>
                        <v-col cols="4" v-for="num in 3" :key="num">
                            <v-skeleton-loader type="image,article,button" />
                        </v-col>
                    </v-row>
                </v-col>

                <!-- عند وجود منتجات -->
                <v-col cols="12" lg="7" sm="12" md="7" class="pt-14" v-else>
                    <Swiper
                        :modules="modules"
                        :pagination="{
                            el: '.swiper-pagination',
                            clickable: true,
                        }"
                        :breakpoints="{
                            0: { slidesPerView: 2, spaceBetween: 10 },
                            600: { slidesPerView: 2, spaceBetween: 15 },
                            960: { slidesPerView: 3, spaceBetween: 25 },
                            1280: { slidesPerView: 4, spaceBetween: 35 },
                        }"
                        :space-between="20"
                        class="pb-9"
                    >
                        <swiper-slide v-for="item in products" :key="item.id">
                            <ProductCard
                                :item="item"
                                @quick-view="openQuickView"
                            />
                        </swiper-slide>

                        <div class="swiper-pagination"></div>
                    </Swiper>
                </v-col>

                <v-col cols="12" lg="5" sm="12" md="6">
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
import ProductCard from "../../components/Shared/ProductCard.vue";

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
