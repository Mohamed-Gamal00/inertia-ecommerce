<template>
    <v-card elevation="0" class="product-card">
        <v-hover v-slot="{ isHovering, props }">
            <div
                class="img-parent position-relative"
                style="height: 200px; overflow: hidden"
            >
                <img
                    :src="item.image_url"
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
                    width="80"
                    height="32"
                    variant="outlined"
                    class="bg-white quick-view-btn"
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

        <v-card-text class="pl-0 pb-1 pr-10">
            {{ shortText(`(${item.name})`, 40) }}
        </v-card-text>

        <v-rating
            v-model="item.rating"
            half-increments
            readonly
            color="yellow-darken-2"
            size="x-small"
            density="compact"
        />

        <v-card-text class="pl-0 pt-0">
            <del>${{ item.price }}</del>
            from
            <span class="text-red" style="font-weight: 900; font-size: 16px">
                ${{
                    Math.ceil(
                        item.price - item.price * (item.discount_price / 100)
                    )
                }}
            </span>
        </v-card-text>

        <v-btn-toggle v-model="currentImage">
            <v-btn
                v-for="(pic, i) in item.images"
                :key="i"
                :value="pic"
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

        <div class="mt-5">
            <Link :href="route('productss.show', item.slug)" class="text-none">
                <v-btn
                    style="text-transform: none; border-radius: 30px"
                    density="default"
                    variant="outlined"
                    class="py-3 px-12"
                >
                    تفاصيل المنتج
                </v-btn>
            </Link>
        </div>
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

const shortText = (text, limit) =>
    text.length <= limit ? text : text.substring(0, limit) + "...";
</script>

<style scoped>
.product-card:hover .quick-view-btn {
    opacity: 1 !important;
}
</style>
