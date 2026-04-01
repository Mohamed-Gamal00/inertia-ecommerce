<template>
    <div class="cmp-page">

        <!-- Header -->
        <div class="cmp-hero">
            <h1 class="text-white font-weight-bold" style="font-size:26px">مقارنة المنتجات</h1>
            <p style="color:rgba(255,255,255,0.75); font-size:13px; margin-top:4px">
                {{ products.length }} منتجات للمقارنة
            </p>
        </div>

        <div class="cmp-container">

            <!-- Empty state -->
            <div v-if="!products.length" class="cmp-empty">
                <v-icon size="72" color="grey-lighten-1">mdi-compare-remove</v-icon>
                <p class="mt-3 font-weight-bold" style="font-size:16px; color:#374151">لا توجد منتجات للمقارنة</p>
                <p style="color:#9ca3af; font-size:13px">أضف منتجات من صفحة المنتجات</p>
                <a href="/products" class="cmp-btn-primary mt-4">تصفح المنتجات</a>
            </div>

            <template v-else>

                <!-- Product cards row -->
                <div class="cmp-products-row">
                    <!-- Label column -->
                    <div class="cmp-label-col">
                        <div class="cmp-label-header">المنتج</div>
                    </div>

                    <!-- Product columns -->
                    <div v-for="p in products" :key="p.id" class="cmp-product-col">
                        <!-- Remove button -->
                        <button class="cmp-remove" @click="removeProduct(p.id)" title="إزالة">
                            <v-icon size="14">mdi-close</v-icon>
                        </button>

                        <!-- Image -->
                        <div class="cmp-img-wrap">
                            <img :src="p.image_url" :alt="p.name" class="cmp-img" />
                            <span v-if="discountPercent(p)" class="cmp-discount-badge">
                                -{{ discountPercent(p) }}%
                            </span>
                        </div>

                        <!-- Name -->
                        <div class="cmp-product-name">{{ p.name }}</div>

                        <!-- Category -->
                        <div v-if="p.parent" class="cmp-product-cat">{{ p.parent.name }}</div>

                        <!-- Price -->
                        <div class="cmp-product-price">
                            <span class="cmp-price-new">${{ Math.ceil(p.discount_price || p.price) }}</span>
                            <span v-if="p.discount_price && p.discount_price < p.price" class="cmp-price-old">
                                ${{ p.price }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="cmp-product-actions">
                            <button class="cmp-btn-cart" @click="addToCart(p)" :disabled="p.quantity < 1">
                                <v-icon size="14" class="me-1">mdi-cart-plus</v-icon>
                                {{ p.quantity < 1 ? 'نفذت الكمية' : 'أضف للسلة' }}
                            </button>
                            <a :href="`/products/${p.slug}`" class="cmp-btn-view">
                                <v-icon size="14">mdi-eye-outline</v-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Comparison table -->
                <div class="cmp-table">

                    <!-- Section: Pricing -->
                    <div class="cmp-section-title">التسعير</div>

                    <div class="cmp-row">
                        <div class="cmp-label">السعر الأصلي</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val">
                            ${{ p.price }}
                        </div>
                    </div>

                    <div class="cmp-row">
                        <div class="cmp-label">سعر الخصم</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val"
                             :class="{ 'cmp-val--good': p.discount_price && p.discount_price < p.price }">
                            {{ p.discount_price && p.discount_price < p.price ? `$${Math.ceil(p.discount_price)}` : '—' }}
                        </div>
                    </div>

                    <div class="cmp-row">
                        <div class="cmp-label">نسبة الخصم</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val"
                             :class="{ 'cmp-val--good': discountPercent(p) }">
                            {{ discountPercent(p) ? `-${discountPercent(p)}%` : '—' }}
                        </div>
                    </div>

                    <!-- Section: Details -->
                    <div class="cmp-section-title">التفاصيل</div>

                    <div class="cmp-row">
                        <div class="cmp-label">القسم</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val">
                            {{ p.parent?.name || '—' }}
                        </div>
                    </div>

                    <div class="cmp-row">
                        <div class="cmp-label">المخزون</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val"
                             :class="p.quantity > 0 ? 'cmp-val--good' : 'cmp-val--bad'">
                            {{ p.quantity > 0 ? `${p.quantity} قطعة` : 'نفذت الكمية' }}
                        </div>
                    </div>

                    <div class="cmp-row">
                        <div class="cmp-label">الوزن</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val">
                            {{ p.weight ? `${p.weight} كجم` : '—' }}
                        </div>
                    </div>

                    <!-- Section: Colors -->
                    <div class="cmp-section-title">الألوان</div>
                    <div class="cmp-row">
                        <div class="cmp-label">الألوان المتاحة</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val">
                            <div v-if="p.colors?.length" class="cmp-colors">
                                <span
                                    v-for="c in p.colors"
                                    :key="c.color_code"
                                    class="cmp-color-dot"
                                    :style="{ background: c.color_code }"
                                    :title="c.name"
                                />
                            </div>
                            <span v-else>—</span>
                        </div>
                    </div>

                    <!-- Section: Features -->
                    <template v-if="allFeatureNames.length">
                        <div class="cmp-section-title">المميزات</div>
                        <div v-for="fname in allFeatureNames" :key="fname" class="cmp-row">
                            <div class="cmp-label">{{ fname }}</div>
                            <div v-for="p in products" :key="p.id" class="cmp-val">
                                {{ getFeature(p, fname) || '—' }}
                            </div>
                        </div>
                    </template>

                    <!-- Section: Description -->
                    <div class="cmp-section-title">الوصف</div>
                    <div class="cmp-row cmp-row--desc">
                        <div class="cmp-label">الوصف</div>
                        <div v-for="p in products" :key="p.id" class="cmp-val cmp-val--desc">
                            {{ p.description || '—' }}
                        </div>
                    </div>

                </div>

            </template>
        </div>
    </div>
</template>

<script setup>
import { computed, inject } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { useCompare } from '../composables/useCompare';

const { props } = usePage();
const products = computed(() => props.products || []);
const { clear } = useCompare();
const Emitter = inject('Emitter');

function discountPercent(p) {
    if (!p.discount_price || !p.price || p.discount_price >= p.price) return 0;
    return Math.round(((p.price - p.discount_price) / p.price) * 100);
}

// Collect all unique feature names across all products
const allFeatureNames = computed(() => {
    const names = new Set();
    products.value.forEach(p => p.features?.forEach(f => names.add(f.name)));
    return [...names];
});

function getFeature(product, name) {
    return product.features?.find(f => f.name === name)?.description;
}

function removeProduct(id) {
    const ids = products.value.filter(p => p.id !== id).map(p => p.id).join(',');
    if (!ids) { router.visit('/products'); return; }
    router.get('/compare', { ids }, { preserveState: false });
}

async function addToCart(product) {
    try {
        const { data } = await axios.post('/cart/add', { product_id: product.id, quantity: 1 });
        Emitter.emit('cart-item-added', data.items);
    } catch {}
}
</script>

<style scoped>
.cmp-page { background: #f5f6fa; min-height: 100vh; padding-bottom: 64px; }

.cmp-hero {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    padding: 36px 16px 48px;
    text-align: center;
}

.cmp-container {
    max-width: 1100px;
    margin: -16px auto 0;
    padding: 0 16px;
}

.cmp-empty {
    background: white;
    border-radius: 16px;
    padding: 64px 24px;
    text-align: center;
    border: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cmp-btn-primary {
    background: #1a237e;
    color: white;
    border-radius: 10px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}

/* Products row */
.cmp-products-row {
    display: grid;
    grid-template-columns: 160px repeat(v-bind('products.length'), 1fr);
    background: white;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 16px;
}

.cmp-label-col {
    background: #f8f9fb;
    border-left: 1px solid #e5e7eb;
}

.cmp-label-header {
    padding: 20px 16px;
    font-size: 12px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.cmp-product-col {
    padding: 20px 16px;
    text-align: center;
    border-left: 1px solid #f3f4f6;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.cmp-remove {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #fee2e2;
    color: #ef4444;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
}

.cmp-remove:hover { background: #fecaca; }

.cmp-img-wrap {
    position: relative;
    width: 100px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.cmp-img { width: 100%; height: 100%; object-fit: cover; }

.cmp-discount-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #ef4444;
    color: white;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 5px;
    border-radius: 10px;
}

.cmp-product-name {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    line-height: 1.3;
}

.cmp-product-cat {
    font-size: 10px;
    color: #3949ab;
    background: #e8eaf6;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600;
}

.cmp-product-price {
    display: flex;
    align-items: baseline;
    gap: 5px;
    justify-content: center;
}

.cmp-price-new { font-size: 17px; font-weight: 800; color: #1a237e; }
.cmp-price-old { font-size: 11px; color: #9ca3af; text-decoration: line-through; }

.cmp-product-actions {
    display: flex;
    gap: 6px;
    width: 100%;
}

.cmp-btn-cart {
    flex: 1;
    height: 32px;
    border-radius: 8px;
    border: 1.5px solid #3949ab;
    background: transparent;
    color: #3949ab;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    white-space: nowrap;
}

.cmp-btn-cart:hover:not(:disabled) { background: #1a237e; border-color: #1a237e; color: white; }
.cmp-btn-cart:disabled { opacity: 0.4; cursor: not-allowed; }

.cmp-btn-view {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.15s;
    flex-shrink: 0;
}

.cmp-btn-view:hover { border-color: #3949ab; color: #3949ab; }

/* Comparison table */
.cmp-table {
    background: white;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.cmp-section-title {
    background: #1a237e;
    color: white;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 8px 16px;
}

.cmp-row {
    display: grid;
    grid-template-columns: 160px repeat(v-bind('products.length'), 1fr);
    border-bottom: 1px solid #f3f4f6;
}

.cmp-row:last-child { border-bottom: none; }

.cmp-label {
    padding: 14px 16px;
    font-size: 12px;
    font-weight: 700;
    color: #6b7280;
    background: #f8f9fb;
    border-left: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
}

.cmp-val {
    padding: 14px 16px;
    font-size: 13px;
    color: #374151;
    border-left: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.cmp-val--good { color: #16a34a; font-weight: 700; }
.cmp-val--bad  { color: #ef4444; font-weight: 700; }

.cmp-val--desc {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.6;
    text-align: right;
    align-items: flex-start;
}

.cmp-row--desc .cmp-label { align-items: flex-start; padding-top: 16px; }

.cmp-colors { display: flex; gap: 4px; flex-wrap: wrap; justify-content: center; }

.cmp-color-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 1.5px solid rgba(0,0,0,0.1);
    display: inline-block;
}

@media (max-width: 768px) {
    .cmp-products-row,
    .cmp-row {
        grid-template-columns: 100px repeat(v-bind('products.length'), 1fr);
    }
    .cmp-label { font-size: 11px; padding: 10px 8px; }
    .cmp-val { padding: 10px 8px; font-size: 12px; }
    .cmp-img-wrap { width: 70px; height: 70px; }
}
</style>
