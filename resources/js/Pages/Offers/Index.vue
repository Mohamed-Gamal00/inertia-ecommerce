<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#c62828,#e53935); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">🔥 العروض والتخفيضات</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.85); font-size:14px">
                {{ products.total }} منتج بأسعار مخفضة
            </p>
        </div>

        <div style="padding:32px 16px; max-width:1400px; margin:0 auto">
            <v-row v-if="products.data?.length">
                <v-col v-for="product in products.data" :key="product.id" cols="6" sm="4" md="3" lg="2">
                    <ProductCard :item="product" @quick-view="openQuickView" />
                </v-col>
            </v-row>

            <div v-else style="text-align:center; padding:64px 0">
                <v-icon size="64" color="grey-lighten-1">mdi-tag-off-outline</v-icon>
                <p style="margin-top:12px; color:#9ca3af">لا توجد عروض متاحة حالياً</p>
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

const props = defineProps({ products: Object });
const Emitter = inject('Emitter');
const page = ref(props.products.current_page);

function goto(val) { router.visit(`/offers?page=${val}`, { preserveState: true, preserveScroll: true }); }
function openQuickView(product) { Emitter.emit('openQuickView', product); }
watch(() => props.products.current_page, (val) => page.value = val);
</script>
