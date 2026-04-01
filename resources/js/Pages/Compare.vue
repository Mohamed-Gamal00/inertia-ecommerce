<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:32px 16px 44px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:26px">مقارنة المنتجات</h1>
        </div>

        <div style="max-width:1000px; margin:24px auto; padding:0 16px">
            <div v-if="!compareList.length" class="text-center py-16">
                <v-icon size="64" color="grey-lighten-1">mdi-compare</v-icon>
                <p class="mt-3 text-grey">لا توجد منتجات للمقارنة</p>
                <a href="/products" class="btn-primary mt-4 d-inline-block">تصفح المنتجات</a>
            </div>

            <div v-else class="compare-table">
                <!-- Header row -->
                <div class="compare-row compare-row--header">
                    <div class="compare-cell compare-cell--label"></div>
                    <div v-for="p in compareList" :key="p.id" class="compare-cell compare-cell--product">
                        <button class="compare-remove" @click="toggle(p)">
                            <v-icon size="14">mdi-close</v-icon>
                        </button>
                        <img :src="p.image_url" :alt="p.name" class="compare-img" />
                        <div class="compare-product-name">{{ p.name }}</div>
                        <div class="compare-product-price">
                            ${{ Math.ceil(p.discount_price || p.price) }}
                            <span v-if="p.discount_price" class="compare-old-price">${{ p.price }}</span>
                        </div>
                        <a :href="`/products/${p.slug}`" class="compare-view-btn">عرض المنتج</a>
                    </div>
                </div>

                <!-- Data rows -->
                <div v-for="row in rows" :key="row.key" class="compare-row">
                    <div class="compare-cell compare-cell--label">{{ row.label }}</div>
                    <div v-for="p in compareList" :key="p.id" class="compare-cell">
                        {{ row.getValue(p) || '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCompare } from '../composables/useCompare';

const { compareList, toggle } = useCompare();

const rows = [
    { key: 'price',    label: 'السعر',    getValue: p => `$${Math.ceil(p.price)}` },
    { key: 'discount', label: 'بعد الخصم', getValue: p => p.discount_price ? `$${Math.ceil(p.discount_price)}` : 'لا يوجد خصم' },
];
</script>

<style scoped>
.compare-table { background: white; border-radius: 16px; border: 1px solid #e5e7eb; overflow: hidden; }
.compare-row { display: grid; grid-template-columns: 140px repeat(3, 1fr); border-bottom: 1px solid #f3f4f6; }
.compare-row--header { background: #f8f9fb; }
.compare-cell { padding: 16px; font-size: 13px; color: #374151; }
.compare-cell--label { font-weight: 700; color: #6b7280; background: #f8f9fb; border-left: 1px solid #f3f4f6; }
.compare-cell--product { text-align: center; position: relative; }
.compare-remove { position: absolute; top: 8px; left: 8px; background: #fee2e2; color: #ef4444; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.compare-img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; margin: 8px auto; display: block; }
.compare-product-name { font-weight: 700; font-size: 13px; margin-bottom: 4px; }
.compare-product-price { font-weight: 800; color: #1a237e; font-size: 15px; }
.compare-old-price { font-size: 11px; color: #9ca3af; text-decoration: line-through; margin-right: 4px; }
.compare-view-btn { display: inline-block; margin-top: 8px; background: #1a237e; color: white; border-radius: 8px; padding: 6px 14px; font-size: 12px; font-weight: 600; text-decoration: none; }
.btn-primary { background: #1a237e; color: white; border-radius: 10px; padding: 10px 24px; font-size: 14px; font-weight: 600; text-decoration: none; }
</style>
