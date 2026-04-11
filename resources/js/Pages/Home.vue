<script setup>
import { defineProps, computed } from 'vue'
import SeoHead from '../components/Shared/SeoHead.vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    banners: {
        type: Array,
        default: () => [],
    },
});
</script>


<template>
    <div class="home">
        <SeoHead />
        <UpperPanner :banners="banners" />
        <TheFeatures />
        <TopOffers />
        <ProductsComponents
            :products="products"
            title="section_flash_deals"
            titleColor="red"
        />

        <TopCategories />
        <NewProducts :products="products" />
        <QualityFeatuers />
        <ProductsComponents
            :products="products"
            title="section_top_mobiles"
            titleColor="#404040"
        />
        <v-container fluid>
            <v-row>
                <v-col cols="6" class="pr-5">
                    <img
                        src="@/assets/images/band-left-cover.webp"
                        alt="band-left-cover"
                        class="w-100"
                    />
                </v-col>
                <v-col cols="6" class="pl-5">
                    <img
                        src="@/assets/images/band-right-cover.webp"
                        alt="band-left-cover"
                        class="w-100"
                    />
                </v-col>
            </v-row>
        </v-container>
        <ProductsComponents
            :products="products"
            title="section_top_fragrances"
            titleColor="#404040"
        />
        <img
            src="@/assets/images/tv-banner.webp"
            alt="band-left-cover"
            class="w-100"
        />

        <WhyShopWithUsVue />
    </div>
</template>

<script>
import UpperPanner from "../components/home_page/UpperPanner.vue";
import TheFeatures from "../components/home_page/TheFeatures.vue";
import TopOffers from "../components/home_page/TopOffers.vue";
import ProductsComponents from "../components/home_page/ProductsSwiper.vue";
import TopCategories from "../components/home_page/TopCategories.vue";
import NewProducts from "../components/home_page/NewProducts.vue";
import QualityFeatuers from "../components/home_page/QualityFeatuers.vue";
import WhyShopWithUsVue from "../components/home_page/WhyShopWithUs.vue";
export default {
    components: {
        UpperPanner,
        TheFeatures,
        TopOffers,
        ProductsComponents,
        TopCategories,
        NewProducts,
        QualityFeatuers,
        WhyShopWithUsVue,
    },
    name: "Home",

};
</script>
