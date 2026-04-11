<template>
    <div class="pd-page">
        <SeoHead
            :title="product.name"
            :description="product.description"
            :image="product.image_url"
        />

        <!-- Breadcrumb -->
        <div class="pd-breadcrumb">
            <v-container>
                <div class="d-flex align-center" style="gap:6px; font-size:13px; color:#6b7280">
                    <a href="/" class="text-decoration-none text-grey-darken-1">{{ t('home') }}</a>
                    <v-icon size="14" color="grey">mdi-chevron-left</v-icon>
                    <a href="/products" class="text-decoration-none text-grey-darken-1">{{ t('products') }}</a>
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
                            <span class="text-grey" style="font-size:12px">4.5 (24 {{ t('quickview_rating') }})</span>
                            <v-divider vertical class="mx-1" style="height:14px" />
                            <span :class="product.quantity > 0 ? 'text-green' : 'text-red'" style="font-size:12px; font-weight:600">
                                <v-icon size="12">mdi-circle-small</v-icon>
                                {{ product.quantity > 0 ? t('in_stock') : t('not_available') }}
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="pd-price-block">
                            <template v-if="product.discount_price && product.discount_price < product.price">
                                <span class="pd-price-new">${{ Math.ceil(product.discount_price) }}</span>
                                <span class="pd-price-old">${{ product.price }}</span>
                                <v-chip color="red" size="x-small" variant="flat" class="ms-2">{{ t('save') }} ${{ Math.ceil(product.price - product.discount_price) }}</v-chip>
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
                                <span class="pd-meta-label">{{ t('brand') }}</span>
                                <span class="pd-meta-value">{{ pick(product.parent, 'name') }}</span>
                            </div>
                            <div class="pd-meta-row">
                                <span class="pd-meta-label">{{ t('available_qty') }}</span>
                                <span class="pd-meta-value">{{ product.quantity }} {{ t('pieces') }}</span>
                            </div>
                        </div>

                        <v-divider class="my-4" />

                        <!-- Quantity selector -->
                        <div class="d-flex align-center mb-5" style="gap:16px">
                            <span class="pd-meta-label">{{ t('quantity') }}</span>
                            <div class="pd-qty">
                                <button @click="quantity > 1 ? quantity-- : null"><v-icon size="16">mdi-minus</v-icon></button>
                                <span>{{ quantity }}</span>
                                <button @click="quantity < product.quantity ? quantity++ : null"><v-icon size="16">mdi-plus</v-icon></button>
                            </div>
                            <span class="text-grey-darken-1" style="font-size:13px">{{ t('subtotal') }}: <strong class="text-primary">${{ subtotal }}</strong></span>
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
                            prepend-icon="mdi-cart-plus" @click="addToCart">{{ t('add_to_cart') }}</v-btn>
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

                        <div class="pd-badges">
                            <div class="pd-badge-item"><v-icon size="18" color="primary">mdi-truck-fast-outline</v-icon><span>{{ t('fast_shipping') }}</span></div>
                            <div class="pd-badge-item"><v-icon size="18" color="primary">mdi-shield-check-outline</v-icon><span>{{ t('secure_payment') }}</span></div>
                            <div class="pd-badge-item"><v-icon size="18" color="primary">mdi-refresh</v-icon><span>{{ t('free_returns') }}</span></div>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <!-- Features section -->
            <div v-if="product.features?.length" class="pd-features mt-10">
                <h3 class="pd-section-title">{{ t('product_specs') }}</h3>
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

        <!-- Reviews Section -->
        <v-container class="pb-6">
            <div class="reviews-section">
                <div class="d-flex align-center justify-space-between mb-4">
                    <h3 class="font-weight-bold" style="font-size:18px">
                        {{ t('reviews_title') }}
                        <span v-if="reviewsCount" class="text-grey-darken-1 font-weight-regular" style="font-size:14px">({{ reviewsCount }})</span>
                    </h3>
                    <div v-if="reviewsAvg" class="d-flex align-center gap-2">
                        <v-rating :model-value="reviewsAvg" half-increments readonly color="amber" density="compact" size="small" />
                        <span class="font-weight-bold" style="font-size:15px">{{ reviewsAvg?.toFixed(1) }}</span>
                    </div>
                </div>

                <!-- Write review (logged in only) -->
                <div v-if="user" class="review-form mb-5">
                    <div class="font-weight-bold mb-2" style="font-size:14px">{{ t('write_review') }}</div>
                    <div class="d-flex align-center gap-2 mb-3">
                        <v-rating v-model="newRate" color="amber" density="compact" size="small" hover />
                        <span class="text-grey" style="font-size:12px">{{ rateLabels[newRate - 1] || t('choose_rating') }}</span>
                    </div>
                    <v-textarea v-model="newComment" :placeholder="t('review_placeholder')" variant="outlined" density="compact" rounded="lg" rows="3" hide-details="auto" bg-color="grey-lighten-5" class="mb-3" :error-messages="reviewError" />
                    <v-btn color="primary" rounded="lg" style="text-transform:none" :loading="submittingReview" :disabled="!newRate || !newComment" @click="submitReview">{{ t('submit_review') }}</v-btn>
                </div>
                <div v-else class="review-login-prompt">
                    <v-icon size="18" color="grey" class="me-2">mdi-account-outline</v-icon>
                    <a href="/login" class="text-primary text-decoration-none font-weight-bold">{{ t('login_to_review') }}</a>
                    {{ t('to_write_review') }}
                </div>

                <!-- Reviews list -->
                <div v-if="reviews.length" class="reviews-list">
                    <div v-for="r in reviews" :key="r.id" class="review-item">
                        <div class="d-flex align-center gap-3 mb-2">
                            <div class="review-avatar">{{ r.user_name?.charAt(0) }}</div>
                            <div>
                                <div class="font-weight-bold" style="font-size:13px">{{ r.user_name }}</div>
                                <div class="text-grey" style="font-size:11px">{{ r.created_at }}</div>
                            </div>
                            <v-rating :model-value="r.rate" readonly color="amber" density="compact" size="x-small" class="ms-auto" />
                        </div>
                        <p style="font-size:13px; color:#374151; line-height:1.7; margin:0">{{ r.comment }}</p>
                    </div>
                </div>
                <div v-else-if="!loadingReviews" class="text-center py-6 text-grey" style="font-size:13px">{{ t('no_reviews') }}</div>
            </div>
        </v-container>

        <!-- Recently Viewed -->
        <v-container v-if="recentlyViewed.length" class="pb-10">
            <div class="d-flex align-center justify-space-between mb-4">
                <h3 class="font-weight-bold" style="font-size:18px">{{ t('recently_viewed') }}</h3>
                <a href="/products" class="text-primary text-decoration-none" style="font-size:13px">{{ t('view_all') }}</a>
            </div>
            <v-row>
                <v-col
                    v-for="item in recentlyViewed"
                    :key="item.id"
                    cols="6" sm="4" md="3" lg="2"
                >
                    <ProductCard :item="item" @quick-view="p => Emitter.emit('openQuickView', p)" />
                </v-col>
            </v-row>
        </v-container>

        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
            {{ snackbarMessage }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { useRecentlyViewed } from '../../composables/useRecentlyViewed';
import { useLocale } from '../../composables/useLocale';
import ProductCard from '../../components/Shared/ProductCard.vue';
import SeoHead from '../../components/Shared/SeoHead.vue';

const { props } = usePage();
const product = props.product;
const Emitter = inject('Emitter');
const { add: addToRecent, getExcluding } = useRecentlyViewed();
const { t, pick } = useLocale();

const activeImage = ref(product.image_url);
const quantity    = ref(1);
const wished      = ref(false);
const btnLoading  = ref(false);
const snackbar    = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');
const recentlyViewed  = ref([]);

onMounted(() => {
    // Track this product as viewed
    addToRecent(product);
    // Load recently viewed (excluding current)
    recentlyViewed.value = getExcluding(product.id);
    // Load reviews
    loadReviews();
});

// Reviews
const reviews        = ref([]);
const reviewsAvg     = ref(0);
const reviewsCount   = ref(0);
const loadingReviews = ref(false);
const newRate        = ref(0);
const newComment     = ref('');
const submittingReview = ref(false);
const reviewError    = ref('');
const user = usePage().props.auth?.user;
const rateLabels = computed(() => [t('rate_bad'), t('rate_ok'), t('rate_good'), t('rate_very_good'), t('rate_excellent')]);

async function loadReviews() {
    loadingReviews.value = true;
    try {
        const { data } = await axios.get(`/reviews/${product.id}`);
        reviews.value      = data.reviews;
        reviewsAvg.value   = data.avg;
        reviewsCount.value = data.count;
    } catch {}
    loadingReviews.value = false;
}

async function submitReview() {
    reviewError.value = '';
    submittingReview.value = true;
    try {
        await axios.post('/reviews', {
            product_id: product.id,
            rate:       newRate.value,
            comment:    newComment.value,
        });
        newRate.value    = 0;
        newComment.value = '';
        await loadReviews();
    } catch (e) {
        reviewError.value = e.response?.data?.message || t('error_occurred');
    } finally {
        submittingReview.value = false;
    }
}

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
        snackbarMessage.value = t('product_added_to_cart');
        snackbarColor.value = 'success';
    } catch (e) {
        snackbarMessage.value = e.response?.data?.message || t('error_occurred');
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

/* Reviews */
.reviews-section {
    background: white;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 24px;
}

.review-form {
    background: #f8f9fb;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #e5e7eb;
}

.review-login-prompt {
    display: flex;
    align-items: center;
    font-size: 13px;
    color: #6b7280;
    background: #f8f9fb;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 20px;
    border: 1px solid #e5e7eb;
}

.reviews-list { display: flex; flex-direction: column; gap: 16px; }

.review-item {
    padding: 16px;
    border: 1px solid #f3f4f6;
    border-radius: 12px;
    background: #fafafa;
}

.review-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e8eaf6;
    color: #1a237e;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
</style>
