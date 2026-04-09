<template>
    <v-dialog v-model="dialog" max-width="860" :scrim="true">
        <v-card rounded="xl" elevation="0" class="qv-card" v-if="product.id">

            <!-- Close button -->
            <v-btn
                icon
                size="small"
                variant="flat"
                color="white"
                class="qv-close"
                @click="dialog = false"
            >
                <v-icon size="18">mdi-close</v-icon>
            </v-btn>

            <v-row style="min-height:480px">

                <!-- Left: images -->
                <v-col cols="12" md="5" class="qv-image-col">
                    <v-skeleton-loader v-if="loading" type="image" height="100%" />
                    <template v-else>
                        <div class="qv-main-image">
                            <img :src="activeImage || product.image_url" alt="product" />
                            <!-- Discount badge -->
                            <div v-if="product.discount_price && product.discount_price < product.price" class="qv-badge">
                                -{{ discountPercent }}%
                            </div>
                        </div>
                        <!-- Thumbnails -->
                        <div v-if="product.images?.length" class="qv-thumbs">
                            <div
                                v-for="(img, i) in product.images"
                                :key="i"
                                class="qv-thumb"
                                :class="{ 'qv-thumb--active': activeImage === img.image_url }"
                                @click="activeImage = img.image_url"
                            >
                                <img :src="img.image_url" alt="thumb" />
                            </div>
                        </div>
                    </template>
                </v-col>

                <!-- Right: details -->
                <v-col cols="12" md="7" class="qv-details-col">
                    <v-skeleton-loader v-if="loading" type="article,article" />
                    <template v-else>

                        <!-- Category -->
                        <div class="qv-category" v-if="product.parent">
                            {{ pick(product.parent, 'name') }}
                        </div>

                        <!-- Name -->
                        <h2 class="qv-name">{{ pick(product, 'name') }}</h2>

                        <!-- Rating -->
                        <div class="d-flex align-center mb-3" style="gap:8px">
                            <v-rating :model-value="4.5" half-increments readonly color="amber" density="compact" size="small" />
                            <span class="text-grey" style="font-size:12px">(24 {{ t('quickview_rating') }})</span>
                        </div>

                        <!-- Price -->
                        <div class="qv-price-row">
                            <template v-if="product.discount_price && product.discount_price < product.price">
                                <span class="qv-price-new">${{ Math.ceil(product.discount_price) }}</span>
                                <span class="qv-price-old">${{ product.price }}</span>
                            </template>
                            <template v-else>
                                <span class="qv-price-new">${{ Math.ceil(product.price) }}</span>
                            </template>
                        </div>

                        <v-divider class="my-4" />

                        <!-- Description -->
                        <p v-if="product.description" class="qv-desc">
                            {{ product.description }}
                        </p>

                        <!-- Stock -->
                        <div class="d-flex align-center mb-4" style="gap:6px">
                            <v-icon size="16" :color="product.quantity > 0 ? 'green' : 'red'">
                                mdi-circle-small
                            </v-icon>
                            <span style="font-size:13px" :class="product.quantity > 0 ? 'text-green' : 'text-red'">
                                {{ product.quantity > 0 ? t('quickview_in_stock') : t('quickview_out_of_stock') }}
                            </span>
                        </div>

                        <!-- Quantity -->
                        <div class="d-flex align-center mb-5" style="gap:12px">
                            <span style="font-size:13px; font-weight:600; color:#374151">{{ t('quickview_quantity') }}</span>
                            <div class="qv-qty">
                                <button @click="quantity > 1 ? quantity-- : null"><v-icon size="16">mdi-minus</v-icon></button>
                                <span>{{ quantity }}</span>
                                <button @click="quantity++"><v-icon size="16">mdi-plus</v-icon></button>
                            </div>
                            <span class="text-grey" style="font-size:12px">
                                {{ t('quickview_total') }}: <strong>${{ subtotal }}</strong>
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex" style="gap:10px">
                            <v-btn color="primary" rounded="lg" height="46"
                                style="flex:1; text-transform:none; font-size:14px; font-weight:600"
                                :loading="btnLoading" :disabled="product.quantity < 1"
                                prepend-icon="mdi-cart-plus" @click="addToCart">
                                {{ t('quickview_add_to_cart') }}
                            </v-btn>
                            <v-btn variant="outlined" color="primary" rounded="lg" height="46"
                                style="text-transform:none; font-size:13px"
                                :href="product.slug ? `/products/${product.slug}` : '#'">
                                {{ t('quickview_details') }}
                            </v-btn>
                        </div>

                    </template>
                </v-col>
            </v-row>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
        {{ snackbarMessage }}
    </v-snackbar>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import axios from 'axios';
import { useCartFly } from '../../composables/useCartFly';
import { useLocale } from '../../composables/useLocale';

const Emitter = inject('Emitter');
const { flyToCart } = useCartFly();
const { t, pick } = useLocale();

const dialog     = ref(false);
const loading    = ref(false);
const product    = ref({});
const activeImage = ref('');
const quantity   = ref(1);
const btnLoading = ref(false);
const snackbar   = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');

const discountPercent = computed(() => {
    if (!product.value.discount_price || !product.value.price) return 0;
    return Math.round(((product.value.price - product.value.discount_price) / product.value.price) * 100);
});

const effectivePrice = computed(() =>
    product.value.discount_price && product.value.discount_price < product.value.price
        ? product.value.discount_price
        : product.value.price
);

const subtotal = computed(() => Math.ceil((effectivePrice.value || 0) * quantity.value));

async function addToCart() {
    btnLoading.value = true;
    try {
        const { data } = await axios.post('/cart/add', {
            product_id: product.value.id,
            quantity: quantity.value,
        });
        Emitter.emit('cart-item-added', data.items);
        flyToCart(document.querySelector('.v-dialog .qv-main-img'));
        snackbarMessage.value = 'تم إضافة المنتج للسلة';
        snackbarColor.value = 'success';
        dialog.value = false;
    } catch (e) {
        snackbarMessage.value = e.response?.data?.message || 'حدث خطأ';
        snackbarColor.value = 'error';
    } finally {
        btnLoading.value = false;
        snackbar.value = true;
    }
}

onMounted(() => {
    Emitter.on('openQuickView', (data) => {
        product.value = data;
        activeImage.value = data.image_url || '';
        quantity.value = 1;
        loading.value = true;
        dialog.value = true;
        setTimeout(() => { loading.value = false; }, 600);
    });
});
</script>

<style scoped>
.qv-card {
    overflow: hidden;
    position: relative;
}

.qv-close {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 10;
    background: rgba(0,0,0,0.45) !important;
}

.qv-image-col {
    background: #f8f9fb;
    display: flex;
    flex-direction: column;
    padding: 28px 24px;
    border-left: 1px solid #e5e7eb;
}

.qv-main-image {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 280px;
}

.qv-main-image img {
    max-height: 300px;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s;
}

.qv-main-image:hover img {
    transform: scale(1.04);
}

.qv-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #ef4444;
    color: white;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 0 12px 0 12px;
}

.qv-thumbs {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 16px;
    flex-wrap: wrap;
}

.qv-thumb {
    width: 56px;
    height: 56px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.15s;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qv-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.qv-thumb--active {
    border-color: #3949ab;
}

.qv-details-col {
    padding: 36px 32px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.qv-category {
    font-size: 12px;
    font-weight: 600;
    color: #3949ab;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.qv-name {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    line-height: 1.4;
    margin-bottom: 10px;
}

.qv-price-row {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 4px;
}

.qv-price-new {
    font-size: 24px;
    font-weight: 800;
    color: #1a237e;
}

.qv-price-old {
    font-size: 15px;
    color: #9ca3af;
    text-decoration: line-through;
}

.qv-desc {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.7;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.qv-qty {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 4px 12px;
    background: #f9fafb;
}

.qv-qty button {
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

.qv-qty button:hover {
    background: #e5e7eb;
    color: #111827;
}

.qv-qty span {
    font-size: 15px;
    font-weight: 600;
    min-width: 24px;
    text-align: center;
}
</style>
