<template>
    <div
        class="pc"
        :class="{ 'pc--hovered': hovered }"
        :data-product-id="item.id"
        @mouseenter="hovered = true"
        @mouseleave="hovered = false"
    >
        <!-- Image -->
        <div class="pc-img-wrap">
            <img :src="item.image_url" :alt="item.name" class="pc-img" />
            <span v-if="discountPercent" class="pc-badge">-{{ discountPercent }}%</span>
            <button class="pc-wish" :class="{ 'pc-wish--on': isFavorite }" @click.stop="toggleFavorite">
                <v-icon size="14">{{ isFavorite ? 'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
            </button>
            <div class="pc-qv-layer" :class="{ show: hovered }">
                <button class="pc-qv-pill" @click.stop="$emit('quick-view', item)">
                    <v-icon size="13" class="me-1">mdi-eye-outline</v-icon>
                    عرض سريع
                </button>
            </div>
            <!-- Mobile quick-view button — always visible on touch devices -->
            <button class="pc-qv-mobile" @click.stop="$emit('quick-view', item)" title="عرض سريع">
                <v-icon size="15">mdi-eye-outline</v-icon>
                عرض سريع
            </button>
            <div v-if="item.quantity < 1" class="pc-oos-layer">نفذت الكمية</div>
        </div>

        <!-- Body -->
        <div class="pc-body">
            <span v-if="item.parent" class="pc-cat">{{ item.parent.name_en || item.parent.name }}</span>
            <div class="pc-name">{{ item.name }}</div>
            <div class="pc-price-row">
                <span class="pc-price-new">
                    ${{ Math.ceil(item.discount_price && Number(item.discount_price) < Number(item.price) ? item.discount_price : item.price) }}
                </span>
                <span v-if="item.discount_price && Number(item.discount_price) < Number(item.price)" class="pc-price-old">
                    ${{ item.price }}
                </span>
            </div>
            <div class="pc-actions">
                <button
                    class="pc-cart-btn"
                    :class="{ 'pc-cart-btn--done': justAdded }"
                    :disabled="addingToCart || item.quantity < 1"
                    @click.stop="addToCart"
                >
                    <v-icon size="14" class="me-1">{{ justAdded ? 'mdi-check' : 'mdi-cart-plus' }}</v-icon>
                    {{ item.quantity < 1 ? 'نفذت الكمية' : justAdded ? 'تمت الإضافة ✓' : 'أضف للسلة' }}
                </button>
                <button
                    class="pc-compare-btn"
                    :class="{ 'pc-compare-btn--on': isInCompare(item.id) }"
                    @click.stop="toggleCompare(item)"
                    title="إضافة للمقارنة"
                >
                    <v-icon size="13">mdi-compare</v-icon>
                </button>
            </div>
        </div>

        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="3000">
            {{ snackbarMessage }}
            <template v-if="snackbarColor === 'warning'" #actions>
                <v-btn variant="text" color="white" size="small" href="/login" style="font-weight:700">
                    تسجيل الدخول
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, computed, inject } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import axios from 'axios';
import { useCartFly } from '../../composables/useCartFly';
import { useCompare } from '../../composables/useCompare';

const props = defineProps({ item: { type: Object, required: true } });
const emit  = defineEmits(['quick-view']);

const Emitter = inject('Emitter');
const { flyToCart } = useCartFly();
const { toggle: toggleCompare, isInCompare } = useCompare();
const user = usePage().props.auth?.user;

const hovered= ref(false);
const isFavorite   = ref(props.item.is_in_wishlist || false);
const addingToCart = ref(false);
const justAdded    = ref(false);
const snackbar     = ref(false);
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
        flyToCart(document.querySelector(`[data-product-id="${props.item.id}"]`));
        justAdded.value = true;
        setTimeout(() => { justAdded.value = false; }, 2200);
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
    if (!user) {
        snackbarMessage.value = 'يجب تسجيل الدخول أولاً لإضافة المنتج للمفضلة';
        snackbarColor.value = 'warning';
        snackbar.value = true;
        return;
    }
    const action = isFavorite.value ? 'wishlist.remove' : 'wishlist.add';
    router.post(route(action, props.item.id), {}, {
        preserveState: true, preserveScroll: true,
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
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s, transform 0.2s, border-color 0.2s;
    cursor: pointer;
}

.pc--hovered {
    box-shadow: 0 8px 28px rgba(26,35,126,0.10);
    transform: translateY(-2px);
    border-color: #c5cae9;
}

.pc-img-wrap {
    position: relative;
    overflow: hidden;
    background: #f3f4f6;
    height: 160px;
}

@media (min-width: 600px) {
    .pc-img-wrap { height: 180px; }
}

.pc-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    display: block;
}

.pc--hovered .pc-img { transform: scale(1.05); }

.pc-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #ef4444;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    z-index: 2;
    line-height: 1.4;
}

.pc-wish {
    position: absolute;
    top: 8px;
    left: 8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    box-shadow: 0 1px 6px rgba(0,0,0,0.12);
    transition: all 0.15s;
    z-index: 5;
}

.pc-wish:hover { color: #ef4444; transform: scale(1.1); }
.pc-wish--on { background: #fee2e2; color: #ef4444; }

.pc-qv-layer {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 3;
}

.pc-qv-layer.show { opacity: 1; }

.pc-qv-pill {
    background: white;
    border: none;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 600;
    color: #1a237e;
    cursor: pointer;
    display: flex;
    align-items: center;
}

/* Mobile quick-view button — hidden on desktop (hover handles it), shown on touch */
.pc-qv-mobile {
    display: none;
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    background: #1a237e;
    border: none;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    align-items: center;
    gap: 5px;
    box-shadow: 0 3px 12px rgba(26,35,126,0.35);
    z-index: 4;
    white-space: nowrap;
    letter-spacing: 0.2px;
}

@media (hover: none) {
    /* touch device — show mobile QV button, hide hover overlay */
    .pc-qv-mobile { display: flex; }
    .pc-qv-layer  { display: none; }
}

.pc-oos-layer {    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    font-weight: 700;
    z-index: 4;
}

.pc-body {
    padding: 10px 12px 12px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
}

.pc-cat {
    font-size: 9px;
    font-weight: 700;
    color: #3949ab;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    background: #e8eaf6;
    padding: 2px 7px;
    border-radius: 20px;
    align-self: flex-start;
    line-height: 1.5;
}

.pc-name {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pc-price-row {
    display: flex;
    align-items: baseline;
    gap: 5px;
    margin-top: 2px;
}

.pc-price-new {
    font-size: 16px;
    font-weight: 800;
    color: #1a237e;
    line-height: 1;
}

.pc-price-old {
    font-size: 11px;
    color: #9ca3af;
    text-decoration: line-through;
}

.pc-actions {
    display: flex;
    gap: 6px;
    margin-top: 6px;
    align-items: center;
}

.pc-cart-btn {
    flex: 1;
    height: 34px;
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
    gap: 4px;
    transition: all 0.18s;
    white-space: nowrap;
    overflow: hidden;
}

.pc-cart-btn:hover:not(:disabled) {
    background: #1a237e;
    border-color: #1a237e;
    color: white;
}

.pc-cart-btn--done {
    background: #16a34a !important;
    border-color: #16a34a !important;
    color: white !important;
}

.pc-cart-btn:disabled {
    opacity: 0.45;
    cursor: not-allowed;
    border-color: #d1d5db;
    color: #9ca3af;
}

.pc-compare-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    transition: all 0.15s;
    flex-shrink: 0;
}

.pc-compare-btn:hover {
    border-color: #3949ab;
    color: #3949ab;
    background: #f0f2ff;
}

.pc-compare-btn--on {
    border-color: #3949ab;
    background: #3949ab;
    color: white;
}
</style>
