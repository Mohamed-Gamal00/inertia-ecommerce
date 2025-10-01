<template>
            <v-app-bar color="#02218f" dark flat>
                <v-container fluid>
                    <v-row align="center" justify="space-between">
                        <!-- اللوجو -->
                        <v-col cols="2">
                            <h2 class="text-white">MyShop</h2>
                        </v-col>

                        <!-- البحث -->
                        <v-col cols="3">
                            <v-text-field
                                density="comfortable"
                                variant="solo"
                                rounded="pill"
                                placeholder="Search the store"
                                prepend-inner-icon="mdi-magnify"
                                hide-details
                                bg-color="white"
                            />
                        </v-col>
                        <!-- كول أيكونز -->
                        <v-col cols="7" class="d-flex justify-end align-center" style="gap: 25px">
                            <!-- Available -->
                            <div class="text-white">
                                <small>Available 24/7 at</small><br />
                                <strong>(090)-123-4567</strong>
                            </div>

                            <!-- WishList -->
                            <div class="d-flex flex-column align-center">
                                <span style="color: #ffb547">Wish List</span>
                            </div>

                            <!-- Sign in -->
                            <div class="d-flex flex-column align-center">
                                <Link href="/login" style="color: #ffb547; text-decoration: none">Sign In</Link>
                            </div>

                            <!-- Cart -->
                            <div class="d-flex flex-column align-center" style="cursor: pointer" @click="openCart">
                                <v-badge :content="cartItems.length" color="error" offset-x="-8">
                                    <v-icon color="white">mdi-cart</v-icon>
                                </v-badge>
                                <span style="color: #ffb547">Cart</span>
                            </div>
                        </v-col>
                    </v-row>

                    <!-- الروابط -->
                    <v-row class="mt-2">
                        <v-col>
                            <ul class="d-flex text-white" style="gap: 20px; list-style: none; padding: 0; margin: 0">
                                <li v-for="category in categories" :key="category.title">
                                    <Link
                                        :href="`/products/${category.route}/${category.title}`"
                                        style="color: white; text-decoration: none"
                                    >
                                        {{ category.title }}
                                    </Link>
                                </li>
                            </ul>
                        </v-col>
                        <!-- Lang -->
                        <v-col class="d-flex justify-end">
                            <v-menu>
                                <template #activator="{ props }">
                                    <div v-bind="props" class="d-flex align-center text-white" style="gap: 5px; cursor: pointer">
                                        <span v-html="selectedLang.icon"></span>
                                        <span>{{ selectedLang.lang }} / {{ selectedLang.currency }}</span>
                                        <v-icon>mdi-chevron-down</v-icon>
                                    </div>
                                </template>

                                <v-list>
                                    <v-list-item
                                        v-for="lang in langs"
                                        :key="lang.lang"
                                        @click="selectedLang = lang"
                                    >
                                        <v-list-item-title class="d-flex align-center" style="gap: 10px">
                                            <span v-html="lang.icon"></span>
                                            {{ lang.lang }} / {{ lang.currency }}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-col>
                    </v-row>
                </v-container>
            </v-app-bar>

</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

// كارت مؤقت للتجربة
const cartItems = ref([1, 2])

// كاتيجوريز وهمية مؤقتًا
const categories = ref([
    { title: 'Electronics', route: 'electronics' },
    { title: 'Fashion', route: 'fashion' },
    { title: 'Sports', route: 'sports' },
])

// اللغة
const langs = ref([
    { icon: "🇺🇸", lang: "EN", currency: "USD" },
    { icon: "🇪🇺", lang: "ED", currency: "EURO" },
])
const selectedLang = ref(langs.value[0])

// cart open method
function openCart() {
    alert('Cart opened!')
}
</script>

<style scoped>
.v-app-bar {
    padding: 10px 0;
}
</style>
