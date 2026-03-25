<template>
    <v-card class="mx-auto my-12 product-card" max-width="374">
        <v-hover v-slot="{ isHovering, props: hoverProps }">
            <div
                class="img-parent position-relative"
                style="height: 200px; overflow: hidden"
            >
                <img
                    :src="currentImage"
                    :alt="item.name_en"
                    class="w-100"
                    :style="{
                        height: '100%',
                        transition: 'all 0.3s ease-in-out',
                        cursor: 'pointer',
                        scale: isHovering ? 1.05 : 1,
                        objectFit: 'cover',
                      }"
                    v-bind="hoverProps"
                />

                <!-- 🔥 زر المفضلة -->
                <v-btn
                    icon
                    size="small"
                    class="favorite-btn"
                    variant="flat"
                    :color="isFavorite ? 'red' : 'white'"
                    @click.stop="toggleFavorite"
                >
                    <v-icon :color="isFavorite ? 'red' : 'grey-darken-3'">
                        {{ isFavorite ? 'mdi-heart' : 'mdi-heart-outline' }}
                    </v-icon>
                </v-btn>

                <v-btn
                    density="compact"
                    color="primary"

                    height="32"
                    variant="tonal"
                    class="bg-white quick-view-btn"
                    prepend-icon= "mdi-eye"
                    style="
                        text-transform: none;
                        position: absolute;
                        left: 50%;
                        top: 50%;
                        transform: translate(-50%, -50%);
                        font-size: 12px;
                        opacity: 0;
                        transition: opacity 0.2s ease-in-out;
                    "
                    @click="$emit('quick-view', item)"
                >
                    Quick View
                </v-btn>
            </div>
        </v-hover>

        <v-card-item>
            <v-card-title>{{ item.name }}</v-card-title>

            <v-card-subtitle v-if="item.parent">
                <span class="me-1">{{ item.parent?.name_en || item.parent?.name }}</span>
                <v-icon color="error" icon="mdi-fire-circle" size="small"></v-icon>
            </v-card-subtitle>
        </v-card-item>

        <v-card-text>
            <v-row align="center" class="mx-0">
                <v-rating
                    :model-value="4.5"
                    color="amber"
                    density="compact"
                    size="small"
                    half-increments
                    readonly
                ></v-rating>
                <div class="text-grey ms-4">4.5 (413)</div>
            </v-row>
        </v-card-text>

        <v-divider class="mx-4 mb-1"></v-divider>

        <v-card-text class="pl-0 pt-0">
            <template v-if="item.discount_price && item.discount_price < item.price">
                <del class="text-grey">${{ item.price }}</del>
                <span class="text-red ml-2" style="font-weight: 900; font-size: 16px">
          ${{ Math.ceil(item.discount_price) }}
        </span>
            </template>
            <template v-else>
        <span class="text-dark" style="font-weight: 900; font-size: 16px">
          ${{ Math.ceil(item.price) }}
        </span>
            </template>
        </v-card-text>

        <v-btn-toggle v-model="currentImage">
            <v-btn
                v-for="(pic, i) in item.images"
                :key="i"
                :value="pic.image_url"
                size="x-small"
                rounded="xl"
                :ripple="false"
            >
                <img
                    :src="pic.image_url"
                    width="30"
                    height="30"
                    style="border: 1px solid rgba(110, 110, 110, 0.377); border-radius: 50%;"
                    alt="img"
                />
            </v-btn>
        </v-btn-toggle>

        <v-card-actions class="flex-column gap-1 pa-2">
            <v-btn
                color="primary"
                block
                variant="elevated"
                height="40"
                style="border-radius:20px; text-transform:none"
                :loading="addingToCart"
                @click="addToCart"
            >
                <v-icon start>mdi-cart-plus</v-icon>
                أضف للسلة
            </v-btn>
            <v-btn
                color="deep-purple-lighten-2"
                block
                variant="tonal"
                height="40"
                style="border-radius:20px; text-transform:none"
                :href="item.slug ? route('productss.show', item.slug) : '#'"
            >
                تفاصيل المنتج
            </v-btn>
        </v-card-actions>

        <!-- 🔥 Snackbar لرسايل النجاح أو الخطأ -->
        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2000">
            {{ snackbarMessage }}
        </v-snackbar>
    </v-card>
</template>

<script setup>
import { ref, inject } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import axios from 'axios';

const props = defineProps({
    item: { type: Object, required: true },
});

const emit = defineEmits(['quick-view']);
const Emitter = inject('Emitter');

const { props: pageProps } = usePage();
const user = pageProps.auth?.user;
const currentImage = ref(props.item.image_url);
const isFavorite = ref(props.item.is_in_wishlist || false);
const addingToCart = ref(false);
const snackbar = ref(false);
const snackbarMessage = ref('');
const snackbarColor = ref('success');

async function addToCart() {
    addingToCart.value = true;
    try {
        const { data } = await axios.post('/cart/add', {
            product_id: props.item.id,
            quantity: 1,
        });
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
    if (!user) {
        router.visit(route('login'));
        return;
    }

    const action = isFavorite.value ? 'wishlist.remove' : 'wishlist.add';
    router.post(route(action, props.item.id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            isFavorite.value = !isFavorite.value;
            snackbarMessage.value = isFavorite.value
                ? 'تم إضافة المنتج إلى قائمة الأمنيات'
                : 'تم إزالة المنتج من قائمة الأمنيات';
            snackbarColor.value = 'success';
            snackbar.value = true;
        },
        onError: (errors) => {
            snackbarMessage.value = 'حدث خطأ، حاول مرة أخرى';
            snackbarColor.value = 'error';
            snackbar.value = true;
        },
    });
}
</script>

<style scoped>
.product-card:hover .quick-view-btn {
    opacity: 1 !important;
}

.favorite-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
    background-color: rgba(255, 255, 255, 0.85) !important;
    transition: all 0.2s ease-in-out;
}

.favorite-btn:hover {
    background-color: white !important;
    transform: scale(1.1);
}
</style>
