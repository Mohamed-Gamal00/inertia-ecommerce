<template>
    <div class="pc" @mouseenter="hovered = true" @mouseleave="hovered = false">

        <!-- Image area -->
        <div class="pc-img-wrap">
            <img :src="currentImage || item.image_url" :alt="item.name" class="pc-img" />

            <!-- Discount badge -->
            <div v-if="discountPercent" class="pc-badge">-{{ discountPercent }}%</div>

            <!-- Wishlist -->
            <button class="pc-wish" :class="{ 'pc-wish--active': isFavorite }" @click.stop="toggleFavorite">
                <v-icon size="16">{{ isFavorite ? 'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
            </button>

            <!-- Quick view overlay -->
            <div class="pc-overlay" :class="{ 'pc-overlay--show': hovered }">
                <button class="pc-qv-btn" @click.stop="$emit('quick-view', item)">
                    <v-icon size="15" class="me-1">mdi-eye-outline</v-icon>
                    عرض سريع
                </button>
            </div>

            <!-- Color thumbnails -->
            <div v-if="item.images?.length" class="pc-thumbs">
                <div
                    v-for="(pic, i) in item.images.slice(0, 4)"
                    :key="i"
                    class="pc-thumb"
                    :class="{ 'pc-thumb--active': currentImage === pic.image_url }"
                    @click.stop="currentImage = pic.image_url"
                >
                    <img :src="pic.image_url" alt="thumb" />
                </div>
            </div>
        </div>

        <!-- Info area -->
        <div class="pc-info">
            <!-- Category -->
            <div v-if="item.parent" class="pc-cat">
                {{ item.parent.name_en || item.parent.name }}
            </div>

            <!-- Name -->
            <div class="pc-name">{{ item.name }}</div>

            <!-- Rating -->
            <div class="pc-rating">
                <v-rating :model-value="4.5" half-increments readonly color="amber" density="compact" size="x-small" />
                <span class="pc-rating-count">(24)</span>
            </div>

            <!-- Price -->
            <div class="pc-price-row">
                <template v-if="item.discount_price && item.discount_price < item.price">
                    <span class="pc-price-new">${{ Math.ceil(item.discount_price) }}</span>
                    <span class="pc-price-old">${{ item.price }}</span>
                </template>
                <template v-else>
                    <span class="pc-price-new">${{ Math.ceil(item.price) }}</span>
                </template>
            </div>

            <!-- Add to cart -->
            <button
                class="pc-cart-btn"
                :class="{ 'pc-cart-btn--loading': addingToCart }"
                :disabled="addingToCart || item.quantity < 1"
                @click.stop="addToCart"
            >
                <v-icon size="15" class="me-1">mdi-cart-plus</v-icon>
                {{ item.quantity < 1 ? 'نفذت الكمية' : 'أضف للسلة' }}
            </button>
        </div>

        <!-- Snackbar -->
        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
            {{ snackbarMessage }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, computed, inject } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import axios from 'axios';

const props = defineProps({
    item: { type: Object, required: true },
});

const emit = defineEmits(['quick-view']);
const Emitter = inject('Emitter');

const { props: pageProps } = usePage();
const user = pageProps.auth?.user;

const hovered       = ref(false);
const currentImage  = ref(props.item.image_url);
const isFavorite    = ref(props.item.is_in_wishlist || false);
const addingToCart  = ref(false);
const snackbar      = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');

const discountPercent = computed(() => {
    if (!props.item.discount_price || !props.item.price) return 0;
    return Math.round(((props.item.price - props.item.discount_price) / props.item.price) * 100);
});

async function addToCart() {
    addingToCart.value = true;
    try {
        const { data } = await axios.post('/cart/add', { product_id: props.item.id, quantity: 1 });
        Emitter.emit('cart-item-added', data.items);
        snackbarMessage.value = 'تم إضافة المنتج للسلة';
        snackbarColor.value = 'success';
    } catch (e) {
        snackbarMessage.value = e.response?.data?.message || 'حدث خطأ';
        snackbarColor.value = 'error';
    } finally {
        addingToCart.value = false;
        snackbar.value = true;
    }
}

function toggleFavorite() {
    if (!user) { router.visit(route('login')); return; }
    const action = isFavorite.value ? 'wishlist.remove' : 'wishlist.add';
    router.post(route(action, props.item.id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            isFavorite.value = !isFavorite.value;
            snackbarMessage.value = isFavorite.value ? 'تمت الإضافة للمفضلة' : 'تمت الإزالة من المفضلة';
            snackbarColor.value = 'success';
            snackbar.value = true;
        },
    });
}
</script>

<style scoped>
.pc {
    background: white;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: box-shadow 0.25s, transform 0.25s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
}

.pc:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.10);
    transform: translateY(-3px);
}

/* Image */
.pc-img-wrap {
    position: relative;
    overflow: hidden;
    background: #f8f9fb;
    aspect-ratio: 1 / 1;
}

.pc-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.pc:hover .pc-img { transform: scale(1.06); }

/* Discount badge */
.pc-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ef4444;
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
    z-index: 2;
}

/* Wishlist */
.pc-wish {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    transition: transform 0.15s, background 0.15s;
    z-index: 2;
    color: #9ca3af;
}

.pc-wish:hover { transform: scale(1.1); }
.pc-wish--active { background: #fee2e2; color: #ef4444; }

/* Quick view overlay */
.pc-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background: linear-gradient(to top, rgba(0,0,0,0.45), transparent);
    opacity: 0;
    transition: opacity 0.25s;
    z-index: 2;
}

.pc-overlay--show { opacity: 1; }

.pc-qv-btn {
    background: white;
    border: none;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #1a237e;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: background 0.15s;
}

.pc-qv-btn:hover { background: #e8eaf6; }

/* Thumbnails */
.pc-thumbs {
    position: absolute;
    bottom: 8px;
    right: 8px;
    display: flex;
    gap: 4px;
    z-index: 2;
}

.pc-thumb {
    width: 24px;
    height: 24px;
    border-radius: 4px;
    border: 1.5px solid #e5e7eb;
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.15s;
    background: white;
}

.pc-thumb img { width: 100%; height: 100%; object-fit: cover; }
.pc-thumb--active { border-color: #3949ab; }

/* Info */
.pc-info {
    padding: 12px 14px 14px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
}

.pc-cat {
    font-size: 10px;
    font-weight: 700;
    color: #3949ab;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.pc-name {
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pc-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}

.pc-rating-count { font-size: 11px; color: #9ca3af; }

.pc-price-row {
    display: flex;
    align-items: baseline;
    gap: 6px;
    margin-top: 2px;
}

.pc-price-new { font-size: 16px; font-weight: 800; color: #1a237e; }
.pc-price-old { font-size: 12px; color: #9ca3af; text-decoration: line-through; }

/* Cart button */
.pc-cart-btn {
    margin-top: 8px;
    width: 100%;
    height: 36px;
    border-radius: 8px;
    border: 1.5px solid #3949ab;
    background: transparent;
    color: #3949ab;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, color 0.15s;
}

.pc-cart-btn:hover:not(:disabled) {
    background: #3949ab;
    color: white;
}

.pc-cart-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    border-color: #9ca3af;
    color: #9ca3af;
}

.pc-cart-btn--loading { opacity: 0.7; }
</style>
