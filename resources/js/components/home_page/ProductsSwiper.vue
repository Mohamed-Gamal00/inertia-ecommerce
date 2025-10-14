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

        <!-- ✅ أزرار التنقل فوق السلايدر -->
        <div class="d-flex justify-start mb-4">
            <v-btn icon variant="outlined" class="mx-2" @click="goPrev">
                <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
            <v-btn icon variant="outlined" class="mx-2" @click="goNext">
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
                1280: { slidesPerView: 4, spaceBetween: 35 },
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
import { Link, router } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { ref, inject } from "vue";

const props = defineProps({
    products: Array,
    title: String,
    titleColor: String,
});

const Emitter = inject("Emitter");
function openQuickView(product) {
    Emitter.emit("openQuickView", product);
}

const modules = [Pagination, Navigation, Autoplay];

// ✅ نحتفظ بالـ swiper instance لما يجهز
const swiperInstance = ref(null);

function onSwiperInit(swiper) {
    swiperInstance.value = swiper;
}

function goNext() {
    swiperInstance.value?.slideNext();
}

function goPrev() {
    swiperInstance.value?.slidePrev();
}
</script>

<style lang="scss" scoped>
.products-swiper {
    position: relative;

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
    }

    .img-parent:hover .quick-view-btn {
        opacity: 1 !important;
    }
}
</style>
