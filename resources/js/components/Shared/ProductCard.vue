<template>
    <article
        class="pc"
        :class="{ 'pc--oos': isOutOfStock }"
        :data-product-id="item.id"
    >
        <!-- ───────── Media ───────── -->
        <div class="pc-media">
            <component
                :is="productUrl ? 'a' : 'div'"
                :href="productUrl || undefined"
                class="pc-img-link"
                :aria-label="productUrl ? pick(item, 'name') : undefined"
                :tabindex="productUrl ? 0 : -1"
            >
                <img
                    :src="item.image_url"
                    :alt="pick(item, 'name')"
                    class="pc-img"
                    loading="lazy"
                    decoding="async"
                />
            </component>

            <!-- Discount badge -->
            <span v-if="discountPercent && !isOutOfStock" class="pc-badge">
                -{{ discountPercent }}%
            </span>

            <!-- Floating actions (logical positioning => works in RTL & LTR) -->
            <div class="pc-tools">
                <button
                    type="button"
                    class="pc-tool pc-tool--wish"
                    :class="{ 'is-on': isFavorite }"
                    :aria-pressed="isFavorite"
                    :aria-label="isFavorite ? t('removed_from_wishlist') : t('add_to_wishlist')"
                    :title="isFavorite ? t('removed_from_wishlist') : t('add_to_wishlist')"
                    @click.stop="toggleFavorite"
                >
                    <v-icon size="18">{{ isFavorite ? 'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
                </button>

                <button
                    v-if="!isOutOfStock"
                    type="button"
                    class="pc-tool pc-tool--secondary"
                    :class="{ 'is-on': inCompare }"
                    :aria-pressed="inCompare"
                    :aria-label="t('compare')"
                    :title="t('compare')"
                    @click.stop="toggleCompare(item)"
                >
                    <v-icon size="18">mdi-compare</v-icon>
                </button>

                <button
                    v-if="!isOutOfStock"
                    type="button"
                    class="pc-tool pc-tool--secondary"
                    :aria-label="t('quick_view')"
                    :title="t('quick_view')"
                    @click.stop="$emit('quick-view', item)"
                >
                    <v-icon size="18">mdi-eye-outline</v-icon>
                </button>
            </div>

            <!-- Out of stock -->
            <div v-if="isOutOfStock" class="pc-oos">
                <span>{{ t('out_of_stock') }}</span>
            </div>
        </div>

        <!-- ───────── Body ───────── -->
        <div class="pc-body">
            <span v-if="item.parent" class="pc-cat">{{ pick(item.parent, 'name') }}</span>

            <h3 class="pc-name">
                <component
                    :is="productUrl ? 'a' : 'span'"
                    :href="productUrl || undefined"
                    class="pc-name-link"
                >
                    {{ pick(item, 'name') }}
                </component>
            </h3>

            <!-- Price block -->
            <div class="pc-price">
                <span class="pc-price-now">${{ formatPrice(finalPrice) }}</span>
                <span v-if="hasDiscount" class="pc-price-old">${{ formatPrice(item.price) }}</span>
            </div>

            <!-- Low stock hint -->
            <p v-if="isLowStock" class="pc-stock">
                <span class="pc-stock-dot" aria-hidden="true"></span>
                {{ item.quantity }} {{ t('left_in_stock') }}
            </p>

            <!-- Primary CTA -->
            <button
                type="button"
                class="pc-cta"
                :class="{ 'pc-cta--done': justAdded }"
                :disabled="addingToCart || isOutOfStock"
                :aria-busy="addingToCart"
                @click.stop="addToCart"
            >
                <span class="pc-cta-inner">
                    <v-progress-circular
                        v-if="addingToCart"
                        indeterminate
                        size="16"
                        width="2"
                        color="currentColor"
                    />
                    <v-icon v-else size="18">{{ justAdded ? 'mdi-check' : 'mdi-cart-plus' }}</v-icon>
                    <span>{{ ctaLabel }}</span>
                </span>
            </button>
        </div>

        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="3000">
            {{ snackbarMessage }}
            <template v-if="snackbarColor === 'warning'" #actions>
                <v-btn variant="text" color="white" size="small" href="/login" style="font-weight:700">
                    {{ t('login') }}
                </v-btn>
            </template>
        </v-snackbar>
    </article>
</template>

<script setup>
import { ref, computed, inject } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import axios from 'axios';
import { useCartFly } from '../../composables/useCartFly';
import { useCompare } from '../../composables/useCompare';
import { useLocale } from '../../composables/useLocale';

const props = defineProps({
    item: { type: Object, required: true },
    lowStockThreshold: { type: Number, default: 5 },
});
defineEmits(['quick-view']);

const Emitter = inject('Emitter');
const { flyToCart } = useCartFly();
const { toggle: toggleCompare, isInCompare } = useCompare();
const { t, pick } = useLocale();
const user = usePage().props.auth?.user;

const isFavorite   = ref(props.item.is_in_wishlist || false);
const addingToCart = ref(false);
const justAdded    = ref(false);
const snackbar     = ref(false);
const snackbarMessage = ref('');
const snackbarColor   = ref('success');

/* ── Derived state ── */
const isOutOfStock = computed(() => props.item.quantity < 1);
const isLowStock   = computed(() => !isOutOfStock.value && props.item.quantity <= props.lowStockThreshold);
const inCompare    = computed(() => isInCompare(props.item.id));

// Adjust to your real product route if it differs (e.g. route('products.show', props.item.slug))
const productUrl = computed(() => props.item.url || null);

const hasDiscount = computed(() =>
    props.item.discount_price && Number(props.item.discount_price) < Number(props.item.price)
);
const finalPrice = computed(() => (hasDiscount.value ? props.item.discount_price : props.item.price));

const discountPercent = computed(() => {
    if (!hasDiscount.value) return 0;
    return Math.round(((props.item.price - props.item.discount_price) / props.item.price) * 100);
});

const ctaLabel = computed(() => {
    if (isOutOfStock.value) return t('out_of_stock');
    if (justAdded.value)    return t('added_to_cart');
    return t('add_to_cart');
});

/* Shows decimals only when they exist: 120 → "120", 119.5 → "119.50" */
function formatPrice(value) {
    const n = Number(value);
    if (Number.isNaN(n)) return value;
    return n.toLocaleString('en-US', {
        minimumFractionDigits: Number.isInteger(n) ? 0 : 2,
        maximumFractionDigits: 2,
    });
}

function notify(message, color = 'success') {
    snackbarMessage.value = message;
    snackbarColor.value = color;
    snackbar.value = true;
}

/* ── Actions ── */
async function addToCart() {
    if (addingToCart.value || isOutOfStock.value) return;
    addingToCart.value = true;
    try {
        const { data } = await axios.post('/cart/add', { product_id: props.item.id, quantity: 1 });
        Emitter.emit('cart-item-added', data.items);
        flyToCart(document.querySelector(`[data-product-id="${props.item.id}"]`));
        justAdded.value = true;
        setTimeout(() => { justAdded.value = false; }, 2200);
        notify(t('product_added_to_cart'), 'success');
    } catch (e) {
        notify(e.response?.data?.message || t('error_occurred'), 'error');
    } finally {
        addingToCart.value = false;
    }
}

function toggleFavorite() {
    if (!user) {
        notify(t('wishlist_login_required'), 'warning');
        return;
    }
    const action = isFavorite.value ? 'wishlist.remove' : 'wishlist.add';
    router.post(route(action, props.item.id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            isFavorite.value = !isFavorite.value;
            notify(isFavorite.value ? t('added_to_wishlist') : t('removed_from_wishlist'));
        },
    });
}
</script>

<style scoped>
/* ───────── Tokens ───────── */
.pc {
    --c-bg: #FDFBF7;
    --c-surface: #F3ECE0;
    --c-line: #E6DDCF;
    --c-brand: #76543D;
    --c-brand-dark: #5C4130;
    --c-accent: #C69763;
    --c-sale: #B4452F;
    --c-text: #302F2B;
    --c-muted: #77736B;
    --c-ok: #15803D;
    --c-warn: #B45309;

    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: var(--c-bg);
    border: 1px solid var(--c-line);
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow .2s ease, border-color .2s ease;
}

@media (hover: hover) {
    .pc:hover {
        border-color: var(--c-accent);
        box-shadow: 0 10px 28px rgba(118, 84, 61, .12);
    }
}

/* ───────── Media ───────── */
.pc-media {
    position: relative;
    aspect-ratio: 1 / 1;          /* no layout shift while images load */
    background: var(--c-surface);
    overflow: hidden;
}

.pc-img-link { display: block; width: 100%; height: 100%; }

.pc-img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

@media (hover: hover) {
    .pc:not(.pc--oos):hover .pc-img { transform: scale(1.04); }
}

/* Discount badge */
.pc-badge {
    position: absolute;
    inset-block-start: 10px;
    inset-inline-start: 10px;
    z-index: 2;
    padding: 3px 9px;
    border-radius: 6px;
    background: var(--c-sale);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.5;
}

/* Floating tools */
.pc-tools {
    position: absolute;
    inset-block-start: 10px;
    inset-inline-end: 10px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.pc-tool {
    display: grid;
    place-items: center;
    width: 36px;
    height: 36px;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, .95);
    color: var(--c-text);
    box-shadow: 0 1px 6px rgba(0, 0, 0, .14);
    cursor: pointer;
    transition: background .15s, color .15s, transform .15s, opacity .2s;
}

.pc-tool:hover { transform: scale(1.08); color: var(--c-brand); }

.pc-tool--wish.is-on { background: #FDE8E8; color: #DC2626; }
.pc-tool--wish:hover { color: #DC2626; }

.pc-tool--secondary.is-on { background: var(--c-brand); color: #fff; }

/* On devices with hover: secondary tools appear on hover / keyboard focus.
   On touch devices they stay visible (no hover available). */
@media (hover: hover) {
    .pc-tool--secondary:not(.is-on) {
        opacity: 0;
        transform: translateY(-4px);
    }
    .pc:hover .pc-tool--secondary,
    .pc:focus-within .pc-tool--secondary {
        opacity: 1;
        transform: none;
    }
}

/* Out of stock */
.pc-oos {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: grid;
    place-items: center;
    background: rgba(253, 251, 247, .62);
    pointer-events: none;
}

.pc-oos span {
    padding: 6px 14px;
    border-radius: 6px;
    background: var(--c-text);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
}

.pc--oos .pc-img { filter: grayscale(70%); }

/* ───────── Body ───────── */
.pc-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 6px;
    padding: 12px 14px 14px;
}

.pc-cat {
    font-size: 12px;
    font-weight: 600;
    color: var(--c-muted);
    line-height: 1.4;
}

.pc-name {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    line-height: 1.45;
    color: var(--c-text);
    /* reserve 2 lines so every card in a row aligns */
    min-height: calc(1.45em * 2);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pc-name-link { color: inherit; text-decoration: none; }
.pc-name-link:hover { color: var(--c-brand); }

/* Price */
.pc-price {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 4px 8px;
    margin: 2px 0 8px;
}

.pc-price-now {
    font-size: 18px;
    font-weight: 800;
    line-height: 1.2;
    color: var(--c-brand);
    font-variant-numeric: tabular-nums;
}

.pc-price-old {
    font-size: 13px;
    color: var(--c-muted);
    text-decoration: line-through;
    font-variant-numeric: tabular-nums;
}

.pc--oos .pc-price-now { color: var(--c-muted); }

/* Low stock */
.pc-stock {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: var(--c-warn);
}

.pc-stock-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

/* CTA — pinned to bottom so all buttons line up across a row */
.pc-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: row;
    gap: 6px;
    width: 100%;
    min-height: 42px;             /* comfortable touch target */
    margin-top: auto;
    border: 0;
    border-radius: 10px;
    background: var(--c-brand);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .18s ease, transform .1s ease;
    /* force horizontal centering regardless of page direction */
    direction: ltr;
    unicode-bidi: plaintext;
    text-align: center;
}

.pc-cta:hover:not(:disabled) { background: var(--c-brand-dark); }
.pc-cta:active:not(:disabled) { transform: scale(.98); }

.pc-cta-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    direction: rtl;         /* keeps icon + text in natural Arabic order */
    pointer-events: none;
}

.pc-cta--done,
.pc-cta--done:hover:not(:disabled) { background: var(--c-ok); }

.pc-cta:disabled { cursor: not-allowed; }
.pc--oos .pc-cta:disabled {
    background: #ECE8E1;
    color: #8B867D;
}

/* ───────── Accessibility ───────── */
.pc-tool:focus-visible,
.pc-cta:focus-visible,
.pc-name-link:focus-visible,
.pc-img-link:focus-visible {
    outline: 2px solid var(--c-accent);
    outline-offset: 2px;
}

@media (prefers-reduced-motion: reduce) {
    .pc,
    .pc-img,
    .pc-tool,
    .pc-cta { transition: none; }
    .pc:hover .pc-img { transform: none; }
}

/* ───────── Small screens ───────── */
@media (max-width: 599px) {
    .pc-body { padding: 10px 10px 12px; }
    .pc-name { font-size: 13px; }
    .pc-price-now { font-size: 16px; }
    .pc-cta { font-size: 12px; min-height: 40px; }
}
</style>
