<template>
    <div class="cmp-page">

        <!-- Hero -->
        <div class="cmp-hero">
            <div class="cmp-hero-icon">
                <v-icon size="32" color="white">mdi-compare</v-icon>
            </div>
            <h1 class="cmp-hero-title">مقارنة المنتجات</h1>
            <p class="cmp-hero-sub">{{ products.length }} منتجات للمقارنة</p>
        </div>

        <div class="cmp-container">

            <!-- Empty -->
            <div v-if="!products.length" class="cmp-empty">
                <v-icon size="72" color="grey-lighten-1">mdi-compare-remove</v-icon>
                <p class="mt-3 font-weight-bold" style="font-size:16px; color:#374151">لا توجد منتجات للمقارنة</p>
                <a href="/products" class="cmp-btn-go mt-4">تصفح المنتجات</a>
            </div>

            <template v-else>

                <!-- ═══════════════════════════════════════════
                     DESKTOP TABLE (≥769px)
                ════════════════════════════════════════════ -->
                <div class="cmp-desktop">
                    <div class="cmp-scroll-wrap">

                        <!-- Column headers -->
                        <div class="cmp-header-row">
                            <div class="cmp-col-name cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-package-variant</v-icon>
                                المنتج
                            </div>
                            <div class="cmp-col-img cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-image-outline</v-icon>
                                الصورة
                            </div>
                            <div class="cmp-col-data cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-shape-outline</v-icon>
                                القسم
                            </div>
                            <div class="cmp-col-data cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-palette-outline</v-icon>
                                الألوان
                            </div>
                            <div v-for="col in columns" :key="col.key" class="cmp-col-data cmp-hdr-cell">
                                <v-icon size="14" class="me-1">{{ col.icon }}</v-icon>
                                {{ col.label }}
                            </div>
                            <div class="cmp-col-price cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-cash</v-icon>
                                السعر
                            </div>
                            <div class="cmp-col-action cmp-hdr-cell">
                                <v-icon size="14" class="me-1">mdi-cart-outline</v-icon>
                                الإجراء
                            </div>
                        </div>

                        <!-- Product rows -->
                        <div
                            v-for="p in products"
                            :key="p.id"
                            class="cmp-product-row"
                            :class="{ 'cmp-product-row--best': bestValue(p) }"
                        >
                            <div v-if="bestValue(p)" class="cmp-best-badge">الأفضل قيمة</div>

                            <div class="cmp-col-name">
                                <div class="cmp-product-name">{{ p.name }}</div>
                            </div>

                            <div class="cmp-col-img">
                                <div class="cmp-img-box">
                                    <img :src="p.image_url" :alt="p.name" />
                                    <span v-if="discountPct(p)" class="cmp-img-badge">-{{ discountPct(p) }}%</span>
                                </div>
                            </div>

                            <div class="cmp-col-data">
                                <span v-if="p.parent" class="cmp-cat-pill">{{ p.parent.name }}</span>
                                <span v-else class="val-empty">—</span>
                            </div>

                            <div class="cmp-col-data">
                                <div v-if="p.colors?.length" class="cmp-colors">
                                    <span
                                        v-for="c in p.colors.slice(0,6)"
                                        :key="c.color_code"
                                        class="cmp-dot"
                                        :style="{ background: c.color_code }"
                                        :title="c.name"
                                    />
                                </div>
                                <span v-else class="val-empty">—</span>
                            </div>

                            <div v-for="col in columns" :key="col.key" class="cmp-col-data">
                                <span :class="col.class?.(p)">{{ col.get(p) }}</span>
                            </div>

                            <div class="cmp-col-price">
                                <div class="cmp-price-new">${{ Math.ceil(p.discount_price || p.price) }}</div>
                                <div v-if="p.discount_price && p.discount_price < p.price" class="cmp-price-old">
                                    ${{ p.price }}
                                </div>
                            </div>

                            <div class="cmp-col-action">
                                <button class="cmp-btn-icon cmp-btn-cart-icon" :disabled="p.quantity < 1" @click="addToCart(p)" title="أضف للسلة">
                                    <v-icon size="16">mdi-cart-plus</v-icon>
                                </button>
                                <a :href="`/products/${p.slug}`" class="cmp-btn-icon cmp-btn-view" title="عرض المنتج">
                                    <v-icon size="15">mdi-eye-outline</v-icon>
                                </a>
                                <button class="cmp-btn-icon cmp-btn-remove" @click="removeProduct(p.id)" title="إزالة">
                                    <v-icon size="14">mdi-close</v-icon>
                                </button>
                            </div>
                        </div>

                    </div><!-- end cmp-scroll-wrap -->

                    <!-- Features table -->
                    <template v-if="allFeatureNames.length">
                        <div class="cmp-features-title">المميزات التفصيلية</div>
                        <div class="cmp-features-table">
                            <div class="cmp-ft-header">
                                <div class="cmp-ft-label">الميزة</div>
                                <div v-for="p in products" :key="p.id" class="cmp-ft-val cmp-ft-val--head">{{ p.name }}</div>
                            </div>
                            <div v-for="fname in allFeatureNames" :key="fname" class="cmp-ft-row">
                                <div class="cmp-ft-label">{{ fname }}</div>
                                <div v-for="p in products" :key="p.id" class="cmp-ft-val">{{ getFeature(p, fname) || '—' }}</div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- ═══════════════════════════════════════════
                     MOBILE CARDS (≤768px)
                ════════════════════════════════════════════ -->
                <div class="cmp-mobile">
                    <div
                        v-for="p in products"
                        :key="p.id"
                        class="cmp-card"
                        :class="{ 'cmp-card--best': bestValue(p) }"
                    >
                        <!-- Best value ribbon -->
                        <div v-if="bestValue(p)" class="cmp-card-ribbon">
                            <v-icon size="11" class="me-1">mdi-star</v-icon>
                            الأفضل قيمة
                        </div>

                        <!-- Card top: image + name + category + colors -->
                        <div class="cmp-card-top">
                            <div class="cmp-card-img-wrap">
                                <img :src="p.image_url" :alt="p.name" class="cmp-card-img" />
                                <span v-if="discountPct(p)" class="cmp-card-discount-badge">-{{ discountPct(p) }}%</span>
                            </div>
                            <div class="cmp-card-info">
                                <div class="cmp-card-name">{{ p.name }}</div>
                                <span v-if="p.parent" class="cmp-card-cat">
                                    <v-icon size="11" class="me-1">mdi-shape-outline</v-icon>
                                    {{ p.parent.name }}
                                </span>
                                <div v-if="p.colors?.length" class="cmp-card-colors">
                                    <span
                                        v-for="c in p.colors.slice(0,8)"
                                        :key="c.color_code"
                                        class="cmp-dot"
                                        :style="{ background: c.color_code }"
                                        :title="c.name"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Specs rows -->
                        <div class="cmp-card-specs">
                            <div class="cmp-spec-row" v-for="col in columns" :key="col.key">
                                <div class="cmp-spec-label">
                                    <v-icon size="13" class="me-1">{{ col.icon }}</v-icon>
                                    {{ col.label }}
                                </div>
                                <div class="cmp-spec-val" :class="col.class?.(p)">{{ col.get(p) }}</div>
                            </div>

                            <!-- Features -->
                            <template v-if="p.features?.length">
                                <div class="cmp-spec-row" v-for="f in p.features" :key="f.name">
                                    <div class="cmp-spec-label">
                                        <v-icon size="13" class="me-1">mdi-check-circle-outline</v-icon>
                                        {{ f.name }}
                                    </div>
                                    <div class="cmp-spec-val">{{ f.description || '—' }}</div>
                                </div>
                            </template>
                        </div>

                        <!-- Price + actions -->
                        <div class="cmp-card-footer">
                            <div class="cmp-card-price">
                                <span class="cmp-price-new">${{ Math.ceil(p.discount_price || p.price) }}</span>
                                <span v-if="p.discount_price && p.discount_price < p.price" class="cmp-price-old">${{ p.price }}</span>
                            </div>
                            <div class="cmp-card-actions">
                                <button class="cmp-card-btn cmp-card-btn-cart" :disabled="p.quantity < 1" @click="addToCart(p)">
                                    <v-icon size="15" class="me-1">mdi-cart-plus</v-icon>
                                    {{ p.quantity < 1 ? 'نفذت' : 'أضف للسلة' }}
                                </button>
                                <a :href="`/products/${p.slug}`" class="cmp-card-btn cmp-card-btn-view">
                                    <v-icon size="15">mdi-eye-outline</v-icon>
                                </a>
                                <button class="cmp-card-btn cmp-card-btn-remove" @click="removeProduct(p.id)">
                                    <v-icon size="15">mdi-close</v-icon>
                                </button>
                            </div>
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

const { props } = usePage();
const products = computed(() => props.products || []);
const Emitter = inject('Emitter');

function discountPct(p) {
    if (!p.discount_price || p.discount_price >= p.price) return 0;
    return Math.round(((p.price - p.discount_price) / p.price) * 100);
}

function bestValue(p) {
    if (products.value.length < 2) return false;
    const eff = p.discount_price && p.discount_price < p.price ? p.discount_price : p.price;
    const min = Math.min(...products.value.map(x => x.discount_price && x.discount_price < x.price ? x.discount_price : x.price));
    return eff === min;
}

const columns = [
    {
        key: 'stock', label: 'المخزون', icon: 'mdi-package-variant-closed',
        get: p => p.quantity > 0 ? `${p.quantity} قطعة` : 'نفذت الكمية',
        class: p => p.quantity > 0 ? 'val-good' : 'val-bad',
    },
    {
        key: 'weight', label: 'الوزن', icon: 'mdi-weight-kilogram',
        get: p => p.weight ? `${p.weight} كجم` : '—',
    },
    {
        key: 'discount', label: 'الخصم', icon: 'mdi-tag-outline',
        get: p => discountPct(p) ? `-${discountPct(p)}%` : '—',
        class: p => discountPct(p) ? 'val-good' : '',
    },
];

const allFeatureNames = computed(() => {
    const s = new Set();
    products.value.forEach(p => p.features?.forEach(f => s.add(f.name)));
    return [...s];
});

function getFeature(p, name) {
    return p.features?.find(f => f.name === name)?.description;
}

function removeProduct(id) {
    const ids = products.value.filter(p => p.id !== id).map(p => p.id).join(',');
    if (!ids) { router.visit('/products'); return; }
    router.get('/compare', { ids }, { preserveState: false });
}

async function addToCart(p) {
    try {
        const { data } = await axios.post('/cart/add', { product_id: p.id, quantity: 1 });
        Emitter.emit('cart-item-added', data.items);
    } catch {}
}
</script>

<style scoped>
/* ── Base ── */
.cmp-page { background: #f0f2f8; min-height: 100vh; padding-bottom: 80px; }

/* ── Hero ── */
.cmp-hero {
    background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
    padding: 40px 16px 56px;
    text-align: center;
}
.cmp-hero-icon {
    width: 60px; height: 60px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
    backdrop-filter: blur(4px);
}
.cmp-hero-title { color: white; font-size: 24px; font-weight: 800; margin: 0; }
.cmp-hero-sub   { color: rgba(255,255,255,0.75); font-size: 13px; margin-top: 6px; }

/* ── Container ── */
.cmp-container { max-width: 1100px; margin: -20px auto 0; padding: 0 16px; }

/* ── Empty ── */
.cmp-empty {
    background: white; border-radius: 20px; padding: 64px 24px;
    text-align: center; display: flex; flex-direction: column;
    align-items: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
.cmp-btn-go {
    background: #1a237e; color: white; border-radius: 10px;
    padding: 10px 24px; font-size: 14px; font-weight: 600;
    text-decoration: none; display: inline-block;
}

/* ══════════════════════════════════════
   DESKTOP
══════════════════════════════════════ */
.cmp-desktop { display: block; }
.cmp-mobile  { display: none; }

.cmp-scroll-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 4px;
}

.cmp-header-row {
    display: flex; align-items: center;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(26,35,126,0.25);
    min-width: 700px;
}

.cmp-hdr-cell {
    display: flex; align-items: center; justify-content: center;
    padding: 14px 10px; font-size: 12px; font-weight: 700;
    color: #ffffff; letter-spacing: 0.3px;
    border-left: 1px solid rgba(255,255,255,0.15);
    gap: 4px; white-space: nowrap;
}
.cmp-hdr-cell:first-child { justify-content: flex-start; padding-right: 16px; border-left: none; }

.cmp-col-name   { flex: 2; text-align: right !important; padding-right: 8px; }
.cmp-col-img    { width: 90px; flex-shrink: 0; }
.cmp-col-data   { flex: 1; }
.cmp-col-price  { width: 90px; flex-shrink: 0; }
.cmp-col-action { width: 110px; flex-shrink: 0; }

.cmp-product-row {
    background: white; border-radius: 16px; border: 2px solid #e5e7eb;
    padding: 18px 20px; margin-bottom: 12px;
    display: flex; align-items: center;
    position: relative; transition: border-color 0.2s, box-shadow 0.2s;
    min-width: 700px;
}
.cmp-product-row:hover { box-shadow: 0 6px 24px rgba(26,35,126,0.08); border-color: #c5cae9; }
.cmp-product-row--best { border-color: #1a237e; box-shadow: 0 6px 24px rgba(26,35,126,0.12); }

.cmp-best-badge {
    position: absolute; top: -1px; right: 20px;
    background: #1a237e; color: white;
    font-size: 10px; font-weight: 700;
    padding: 3px 10px; border-radius: 0 0 8px 8px;
}

.cmp-product-name { font-size: 14px; font-weight: 700; color: #111827; line-height: 1.3; }

.cmp-colors { display: flex; gap: 4px; flex-wrap: wrap; justify-content: center; }
.cmp-dot {
    width: 14px; height: 14px; border-radius: 50%;
    border: 1.5px solid rgba(0,0,0,0.1); display: inline-block;
}

.cmp-cat-pill {
    font-size: 10px; font-weight: 700; color: #3949ab;
    background: #e8eaf6; padding: 3px 8px; border-radius: 20px; white-space: nowrap;
}

.val-empty { color: #d1d5db; font-size: 16px; }

.cmp-img-box {
    position: relative; width: 70px; height: 70px;
    border-radius: 10px; overflow: hidden;
    border: 1px solid #e5e7eb; margin: 0 auto;
}
.cmp-img-box img { width: 100%; height: 100%; object-fit: cover; }
.cmp-img-badge {
    position: absolute; top: 3px; right: 3px;
    background: #ef4444; color: white;
    font-size: 8px; font-weight: 700;
    padding: 1px 4px; border-radius: 8px;
}

.cmp-col-data { text-align: center; font-size: 13px; color: #e5e7eb; }
.val-good { color: #16a34a; font-weight: 700; }
.val-bad  { color: #ef4444; font-weight: 700; }

.cmp-col-price { text-align: center; }
.cmp-price-new { font-size: 16px; font-weight: 800; color: #1a237e; }
.cmp-price-old { font-size: 11px; color: #9ca3af; text-decoration: line-through; }

.cmp-col-action { display: flex; gap: 6px; align-items: center; justify-content: center; }

.cmp-btn-icon {
    width: 34px; height: 34px; border-radius: 9px;
    border: 1.5px solid #e5e7eb; background: white;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.15s; flex-shrink: 0; text-decoration: none;
}
.cmp-btn-cart-icon { border-color: #3949ab; color: #1a237e; background: #f0f2ff; }
.cmp-btn-cart-icon:hover:not(:disabled) { background: #1a237e; color: white; border-color: #1a237e; }
.cmp-btn-cart-icon:disabled { opacity: 0.4; cursor: not-allowed; }
.cmp-btn-view { color: #6b7280; }
.cmp-btn-view:hover { border-color: #3949ab; color: #3949ab; background: #f0f2ff; }
.cmp-btn-remove { background: #fff5f5; color: #ef4444; border-color: #fecaca; }
.cmp-btn-remove:hover { background: #fee2e2; border-color: #ef4444; }

/* Features table */
.cmp-features-title { font-size: 14px; font-weight: 700; color: #374151; margin: 24px 0 10px; padding-right: 4px; }
.cmp-features-table { background: white; border-radius: 16px; border: 1px solid #e5e7eb; overflow: hidden; }
.cmp-ft-header, .cmp-ft-row {
    display: grid;
    grid-template-columns: 160px repeat(v-bind('products.length'), 1fr);
    border-bottom: 1px solid #f3f4f6;
}
.cmp-ft-row:last-child { border-bottom: none; }
.cmp-ft-label { padding: 12px 16px; font-size: 12px; font-weight: 700; color: #6b7280; background: #f8f9fb; border-left: 1px solid #e5e7eb; }
.cmp-ft-val { padding: 12px 16px; font-size: 12px; color: #374151; border-left: 1px solid #f3f4f6; text-align: center; }
.cmp-ft-val--head { font-weight: 700; color: #1a237e; background: #f0f2ff; font-size: 11px; }

/* ══════════════════════════════════════
   MOBILE CARDS
══════════════════════════════════════ */
@media (max-width: 768px) {
    .cmp-desktop { display: none; }
    .cmp-mobile  { display: flex; flex-direction: column; gap: 16px; }
    .cmp-container { padding: 0 12px; }

    .cmp-card {
        background: white;
        border-radius: 18px;
        border: 2px solid #e5e7eb;
        overflow: hidden;
        position: relative;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s;
    }
    .cmp-card--best { border-color: #1a237e; box-shadow: 0 4px 20px rgba(26,35,126,0.14); }

    /* Ribbon */
    .cmp-card-ribbon {
        background: linear-gradient(90deg, #1a237e, #3949ab);
        color: white; font-size: 11px; font-weight: 700;
        padding: 5px 14px;
        display: flex; align-items: center;
        letter-spacing: 0.3px;
    }

    /* Top section: image + name/cat/colors */
    .cmp-card-top {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 16px 16px 12px;
        border-bottom: 1px solid #f3f4f6;
    }
    .cmp-card-img-wrap {
        position: relative; flex-shrink: 0;
        width: 90px; height: 90px;
        border-radius: 12px; overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .cmp-card-img { width: 100%; height: 100%; object-fit: cover; }
    .cmp-card-discount-badge {
        position: absolute; top: 4px; right: 4px;
        background: #ef4444; color: white;
        font-size: 9px; font-weight: 700;
        padding: 2px 5px; border-radius: 6px;
    }
    .cmp-card-info { flex: 1; min-width: 0; }
    .cmp-card-name {
        font-size: 15px; font-weight: 800; color: #111827;
        line-height: 1.3; margin-bottom: 6px;
    }
    .cmp-card-cat {
        display: inline-flex; align-items: center;
        font-size: 11px; font-weight: 700; color: #3949ab;
        background: #e8eaf6; padding: 3px 9px; border-radius: 20px;
        margin-bottom: 8px;
    }
    .cmp-card-colors { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 4px; }

    /* Specs */
    .cmp-card-specs { padding: 0 16px; }
    .cmp-spec-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
        gap: 8px;
    }
    .cmp-spec-row:last-child { border-bottom: none; }
    .cmp-spec-label {
        display: flex; align-items: center;
        font-size: 12px; font-weight: 600; color: #6b7280;
        flex-shrink: 0; gap: 2px;
    }
    .cmp-spec-val {
        font-size: 13px; font-weight: 700; color: #111827;
        text-align: left;
    }

    /* Footer */
    .cmp-card-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 16px;
        background: #f8f9fb;
        border-top: 1px solid #e5e7eb;
        gap: 10px;
    }
    .cmp-card-price { display: flex; align-items: baseline; gap: 6px; }
    .cmp-card-actions { display: flex; gap: 8px; align-items: center; }

    .cmp-card-btn {
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; border: 1.5px solid #e5e7eb;
        background: white; cursor: pointer;
        font-size: 12px; font-weight: 700;
        padding: 8px 12px; gap: 4px;
        text-decoration: none; transition: all 0.15s;
        white-space: nowrap;
    }
    .cmp-card-btn-cart {
        background: #1a237e; color: white; border-color: #1a237e; flex: 1;
    }
    .cmp-card-btn-cart:disabled { opacity: 0.45; cursor: not-allowed; }
    .cmp-card-btn-cart:not(:disabled):hover { background: #283593; }
    .cmp-card-btn-view { color: #3949ab; border-color: #c5cae9; width: 38px; padding: 8px; }
    .cmp-card-btn-view:hover { background: #e8eaf6; }
    .cmp-card-btn-remove { color: #ef4444; border-color: #fecaca; background: #fff5f5; width: 38px; padding: 8px; }
    .cmp-card-btn-remove:hover { background: #fee2e2; }
}
</style>
