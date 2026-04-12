<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <SeoHead
            :title="category.name"
            :description="category.description || `تصفح ${products.length} منتج في قسم ${category.name}`"
            :image="category.image_url"
        />

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">
                {{ category.name }}
            </h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">
                {{ products.length }} {{ t('products_in_category') }}
            </p>
        </div>

        <div style="padding:32px 16px; max-width:1400px; margin:0 auto">

            <!-- Empty state -->
            <div v-if="!products.length" style="text-align:center; padding:64px 0">
                <v-icon size="64" color="grey-lighten-1">mdi-shopping-outline</v-icon>
                <p style="margin-top:12px; color:#9ca3af">{{ t('no_products_in_category') }}</p>
                <v-btn color="primary" rounded="lg" href="/products" class="mt-4" style="text-transform:none">{{ t('browse_all_products') }}</v-btn>
            </div>

            <!-- Products grid -->
            <v-row v-else>
                <v-col
                    v-for="product in products"
                    :key="product.id"
                    cols="6"
                    sm="4"
                    md="3"
                    lg="2"
                >
                    <ProductCard :item="product" @quick-view="openQuickView" />
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script setup>
import { inject } from 'vue';
import ProductCard from '../../components/Shared/ProductCard.vue';
import SeoHead from '../../components/Shared/SeoHead.vue';
import { useLocale } from '../../composables/useLocale';
const { t, pick } = useLocale();
const props = defineProps({ category: Object, products: Array });

const Emitter = inject('Emitter');
function openQuickView(product) {
    Emitter.emit('openQuickView', product);
}
</script>
