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
    homeDesigns: {
        type: Object,
        default: () => ({}),
    },
});

// Static fallbacks (used when no image is set in DB)
import bandLeft  from '@/assets/images/band-left-cover.webp';
import bandRight from '@/assets/images/band-right-cover.webp';
import tvBanner  from '@/assets/images/tv-banner.webp';

const bandLeftSrc  = computed(() => props.homeDesigns?.home_band_left  || bandLeft);
const bandRightSrc = computed(() => props.homeDesigns?.home_band_right || bandRight);
const tvBannerSrc  = computed(() => props.homeDesigns?.home_tv_banner  || tvBanner);

// ===================================
// Centralized Section Background Colors
// ===================================
const sectionColors = {
    vanilla: '#F7F0E5',      // Vanilla Cream
    latte: '#E6D3BB',        // Latte Beige
    white: '#FFFFFF',        // Pure White
    softHover: '#EFE3D2',    // Soft Hover
};
</script>


<template>
    <div class="home">
        <SeoHead />
        <UpperPanner :banners="banners" />
        <TheFeatures :bgColor="sectionColors.white" />
        <TopCategories :bgColor="sectionColors.vanilla" />
        <TopOffers :bgColor="sectionColors.latte" />
        <ProductsComponents
            :products="products"
            title="section_flash_deals"
            titleColor="red"
            :bgColor="sectionColors.softHover"
        />

        <NewProducts :products="products" :bgColor="sectionColors.vanilla" />
        <QualityFeatuers :bgColor="sectionColors.vanilla" />
        <ProductsComponents
            :products="products"
            title="Gifts"
            titleColor="#404040"
            :bgColor="sectionColors.softHover"
        />
        <v-container fluid>
            <v-row>
                <v-col cols="6" class="pr-5">
                    <img
                        :src="bandLeftSrc"
                        alt="band-left-cover"
                        class="w-100"
                    />
                </v-col>
                <v-col cols="6" class="pl-5">
                    <img
                        :src="bandRightSrc"
                        alt="band-right-cover"
                        class="w-100"
                    />
                </v-col>
            </v-row>
        </v-container>
        <ProductsComponents
            :products="products"
            title="Household_supplies"
            titleColor="#404040"
            :bgColor="sectionColors.softHover"
        />
        <img
            :src="tvBannerSrc"
            alt="tv-banner"
            class="w-100"
        />

        <!-- <WhyShopWithUsVue /> -->
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
