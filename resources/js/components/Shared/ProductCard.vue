<template>
    <v-card class="mx-auto my-12 product-card" max-width="374">
        <v-hover v-slot="{ isHovering, props }">
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
                    v-bind="props"
                />

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

            <v-card-subtitle>
                <span class="me-1">{{ item.parent.name }}</span>

                <v-icon
                    color="error"
                    icon="mdi-fire-circle"
                    size="small"
                ></v-icon>
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
                    style="
                        border: 1px solid rgba(110, 110, 110, 0.377);
                        border-radius: 50%;
                    "
                    alt="img"
                />
            </v-btn>
        </v-btn-toggle>

        <v-card-actions>
            <v-btn
            color="deep-purple-lighten-2"
            text="Reserve"
            block
            >
            <Link :href="route('productss.show', item.slug)">
                    تفاصيل المنتج
                </Link>
                </v-btn>
            <!-- <v-btn
                color="deep-purple-lighten-2"
                text="Reserve"
                block
            ></v-btn> -->
        </v-card-actions>
    </v-card>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["quick-view"]);

const currentImage = ref(props.item.image_url);

</script>

<style scoped>
.product-card:hover .quick-view-btn {
    opacity: 1 !important;
}
</style>
