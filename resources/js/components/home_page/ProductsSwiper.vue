<template>
    <div class="products-swiper pt-16 pb-5 px-5">
        <!-- Title and Shop All -->
        <div class="title mb-10 px-5 d-flex align-center justify-space-between">
            <h2 class="section-title">
                {{ t(title) }}
            </h2>
            <Link href="/products" class="shop-all-link">
                {{ t('shop_all') }}
            </Link>
        </div>

        <!-- Navigation buttons -->
        <div class="d-flex justify-start mb-4">
            <v-btn icon variant="outlined" class="nav-btn mx-2" @click="goPrev">
                <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
            <v-btn icon variant="outlined" class="nav-btn mx-2" @click="goNext">
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
        </div>

        <!-- ✅ سلايدر -->
        <Swiper
            :modules="modules"
            :pagination="{ el: '.swiper-pagination', clickable: true }"
            :breakpoints="{
                0: { slidesPerView: 1, spaceBetween: 10 },
                600: { slidesPerView: 2, spaceBetween: 15 },
                960: { slidesPerView: 3, spaceBetween: 25 },
                1280: { slidesPerView: 5, spaceBetween: 35 },
            }"
            :space-between="35"
            :autoplay="{ delay: 20000 }"
            class="pb-9"
            @swiper="onSwiperInit"
        >
            <swiper-slide v-for="item in products" :key="item.id">
                <ProductCard :item="item" @quick-view="openQuickView" />
            </swiper-slide>

            <div class="swiper-pagination"></div>
        </Swiper>
    </div>
</template>

<script setup>
import ProductCard from "../../components/Shared/ProductCard.vue";
import { Link } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { ref, inject } from "vue";
import { useLocale } from "../../composables/useLocale";

const props = defineProps({ products: Array, title: String, titleColor: String });
const Emitter = inject("Emitter");
const { t } = useLocale();
function openQuickView(product) { Emitter.emit("openQuickView", product); }
const modules = [Pagination, Navigation, Autoplay];
const swiperInstance = ref(null);
function onSwiperInit(swiper) { swiperInstance.value = swiper; }
function goNext() { swiperInstance.value?.slideNext(); }
function goPrev() { swiperInstance.value?.slidePrev(); }
</script>

<style lang="scss" scoped>
.products-swiper {
    position: relative;

    .section-title {
        font-weight: 900;
        font-size: 30px;
        color: #302F2B;
        margin: 0;
    }

    .shop-all-link {
        font-size: 14px;
        font-weight: 600;
        color: #76543D;
        text-decoration: none;
        transition: color 0.2s;
        position: relative;
        padding-bottom: 2px;

        &::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #C69763;
            transition: width 0.3s ease;
        }

        &:hover {
            color: #C69763;

            &::after {
                width: 100%;
            }
        }
    }

    .nav-btn {
        border-color: #D7CDBD;
        color: #76543D;

        &:hover {
            background: rgba(118, 84, 61, 0.08);
            border-color: #76543D;
        }
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #D7CDBD;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        background: #76543D;
        opacity: 1;
    }

    .img-parent:hover .quick-view-btn {
        opacity: 1 !important;
    }
}

/* Responsive title sizing */
@media (max-width: 599px) {
    .section-title {
        font-size: 22px;
    }

    .shop-all-link {
        font-size: 12px;
    }
}

@media (min-width: 600px) and (max-width: 959px) {
    .section-title {
        font-size: 26px;
    }
}
</style>
