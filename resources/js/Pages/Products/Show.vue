<template>
    <div class="pd-page">

        <!-- Breadcrumb -->
        <div class="pd-breadcrumb">
            <v-container>
                <div class="d-flex align-center" style="gap:6px; font-size:13px; color:#6b7280">
                    <a href="/" class="text-decoration-none text-grey-darken-1">الرئيسية</a>
                    <v-icon size="14" color="grey">mdi-chevron-left</v-icon>
                    <a href="/products" class="text-decoration-none text-grey-darken-1">المنتجات</a>
                    <v-icon size="14" color="grey">mdi-chevron-left</v-icon>
                    <span class="text-primary font-weight-medium">{{ product.name }}</span>
                </div>
            </v-container>
        </div>

        <v-container class="py-8">
            <v-row>

                <!-- ===== Left: Image Gallery ===== -->
                <v-col cols="12" md="6">
                    <div class="pd-gallery">

                        <!-- Main image -->
                        <div class="pd-main-img">
                            <img :src="activeImage || product.image_url" :alt="product.name" />

                            <!-- Discount badge -->
                            <div v-if="discountPercent" class="pd-discount-badge">
                                -{{ discountPercent }}%
                            </div>

                            <!-- Wishlist btn -->
                            <v-btn
                                icon
                                size="small"
                                variant="flat"
                                class="pd-wish-btn"
                                :color="wished ? 'red' : 'white'"
                                @click="wished = !wished"
                            >
                                <v-icon :color="wished ? 'white' : 'grey-darken-2'" size="18">
                                    {{ wished ? 'mdi-heart' : 'mdi-heart-outline' }}
                                </v-icon>
                            </v-btn>
                        </div>

                        <!-- Thumbnails -->
                        <div v-if="product.images?.length" class="pd-thumbs">
                            <div
                                v-for="(img, i) in product.images"
                                :key="i"
                                class="pd-thumb"
                                :class="{ 'pd-thumb--active': activeImage === img.image_url }"
                                @click="activeImage = img.image_url"
                            >
                                <img :src="img.image_url" alt="thumb" />
                            </div>
                        </div>
                    </div>
                </v-col>

                <!-- ===== Right: Product Info ===== -->
                <v-col cols="12" md="6">
                    <div class="pd-info">

                        <!-- Category tag -->
                        <div v-if="product.parent" class="pd-tag">
                            {{ product.parent.name_en || product.parent.name }}
                        </div>

                        <!-- Name -->
                        <h1 class="pd-name">{{ product.name }}</h1>

                        <!-- Rating row -->
                        <div class="d-flex align-center mb-4" style="gap:10px">
                            <v-rating :model-value="4.5" half-increments readonly color="amber" density="compact" size="small" />
                            <span class="text-grey" style="font-size:12px">4.5 (24 تقييم)</span>
                            <v-divider vertical class="mx-1" style="height:14px" />
                            <span :class="product.quantity > 0 ? 'text-green' : 'text-red'" style="font-size:12px; font-weight:600">
                                <v-icon size="12">mdi-circle-small</v-icon>
                                {{ product.quantity > 0 ? 'متوفر' : 'غير متوفر' }}
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="pd-price-block">
                            <template v-if="product.discount_price && product.discount_price < product.price">
                                <span class="pd-price-new">${{ Math.ceil(product.discount_price) }}</span>
                                <span class="pd-price-old">${{ product.price }}</span>
                                <v-chip color="red" size="x-small" variant="flat" class="ms-2">
                                    وفّر ${{ Math.ceil(product.price - product.discount_price) }}
                                </v-chip>
                            </template>
                            <template v-else>
                                <span class="pd-price-new">${{ Math.ceil(product.price) }}</span>
                            </template>
                        </div>

                        <v-divider class="my-4" />

                        <!-- Description -->
                        <p v-if="product.description" class="pd-desc">
                            {{ product.description }}
                        </p>

                        <!-- Meta info -->
                        <div class="pd-meta">
                            <div class="pd-meta-row" v-if="product.parent">
                                <span class="pd-meta-label">الماركة</span>
                                <span class="pd-meta-value">{{ product.parent.name }}</span>
                            </div>
                            <div class="pd-meta-row">
                                <span class="pd-meta-label">الكمية المتاحة</span>
                                <span class="pd-meta-value">{{ product.quantity }} قطعة</span>
                            </div>
                        </div>

                        <v-divider class="my-4" />

                        <!-- Quantity selector -->
                        <div class="d-flex align-center mb-5" style="gap:16px">
                            <span class="pd-meta-label">الكمية</span>
                            <div class="pd-qty">
                                <button @click="quantity > 1 ? quantity-- : null">
                                    <v-icon size="16">mdi-minus</v-icon>
                                </button>
                                <span>{{ quantity }}</span>
                                <button @click="quantity < product.quantity ? quantity++ : null">
                                    <v-icon size="16">mdi-plus</v-icon>
                                </button>
                            </div>
                            <span class="text-grey-darken-1" style="font-size:13px">
                                الإجمالي: <strong class="text-primary">${{ subtotal }}</strong>
                            </span>
                        </div>

                        <!-- Action buttons -->
                        <div class="d-flex" style="gap:12px">
                            <v-btn
                                color="primary"
                                rounded="lg"
                                height="50"
                                style="flex:1; text-transform:none; font-size:15px; font-weight:600"
                                :loading="btnLoading"
                                :disabled="product.quantity < 1"
                                prepend-icon="mdi-cart-plus"
                                @click="addToCart"
                            >
                                أضف للسلة
                            </v-btn>
                            <v-btn
                                variant="outlined"
                                color="primary"
                                rounded="lg"
                                height="50"
                                icon
                                @click="wished = !wished"
                            >
                                <v-icon :color="wished ? 'red' : 'primary'">
                                    {{ wished ? 'mdi-heart' : 'mdi-heart-outline' }}
                                </v-icon>
                            </v-btn>
                        </div>

                        <!-- Trust badges -->
                        <div class="pd-badges">
                            <div class="pd-badge-item">
                                <v-icon size="18" color="primary">mdi-truck-fast-outline</v-icon>
                                <span>شحن سريع</span>
                            </div>
                            <div class="pd-badge-item">
                                <v-icon size="18" color="primary">mdi-shield-check-outline</v-icon>
                                <span>دفع آمن</span>
                            </div>
                            <div class="pd-badge-item">
                                <v-icon size="18" color="primary">mdi-refresh</v-icon>
                                <span>إرجاع مجاني</span>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <!-- Features section -->
            <div v-if="product.features?.length" class="pd-features mt-10">
                <h3 class="pd-section-title">مواصفات المنتج</h3>
                <v-row class="mt-3">
                    <v-col v-for="f in product.features" :key="f.id" cols="12" sm="6" md="4">
                        <div class="pd-feature-card">
                            <v-icon color="primary" size="20" class="me-2">mdi-check-circle-outline</v-icon>
                            <div>
                                <div class="font-weight-bold" style="font-size:13px">{{ f.feature_name }}</div>
                                <div class="text-grey" style="font-size:12px">{{ f.feature_description }}</div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </v-container>

        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
            {{ snackbarMessage }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, computed, inject } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const { props } = usePage();
const product = props.product;
const Emitter = inject('Emitter');

const activeImage = ref(product.image_url);
const quantity    = ref(1);
const wished      = ref(false);
const btnLoading  = ref(false);
const snackbar    = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');

const discountPercent = computed(() => {
    if (!product.discount_price || !product.price) return 0;
    return Math.round(((product.price - product.discount_price) / product.price) * 100);
});

const effectivePrice = computed(() =>
    product.discount_price && product.discount_price < product.price
        ? product.discount_price : product.price
);

const subtotal = computed(() => Math.ceil(effectivePrice.value) * quantity.value);

async function addToCart() {
    btnLoading.value = true;
    try {
        const { data } = await axios.post('/cart/add', { product_id: product.id, quantity: quantity.value });
        Emitter.emit('cart-item-added', data.items);
        snackbarMessage.value = 'تم إضافة المنتج للسلة';
        snackbarColor.value = 'success';
    } catch (e) {
        snackbarMessage.value = e.response?.data?.message || 'حدث خطأ';
        snackbarColor.value = 'error';
    } finally {
        btnLoading.value = false;
        snackbar.value = true;
    }
}
</script>

<style scoped>
.pd-page { background: #f9fafb; min-height: 100vh; }

.pd-breadcrumb {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    padding: 10px 0;
}

/* Gallery */
.pd-gallery { display: flex; flex-direction: column; gap: 16px; }

.pd-main-img {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 380px;
    padding: 24px;
}

.pd-main-img img {
    max-height: 340px;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
}

.pd-main-img:hover img { transform: scale(1.05); }

.pd-discount-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    background: #ef4444;
    color: white;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.pd-wish-btn {
    position: absolute !important;
    top: 14px;
    left: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12) !important;
}

.pd-thumbs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.pd-thumb {
    width: 68px;
    height: 68px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    overflow: hidden;
    cursor: pointer;
    background: white;
    transition: border-color 0.15s, transform 0.15s;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
}

.pd-thumb:hover { transform: translateY(-2px); }
.pd-thumb--active { border-color: #3949ab; }

.pd-thumb img { width: 100%; height: 100%; object-fit: contain; }

/* Info panel */
.pd-info { padding: 8px 0; }

.pd-tag {
    display: inline-block;
    background: #e8eaf6;
    color: #3949ab;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 10px;
}

.pd-name {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    line-height: 1.3;
    margin-bottom: 12px;
}

.pd-price-block {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 4px;
}

.pd-price-new { font-size: 28px; font-weight: 800; color: #1a237e; }
.pd-price-old { font-size: 16px; color: #9ca3af; text-decoration: line-through; }

.pd-desc {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.8;
    margin-bottom: 16px;
}

.pd-meta { display: flex; flex-direction: column; gap: 8px; }

.pd-meta-row { display: flex; align-items: center; gap: 8px; font-size: 13px; }
.pd-meta-label { color: #9ca3af; min-width: 110px; }
.pd-meta-value { color: #111827; font-weight: 600; }

.pd-qty {
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 6px 14px;
    background: white;
}

.pd-qty button {
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    padding: 2px;
    border-radius: 4px;
    transition: background 0.15s;
}

.pd-qty button:hover { background: #f3f4f6; color: #111827; }
.pd-qty span { font-size: 15px; font-weight: 700; min-width: 20px; text-align: center; }

.pd-badges {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    padding: 14px 16px;
    background: #f8f9fb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    flex-wrap: wrap;
}

.pd-badge-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #374151;
    font-weight: 500;
}

/* Features */
.pd-section-title {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    padding-bottom: 10px;
    border-bottom: 2px solid #e8eaf6;
}

.pd-feature-card {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
}
</style>
