<template>
    <div>
        <v-navigation-drawer v-model="drawer" temporary location="left" width="370" class="pa-2">

            <!-- Header -->
            <v-card class="px-0" elevation="0">
                <v-card-title class="pl-0 pr-0 d-flex justify-space-between align-center w-100" style="font-size:17px;font-weight:bold">
                    سلة التسوق
                    <v-icon @click="drawer = false">mdi-close</v-icon>
                </v-card-title>
                <v-card-text class="px-0" style="color:#6f6f6f">{{ cartItems.length }} منتج</v-card-text>
                <v-card-text class="px-0 text-center" style="color:#6f6f6f" v-if="!cartItems.length">
                    السلة فارغة
                </v-card-text>

                <!-- Free shipping progress -->
                <template v-if="cartItems.length">
                    <div class="position-relative mt-4 mx-2">
                        <!-- Truck icon -->
                        <svg
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="30px"
                            viewBox="0 0 512 512"
                            :fill="shippingProgress < 50 ? '#f44336' : shippingProgress < 100 ? '#ff9800' : '#4caf50'"
                            :style="`
                                position: absolute;
                                bottom: 50%;
                                z-index: 1;
                                right: calc(${Math.min(shippingProgress, 100)}% - 30px);
                                transition: all 0.3s ease-in-out;
                            `"
                        >
                            <g>
                                <path d="M43.297,157.656L6.109,262.219C2.406,271.031,0,285.313,0,292.109s0,41.234,0,41.234
                                c0,11.188,9.156,20.375,20.375,20.375h24.391C47.219,379,68.516,398.75,94.438,398.75s47.234-19.75,49.688-45.031h45.109V139.75
                                H73.391C62.188,139.75,48.641,147.813,43.297,157.656z M94.438,373.781c-13.781,0-24.969-11.188-24.969-24.969
                                s11.188-24.938,24.969-24.938c13.797,0,24.969,11.156,24.969,24.938S108.234,373.781,94.438,373.781z M165.797,166.313v79.516
                                H46.875l23.375-71.609c2.047-3.781,9-7.906,13.281-7.906H165.797z"/>
                                <path d="M217.797,113.25v240.469h147.109c2.422,25.281,23.734,45.031,49.656,45.031
                                c25.938,0,47.219-19.75,49.703-45.031H512V113.25H217.797z M414.563,373.781c-13.781,0-24.969-11.188-24.969-24.969
                                s11.188-24.938,24.969-24.938c13.797,0,24.969,11.156,24.969,24.938S428.359,373.781,414.563,373.781z"/>
                            </g>
                        </svg>
                        <v-progress-linear
                            :color="shippingProgress < 50 ? 'red' : shippingProgress < 100 ? 'orange' : 'green'"
                            height="10"
                            :model-value="Math.min(shippingProgress, 100)"
                            striped
                        />
                    </div>
                    <v-card-text class="px-0 pt-1" style="color:#6f6f6f; font-size:13px">
                        <span v-if="total < freeShippingThreshold">
                            {{ freeShippingThreshold - total }} ر.س متبقية للشحن المجاني
                        </span>
                        <span v-else class="text-green">تهانينا! شحن مجاني على طلبك</span>
                    </v-card-text>
                </template>
            </v-card>

            <!-- Items list -->
            <v-card class="pa-0 mt-3" elevation="0" v-if="cartItems.length" max-height="350" style="overflow-y:auto">
                <v-container class="px-1">
                    <v-row v-for="item in cartItems" :key="item.id" class="align-center mb-4">
                        <v-col cols="4">
                            <img :src="item.image" class="w-100" style="border-radius:8px; object-fit:cover; height:80px" alt="product" />
                        </v-col>
                        <v-col cols="8">
                            <div style="font-size:13px; font-weight:600; line-height:1.3">{{ item.name }}</div>
                            <div class="mt-1 font-weight-bold" style="font-size:14px">
                                {{ Math.ceil(item.discount_price || item.price) }} ر.س
                            </div>
                            <div class="d-flex align-center justify-space-between mt-2">
                                <!-- Quantity control -->
                                <div class="d-flex align-center px-1" style="border:1px solid #ccc; border-radius:20px">
                                    <v-icon size="18" color="#aaa" @click="changeQty(item, -1)">mdi-minus</v-icon>
                                    <span class="mx-2" style="font-size:13px; min-width:20px; text-align:center">{{ item.quantity }}</span>
                                    <v-icon size="18" color="#aaa" @click="changeQty(item, 1)">mdi-plus</v-icon>
                                </div>
                                <v-icon size="20" color="grey" @click="removeItem(item.id)">mdi-delete-outline</v-icon>
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>

            <!-- Footer actions -->
            <v-card class="mt-4" elevation="0" v-if="cartItems.length">
                <div class="d-flex justify-space-between px-2 mb-3">
                    <span style="font-weight:600">الإجمالي</span>
                    <span style="font-weight:700; font-size:16px">{{ total }} ر.س</span>
                </div>
                <v-card-actions class="flex-column gap-2">
                    <v-btn block variant="elevated" color="primary" height="44" style="border-radius:22px; text-transform:none">
                        إتمام الشراء
                    </v-btn>
                    <v-btn block variant="outlined" color="primary" height="44" style="border-radius:22px; text-transform:none" @click="drawer = false">
                        متابعة التسوق
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-navigation-drawer>
    </div>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import axios from 'axios';

const Emitter = inject('Emitter');
const drawer = ref(false);
const cartItems = ref([]);
const freeShippingThreshold = 500;

const total = computed(() =>
    cartItems.value.reduce((sum, item) => {
        const price = item.discount_price || item.price;
        return sum + Math.ceil(price) * item.quantity;
    }, 0)
);

const shippingProgress = computed(() =>
    parseInt((total.value / freeShippingThreshold) * 100)
);

async function fetchCart() {
    try {
        const { data } = await axios.get('/cart');
        cartItems.value = data.items;
        Emitter.emit('cart-updated', data.count);
    } catch (e) {
        console.error('Cart fetch error', e);
    }
}

async function changeQty(item, delta) {
    const newQty = item.quantity + delta;
    if (newQty < 1) return;
    try {
        const { data } = await axios.patch(`/cart/${item.id}`, { quantity: newQty });
        cartItems.value = data.items;
        Emitter.emit('cart-updated', data.count);
    } catch (e) {
        console.error(e);
    }
}

async function removeItem(id) {
    try {
        const { data } = await axios.delete(`/cart/${id}`);
        cartItems.value = data.items;
        Emitter.emit('cart-updated', data.count);
    } catch (e) {
        console.error(e);
    }
}

onMounted(() => {
    fetchCart();
    Emitter.on('openCart', () => {
        drawer.value = true;
    });
    Emitter.on('cart-item-added', (items) => {
        cartItems.value = items;
        Emitter.emit('cart-updated', items.length);
        drawer.value = true;
    });
});
</script>

<style lang="scss" scoped>
.v-navigation-drawer {
    overflow-y: auto;
    &::-webkit-scrollbar { width: 4px; }
    &::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
}
</style>
