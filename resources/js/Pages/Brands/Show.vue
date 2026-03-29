<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">

        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <div style="display:flex; align-items:center; justify-content:center; gap:16px; flex-wrap:wrap">
                <div style="width:64px; height:64px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; overflow:hidden">
                    <img v-if="brand.image_url && !brand.image_url.includes('no-image')" :src="brand.image_url" style="width:100%; height:100%; object-fit:contain; padding:8px" />
                    <span v-else style="font-size:24px; font-weight:800; color:white">{{ brand.name_en?.charAt(0) }}</span>
                </div>
                <div class="text-center">
                    <h1 class="text-white font-weight-bold" style="font-size:28px">{{ brand.name }}</h1>
                    <p style="color:rgba(255,255,255,0.75); font-size:14px">{{ products.total }} منتج</p>
                </div>
            </div>
        </div>

        <div style="padding:32px 16px; max-width:1400px; margin:0 auto">
            <v-row v-if="products.data?.length">
                <v-col v-for="product in products.data" :key="product.id" cols="6" sm="4" md="3" lg="2">
                    <ProductCard :item="product" @quick-view="openQuickView" />
                </v-col>
            </v-row>

            <div v-else style="text-align:center; padding:64px 0">
                <v-icon size="64" color="grey-lighten-1">mdi-shopping-outline</v-icon>
                <p style="margin-top:12px; color:#9ca3af">لا توجد منتجات لهذه الماركة</p>
            </div>

            <div class="d-flex justify-center mt-8" v-if="products.last_page > 1">
                <v-pagination v-model="page" :length="products.last_page" total-visible="5" rounded="lg" @update:model-value="goto" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, inject } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductCard from '../../components/Shared/ProductCard.vue';

const props = defineProps({ brand: Object, products: Object });
const Emitter = inject('Emitter');
const page = ref(props.products.current_page);

function goto(val) { router.visit(`/brands/${props.brand.id}?page=${val}`, { preserveState: true, preserveScroll: true }); }
function openQuickView(product) { Emitter.emit('openQuickView', product); }
watch(() => props.products.current_page, (val) => page.value = val);
</script>
