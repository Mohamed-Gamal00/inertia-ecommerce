<template>
    <div class="products-swiper pt-16 pb-5 px-5">
        <!-- العنوان -->
        <div class="title mb-10 px-5 d-flex align-center justify-space-between">
            <h2
                style="font-weight: 900; font-size: 30px"
                :class="[`text-${titleColor}`]"
            >
                {{ title }}
            </h2>
            <Link
                href="/products"
                class="text-black"
                style="font-size: 14px; text-decoration: none"
            >
                Shop All
            </Link>
        </div>

        <!-- سكيلتون لودينج -->
        <v-container fluid v-if="!products || !products.length">
            <v-row>
                <v-col cols="12" class="pt-14">
                    <v-row>
                        <v-col cols="3" v-for="num in 4" :key="num">
                            <v-skeleton-loader type="image,article,button" />
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>

        <!-- سلايدر -->
        <Swiper
            :modules="modules"
            :pagination="{ el: '.swiper-pagination', clickable: true }"
            :slides-per-view="4"
            :space-between="35"
            :autoplay="{ delay: 6000 }"
            class="pb-9"
        >
            <swiper-slide v-for="item in products" :key="item.id">
            <ProductCard :item="item" @quick-view="openQuickView" />
            </swiper-slide>

            <div class="swiper-pagination"></div>
        </Swiper>
    </div>
</template>

<script setup>
import ProductCard from "@/Components/Shared/ProductCard.vue";

// Inertia
import { Link, router } from "@inertiajs/vue3";

// Swiper
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

// Props
const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    title: String,
    titleColor: String,
});

// Emitter
import { inject } from "vue";
const Emitter = inject("Emitter");

// Methods
function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}

function goToDetails(productId) {
    router.visit(`/products/${productId}`);
}

// Swiper Modules
const modules = [Pagination, Navigation, Autoplay];
</script>

<style lang="scss" scoped>
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
            font-weight: 900;
            color: rgb(97, 97, 97);
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
    }

    .img-parent:hover .quick-view-btn {
        opacity: 1 !important;
    }
}
</style>
