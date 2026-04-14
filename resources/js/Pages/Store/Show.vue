<template>
    <div style="background:#f5f6fa; min-height:100vh">

        <!-- Enhanced Vendor Header with Cover Image -->
        <div style="position:relative; overflow:hidden">
            <!-- Cover Image or Gradient Background -->
            <div
                v-if="vendor.cover_image_url"
                :style="`background-image:url(${vendor.cover_image_url}); background-size:cover; background-position:center; height:300px; position:relative`"
            >
                <div :style="`position:absolute; inset:0; background:linear-gradient(135deg,${vendor.banner_color || '#1a237e'}dd,${adjustColor(vendor.banner_color || '#1a237e')}dd)`"></div>
            </div>
            <div
                v-else
                :style="`background:linear-gradient(135deg,${vendor.banner_color || '#1a237e'},${adjustColor(vendor.banner_color || '#1a237e')}); height:300px`"
            ></div>

            <!-- Vendor Profile Overlay -->
            <div style="position:absolute; bottom:0; left:0; right:0; padding:24px 16px">
                <div style="max-width:1200px; margin:0 auto">
                    <div style="display:flex; align-items:flex-end; gap:24px; flex-wrap:wrap">
                        <!-- Large Vendor Logo -->
                        <div style="width:150px; height:150px; background:white; border-radius:24px; display:flex; align-items:center; justify-content:center; overflow:hidden; box-shadow:0 12px 40px rgba(0,0,0,0.3); border:5px solid white">
                            <img v-if="vendor.image_url && !vendor.image_url.includes('no-image')"
                                 :src="vendor.image_url"
                                 style="width:100%; height:100%; object-fit:contain; padding:16px" />
                            <span v-else :style="`font-size:60px; font-weight:800; color:${vendor.banner_color || '#1a237e'}`">
                                {{ vendor.name?.charAt(0) }}
                            </span>
                        </div>

                        <!-- Vendor Details -->
                        <div style="flex:1; min-width:300px; padding-bottom:12px">
                            <h1 class="text-white font-weight-bold" style="font-size:40px; margin-bottom:12px; text-shadow:0 2px 12px rgba(0,0,0,0.3); line-height:1.2">
                                {{ vendor.name }}
                            </h1>
                            <p v-if="vendor.description" style="color:rgba(255,255,255,0.95); font-size:17px; margin-bottom:20px; max-width:800px; text-shadow:0 1px 6px rgba(0,0,0,0.2); line-height:1.5">
                                {{ vendor.description }}
                            </p>

                            <!-- Enhanced Stats Badges -->
                            <div style="display:flex; gap:12px; flex-wrap:wrap">
                                <!-- Rating Badge -->
                                <div style="background:rgba(255,255,255,0.3); backdrop-filter:blur(12px); padding:10px 18px; border-radius:28px; display:flex; align-items:center; gap:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15)">
                                    <v-icon color="white" size="22">mdi-star</v-icon>
                                    <div>
                                        <div class="text-white font-weight-bold" style="font-size:18px; line-height:1">{{ stats.rating }}</div>
                                        <div style="color:rgba(255,255,255,0.9); font-size:11px">{{ stats.total_reviews }} {{ t('reviews') }}</div>
                                    </div>
                                </div>

                                <!-- Products Badge -->
                                <div style="background:rgba(255,255,255,0.3); backdrop-filter:blur(12px); padding:10px 18px; border-radius:28px; display:flex; align-items:center; gap:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15)">
                                    <v-icon color="white" size="22">mdi-package-variant</v-icon>
                                    <div>
                                        <div class="text-white font-weight-bold" style="font-size:18px; line-height:1">{{ stats.total_products }}</div>
                                        <div style="color:rgba(255,255,255,0.9); font-size:11px">{{ t('products') }}</div>
                                    </div>
                                </div>

                                <!-- Top Rated Badge -->
                                <div v-if="vendor.rating >= 4.5" style="background:rgba(255,215,0,0.35); backdrop-filter:blur(12px); padding:10px 18px; border-radius:28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15)">
                                    <v-icon color="white" size="20">mdi-medal</v-icon>
                                    <span class="text-white font-weight-bold" style="font-size:14px">{{ t('top_rated') }}</span>
                                </div>

                                <!-- Verified Badge -->
                                <div v-if="vendor.status === 'active'" style="background:rgba(76,175,80,0.35); backdrop-filter:blur(12px); padding:10px 18px; border-radius:28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15)">
                                    <v-icon color="white" size="20">mdi-check-decagram</v-icon>
                                    <span class="text-white font-weight-bold" style="font-size:14px">{{ t('verified_vendor') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div style="max-width:1400px; margin:0 auto; padding:32px 16px">
            <v-row>
                <!-- Enhanced Sidebar -->
                <v-col cols="12" md="3">
                    <!-- Vendor Information Card -->
                    <v-card style="border-radius:16px; overflow:hidden; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08)">
                        <v-card-title :style="`background:${vendor.banner_color || '#1a237e'}; color:white; font-size:17px; font-weight:700; padding:16px`">
                            <v-icon color="white" size="20" class="mr-2">mdi-information</v-icon>
                            {{ t('vendor_info') }}
                        </v-card-title>
                        <v-card-text style="padding:20px">
                            <!-- Contact Info -->
                            <div v-if="vendor.phone" style="display:flex; align-items:center; gap:14px; margin-bottom:16px; padding:12px; background:#f8f9fa; border-radius:12px">
                                <div :style="`width:40px; height:40px; background:${vendor.banner_color || '#1a237e'}15; border-radius:10px; display:flex; align-items:center; justify-content:center`">
                                    <v-icon :color="vendor.banner_color || '#1a237e'" size="20">mdi-phone</v-icon>
                                </div>
                                <div style="flex:1">
                                    <div style="font-size:11px; color:#666; margin-bottom:2px">{{ t('phone') }}</div>
                                    <a :href="`tel:${vendor.phone}`" :style="`color:${vendor.banner_color || '#1a237e'}; text-decoration:none; font-weight:600; font-size:14px`">
                                        {{ vendor.phone }}
                                    </a>
                                </div>
                            </div>

                            <div v-if="vendor.email" style="display:flex; align-items:center; gap:14px; margin-bottom:16px; padding:12px; background:#f8f9fa; border-radius:12px">
                                <div :style="`width:40px; height:40px; background:${vendor.banner_color || '#1a237e'}15; border-radius:10px; display:flex; align-items:center; justify-content:center`">
                                    <v-icon :color="vendor.banner_color || '#1a237e'" size="20">mdi-email</v-icon>
                                </div>
                                <div style="flex:1; min-width:0">
                                    <div style="font-size:11px; color:#666; margin-bottom:2px">{{ t('email') }}</div>
                                    <a :href="`mailto:${vendor.email}`" :style="`color:${vendor.banner_color || '#1a237e'}; text-decoration:none; font-weight:600; font-size:13px; word-break:break-all`">
                                        {{ vendor.email }}
                                    </a>
                                </div>
                            </div>

                            <!-- Business Hours (if available) -->
                            <div v-if="vendor.business_hours" style="padding:12px; background:#f8f9fa; border-radius:12px; margin-bottom:16px">
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px">
                                    <v-icon :color="vendor.banner_color || '#1a237e'" size="18">mdi-clock-outline</v-icon>
                                    <span style="font-weight:600; font-size:13px">{{ t('business_hours') }}</span>
                                </div>
                                <div style="font-size:12px; color:#666; line-height:1.6">{{ vendor.business_hours }}</div>
                            </div>

                            <!-- Social Links -->
                            <div v-if="vendor.social_links && Object.keys(vendor.social_links).length" style="margin-top:20px; padding-top:20px; border-top:2px solid #f0f0f0">
                                <p style="font-size:14px; font-weight:700; margin-bottom:14px; color:#333">
                                    <v-icon size="16" class="mr-1">mdi-share-variant</v-icon>
                                    {{ t('follow_us') }}
                                </p>
                                <div style="display:flex; gap:10px; flex-wrap:wrap">
                                    <a v-if="vendor.social_links.facebook" :href="vendor.social_links.facebook" target="_blank" style="width:44px; height:44px; background:#1877f2; border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-facebook</v-icon>
                                    </a>
                                    <a v-if="vendor.social_links.twitter" :href="vendor.social_links.twitter" target="_blank" style="width:44px; height:44px; background:#1da1f2; border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-twitter</v-icon>
                                    </a>
                                    <a v-if="vendor.social_links.instagram" :href="vendor.social_links.instagram" target="_blank" style="width:44px; height:44px; background:linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-instagram</v-icon>
                                    </a>
                                    <a v-if="vendor.social_links.whatsapp" :href="vendor.social_links.whatsapp" target="_blank" style="width:44px; height:44px; background:#25d366; border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-whatsapp</v-icon>
                                    </a>
                                    <a v-if="vendor.social_links.youtube" :href="vendor.social_links.youtube" target="_blank" style="width:44px; height:44px; background:#ff0000; border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-youtube</v-icon>
                                    </a>
                                    <a v-if="vendor.social_links.tiktok" :href="vendor.social_links.tiktok" target="_blank" style="width:44px; height:44px; background:#000000; border-radius:12px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s" @mouseenter="$event.target.style.transform='translateY(-3px)'" @mouseleave="$event.target.style.transform='translateY(0)'">
                                        <v-icon color="white" size="20">mdi-music-note</v-icon>
                                    </a>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>

                    <!-- Policies Card -->
                    <v-card v-if="vendor.return_policy || vendor.shipping_policy" style="border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.08)">
                        <v-card-title :style="`background:${vendor.banner_color || '#1a237e'}; color:white; font-size:17px; font-weight:700; padding:16px`">
                            <v-icon color="white" size="20" class="mr-2">mdi-file-document</v-icon>
                            {{ t('policies') }}
                        </v-card-title>
                        <v-card-text style="padding:16px">
                            <v-expansion-panels flat>
                                <v-expansion-panel v-if="vendor.return_policy" style="border:1px solid #e0e0e0; border-radius:12px; margin-bottom:12px">
                                    <v-expansion-panel-title style="font-size:14px; font-weight:600; padding:14px">
                                        <v-icon size="18" :color="vendor.banner_color || '#1a237e'" style="margin-right:10px">mdi-package-variant-closed</v-icon>
                                        {{ t('return_policy') }}
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text style="font-size:13px; color:#555; line-height:1.7; padding:14px">
                                        {{ vendor.return_policy }}
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel v-if="vendor.shipping_policy" style="border:1px solid #e0e0e0; border-radius:12px">
                                    <v-expansion-panel-title style="font-size:14px; font-weight:600; padding:14px">
                                        <v-icon size="18" :color="vendor.banner_color || '#1a237e'" style="margin-right:10px">mdi-truck-delivery</v-icon>
                                        {{ t('shipping_policy') }}
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text style="font-size:13px; color:#555; line-height:1.7; padding:14px">
                                        {{ vendor.shipping_policy }}
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Main Content Area -->
                <v-col cols="12" md="9">
                    <!-- Products Section -->
                    <div style="margin-bottom:40px">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px">
                            <h2 style="font-size:28px; font-weight:800; color:#1a237e; display:flex; align-items:center; gap:12px">
                                <v-icon :color="vendor.banner_color || '#1a237e'" size="28">mdi-shopping</v-icon>
                                {{ t('vendor_products') }}
                            </h2>
                            <div style="background:#f0f2ff; padding:8px 16px; border-radius:20px; font-size:14px; font-weight:600; color:#1a237e">
                                {{ products.total }} {{ t('products') }}
                            </div>
                        </div>

                        <v-row v-if="products.data?.length">
                            <v-col v-for="product in products.data" :key="product.id" cols="6" sm="4" md="4" lg="3">
                                <ProductCard :item="product" @quick-view="openQuickView" />
                            </v-col>
                        </v-row>

                        <div v-else style="text-align:center; padding:80px 20px; background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05)">
                            <v-icon size="80" color="grey-lighten-1">mdi-shopping-outline</v-icon>
                            <p style="margin-top:16px; color:#9ca3af; font-size:17px; font-weight:500">{{ t('no_products_vendor') }}</p>
                        </div>

                        <div class="d-flex justify-center mt-8" v-if="products.last_page > 1">
                            <v-pagination
                                v-model="page"
                                :length="products.last_page"
                                total-visible="5"
                                rounded="lg"
                                :color="vendor.banner_color || '#1a237e'"
                                @update:model-value="goto"
                            />
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div v-if="reviews?.length" style="margin-top:48px">
                        <h2 style="font-size:28px; font-weight:800; color:#1a237e; margin-bottom:24px; display:flex; align-items:center; gap:12px">
                            <v-icon :color="vendor.banner_color || '#1a237e'" size="28">mdi-star-box</v-icon>
                            {{ t('customer_reviews') }}
                        </h2>

                        <v-card style="border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.08)">
                            <v-card-text style="padding:0">
                                <div v-for="(review, index) in reviews" :key="review.id"
                                     :style="`padding:24px; ${index < reviews.length - 1 ? 'border-bottom:1px solid #e0e0e0' : ''}`">
                                    <div style="display:flex; align-items:center; gap:14px; margin-bottom:12px">
                                        <div :style="`width:48px; height:48px; background:${vendor.banner_color || '#1a237e'}15; border-radius:50%; display:flex; align-items:center; justify-content:center`">
                                            <span :style="`font-weight:700; font-size:18px; color:${vendor.banner_color || '#1a237e'}`">
                                                {{ review.user?.name?.charAt(0) || 'U' }}
                                            </span>
                                        </div>
                                        <div style="flex:1">
                                            <p style="font-weight:700; font-size:15px; margin-bottom:4px">{{ review.user?.name || t('anonymous') }}</p>
                                            <div style="display:flex; align-items:center; gap:8px">
                                                <v-rating
                                                    :model-value="review.rating"
                                                    readonly
                                                    density="compact"
                                                    size="16"
                                                    color="amber"
                                                />
                                                <span style="font-size:12px; color:#999">
                                                    {{ formatDate(review.created_at) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <p style="font-size:14px; color:#444; line-height:1.7; padding-left:62px">{{ review.comment }}</p>
                                </div>
                            </v-card-text>
                        </v-card>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, inject } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductCard from '../../components/Shared/ProductCard.vue';
import { useLocale } from '../../composables/useLocale';

const { t } = useLocale();
const props = defineProps({
    vendor: Object,
    products: Object,
    reviews: Array,
    stats: Object
});

const Emitter = inject('Emitter');
const page = ref(props.products.current_page);

function goto(val) {
    router.visit(`/store/${props.vendor.slug}?page=${val}`, {
        preserveState: true,
        preserveScroll: true
    });
}

function openQuickView(product) {
    Emitter.emit('openQuickView', product);
}

function adjustColor(hex) {
    const num = parseInt(hex.replace('#', ''), 16);
    const r = Math.min(255, (num >> 16) + 40);
    const g = Math.min(255, ((num >> 8) & 0x00FF) + 40);
    const b = Math.min(255, (num & 0x0000FF) + 40);
    return `#${((r << 16) | (g << 8) | b).toString(16).padStart(6, '0')}`;
}

function formatDate(date) {
    return new Date(date).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

watch(() => props.products.current_page, (val) => page.value = val);
</script>
