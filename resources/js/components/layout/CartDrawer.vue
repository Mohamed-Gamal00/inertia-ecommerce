<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            temporary
            location="left"
            width="370"
            class="pa-2"
        >
            <v-card class="px-0" elevation="0">
                <v-card-title
                    class="pl-0 pr-0 d-flex justify-space-between align-center w-100"
                    style="font-size: 17px; font-weight: bold"
                    >Shopping Cart
                    <v-icon @click="drawer = false">mdi-close</v-icon>
                </v-card-title>
                <v-card-text class="px-0" style="color: #6f6f6f"
                    >{{ cartItems.length }} items</v-card-text
                >
                <v-card-text
                    class="px-0"
                    style="color: #6f6f6f"
                    v-if="!cartItems.length"
                    >Free Shipping for all orders over $10000.00</v-card-text
                >
                <v-card-text
                    class="px-0 text-center"
                    style="color: #6f6f6f"
                    v-if="!cartItems.length"
                    >Your cart is empty</v-card-text
                >
                <div
                    class="bar-parent mt-4 position-relative mr-2"
                    v-if="cartItems.length"
                >
                    <svg
                        version="1.1"
                        id="_x32_"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="30px"
                        viewBox="0 0 512 512"
                        :fill="
                            parseInt((calcTotalPrice / 10000) * 100) < 50
                                ? '#f44336'
                                : parseInt((calcTotalPrice / 10000) * 100) >
                                      50 &&
                                  parseInt((calcTotalPrice / 10000) * 100) < 100
                                ? '#ff9800'
                                : '#4caf50'
                        "
                        :style="`
                            position: absolute;
                            bottom: 50%;
                            z-index: 1;
                            right: calc(${
                                parseInt((calcTotalPrice / 10000) * 100) <= 100
                                    ? parseInt((calcTotalPrice / 10000) * 100)
                                    : 100
                            }% - 30px);
                            transition: all 0.15s ease-in-out;`"
                    >
                        <g>
                            <path
                                class="st0"
                                d="M43.297,157.656L6.109,262.219C2.406,271.031,0,285.313,0,292.109s0,41.234,0,41.234
                                c0,11.188,9.156,20.375,20.375,20.375h24.391C47.219,379,68.516,398.75,94.438,398.75s47.234-19.75,49.688-45.031h45.109V139.75
                                H73.391C62.188,139.75,48.641,147.813,43.297,157.656z M94.438,373.781c-13.781,0-24.969-11.188-24.969-24.969
                                s11.188-24.938,24.969-24.938c13.797,0,24.969,11.156,24.969,24.938S108.234,373.781,94.438,373.781z M165.797,166.313v79.516
                                H46.875l23.375-71.609c2.047-3.781,9-7.906,13.281-7.906H165.797z"
                            />
                            <path
                                class="st0"
                                d="M217.797,113.25v240.469h147.109c2.422,25.281,23.734,45.031,49.656,45.031
                                c25.938,0,47.219-19.75,49.703-45.031H512V113.25H217.797z M414.563,373.781c-13.781,0-24.969-11.188-24.969-24.969
                                s11.188-24.938,24.969-24.938c13.797,0,24.969,11.156,24.969,24.938S428.359,373.781,414.563,373.781z"
                            />
                        </g>
                    </svg>
                    <v-progress-linear
                        :color="
                            parseInt((calcTotalPrice / 10000) * 100) < 50
                                ? 'red'
                                : parseInt((calcTotalPrice / 10000) * 100) >
                                      50 &&
                                  parseInt((calcTotalPrice / 10000) * 100) < 100
                                ? 'orange'
                                : 'green'
                        "
                        height="10"
                        :model-value="
                            parseInt((calcTotalPrice / 10000) * 100) <= 100
                                ? parseInt((calcTotalPrice / 10000) * 100)
                                : 100
                        "
                        striped
                    >
                    </v-progress-linear>
                </div>
                <v-card-text
                    v-if="5 && 10000 - calcTotalPrice > 0"
                    class="px-0 pt-2"
                    style="color: #6f6f6f"
                >
                    Only ${{ 10000 - calcTotalPrice }} away from Free Shipping
                </v-card-text>

                <v-card-text
                    v-if="5 && 10000 - calcTotalPrice <= 0"
                    class="px-0 pt-2"
                    style="color: #6f6f6f"
                >
                    Your order now is included Free Shipping
                </v-card-text>
                <v-card-actions v-if="!5">
                    <v-btn
                        @click="drawer = false"
                        style="
                            text-transform: none;
                            border-radius: 30px;
                            border-color: #a5a2a2;
                        "
                        class="w-100"
                        variant="outlined"
                        density="compact"
                        height="45"
                    >
                        Continue Shopping
                    </v-btn>
                </v-card-actions>
            </v-card>

            <v-card
                class="pa-0 mt-5 items-card"
                elevation="0"
                v-if="cartItems.length"
                max-height="240"
                style="overflow-y: auto"
            >
                <v-container class="px-1">
                    <v-row
                        v-for="item in cartItems"
                        :key="item.id"
                        class="align-center mb-4"
                    >
                        <v-col cols="5">
                            <img
                                :src="item.thumbnail"
                                class="w-100"
                                alt="img"
                            />
                        </v-col>
                        <v-col cols="7">
                            <v-card-title
                                class="px-0"
                                style="
                                    white-space: pre-wrap;
                                    font-size: 14px;
                                    line-height: 1.2;
                                "
                                >{{ item.title }} Sample -
                                {{ item.category }}</v-card-title
                            >
                            <v-card-text
                                class="px-0 pb-0"
                                style="color: #6f6f6f"
                            >
                                Category : {{ item.category }}
                            </v-card-text>
                            <v-card-text class="px-1 pt-2 font-weight-bold">
                                {{
                                    Math.ceil(
                                        item.price -
                                            item.price *
                                                (item.discountPercentage / 100)
                                    ) * item.quantity
                                }}
                            </v-card-text>
                            <div
                                class="item-footer d-flex justify-space-between align-center"
                            >
                                <div
                                    class="counter px-1"
                                    style="
                                        border: 1px solid rgb(187, 187, 187);
                                        border-radius: 30px;
                                        width: fit-content;
                                    "
                                >
                                    <v-icon
                                        size="19"
                                        color="#a6a6a6"
                                        @click="
                                            item.quantity > 1
                                                ? item.quantity--
                                                : false
                                        "
                                        >mdi-minus</v-icon
                                    >
                                    <input
                                        type="number"
                                        style="
                                            border: none;
                                            outline: none;
                                            width: 35px;
                                            font-size: 12px;
                                        "
                                        class="text-center py-3"
                                        min="1"
                                        v-model="item.quantity"
                                    />
                                    <VIcon
                                        color="#a6a6a6"
                                        size="19"
                                        @click="item.quantity++"
                                        >mdi-plus</VIcon
                                    >
                                </div>
                                <v-icon size="22" @click="deleteItem(item.id)"
                                    >mdi-close</v-icon
                                >
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>

            <v-card class="p-0 mt-5" elevation="0" v-if="cartItems.length">
                <v-card-actions class="flex-column justify-center align-center">
                    <v-btn
                        style="
                            text-transform: none;
                            border-radius: 30px;
                            border-color: aliceblue;
                            gap: 10px;
                        "
                        variant="elevated"
                        elevation="0"
                        density="compact"
                        height="45"
                        class="w-100"
                        color="blue"
                        >View Cart</v-btn
                    >
                    <v-btn
                        style="
                            text-transform: none;
                            border-radius: 30px;
                            border-color: aliceblue;
                        "
                        variant="outlined"
                        density="compact"
                        height="45"
                        class="w-100 mx-0"
                        color="blue"
                        >Check Out</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    inject: ["Emitter"],
    data() {
        return {
            drawer: false,
            cartItems: [
                {
                    id: 1,
                    title: "Product 1",
                    price: 1,
                    category: "Shoes",
                    thumbnail: "/img/p1.jpg",
                    discountPercentage: 0,
                    quantity: 1,
                },
                {
                    id: 2,
                    title: "Product 2",
                    price: 500,
                    category: "Bags",
                    thumbnail: "/img/p2.jpg",
                    discountPercentage: 10,
                    quantity: 1,
                },
            ],
        };
    },
    computed: {
        calcTotalPrice() {
            return this.cartItems.reduce((sum, item) => {
                let price = Math.ceil(
                    item.price - item.price * (item.discountPercentage / 100)
                );
                return sum + price * item.quantity;
            }, 0);
        },
    },
    mounted() {
        this.Emitter.on("openCart", () => {
            this.drawer = true;
        });

        // أول ما يفتح الكارت يبعت العدد للـ Navbar
        this.Emitter.emit("cart-updated", this.cartItems.length);
    },
    methods: {
        deleteItem(id) {
            this.cartItems = this.cartItems.filter((item) => item.id !== id);
            this.Emitter.emit("cart-updated", this.cartItems.length);
        },
    },
};
</script>

<style lang="scss" scoped>
.items-card {
    &::-webkit-scrollbar {
        width: 5px;
    }
    &::-webkit-scrollbar-track {
        width: 5px;
        background: #f1f1f1;
    }
    &::-webkit-scrollbar-thumb {
        width: 5px;
        background: #88888891;
    }
}
</style>
