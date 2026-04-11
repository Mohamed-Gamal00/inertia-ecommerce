<template>
    <div class="quality py-12" style="background:#f5f6fa">
        <v-container>
            <h2 class="text-center font-weight-bold mb-8" style="font-size:22px; color:#111827">
                {{ t('why_us_title') }}
            </h2>
            <v-row>
                <v-col
                    v-for="card in cards"
                    :key="card.title"
                    cols="6"
                    sm="6"
                    md="4"
                    lg="2"
                >
                    <v-hover v-slot="{ isHovering, props: hoverProps }">
                        <v-card
                            v-bind="hoverProps"
                            class="text-center pa-4"
                            :elevation="isHovering ? 4 : 0"
                            rounded="xl"
                            :color="isHovering ? 'primary' : 'white'"
                            style="transition: all 0.25s ease; cursor:pointer; height:100%"
                        >
                            <div
                                class="mx-auto mb-3 d-flex align-center justify-center"
                                style="width:56px; height:56px; border-radius:14px; background:#e8eaf6"
                            >
                                <span v-html="card.svg" />
                            </div>
                            <div
                                class="font-weight-bold mb-1"
                                style="font-size:12px; text-transform:uppercase; letter-spacing:0.3px"
                                :style="{ color: isHovering ? 'white' : '#111827' }"
                            >
                                {{ card.title }}
                            </div>
                            <div
                                style="font-size:11px; line-height:1.5"
                                :style="{ color: isHovering ? 'rgba(255,255,255,0.85)' : '#9ca3af' }"
                            >
                                {{ card.desc }}
                            </div>
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useLocale } from '../../composables/useLocale';
const { t } = useLocale();

const svgs = {
    quality: `<svg style="width:28px" viewBox="0 0 536 512" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#3949ab"/><stop offset="100%" stop-color="#1a237e"/></linearGradient></defs><path fill="url(#g1)" d="M508.55 171.51L362.18 150.2 296.77 17.81C290.89 5.98 279.42 0 267.95 0c-11.4 0-22.79 5.9-28.69 17.81l-65.43 132.38-146.38 21.29c-26.25 3.8-36.77 36.09-17.74 54.59l105.89 103-25.06 145.48C86.98 495.33 103.57 512 122.15 512c4.93 0 10-1.17 14.87-3.75l130.95-68.68 130.94 68.7c4.86 2.55 9.92 3.71 14.83 3.71 18.6 0 35.22-16.61 31.66-37.4l-25.03-145.49 105.91-102.98c19.04-18.5 8.52-50.8-17.73-54.6z"/></svg>`,
    warehouses: `<svg style="width:28px" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#3949ab"/><stop offset="100%" stop-color="#1a237e"/></linearGradient></defs><path fill="url(#g2)" d="M504 352H136.4c-4.4 0-8 3.6-8 8l-.1 48c0 4.4 3.6 8 8 8H504c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zm0 96H136.1c-4.4 0-8 3.6-8 8l-.1 48c0 4.4 3.6 8 8 8h368c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zm0-192H136.6c-4.4 0-8 3.6-8 8l-.1 48c0 4.4 3.6 8 8 8H504c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zm106.5-139L338.4 3.7a48.15 48.15 0 0 0-36.9 0L29.5 117C11.7 124.5 0 141.9 0 161.3V504c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8V256c0-17.6 14.6-32 32.6-32h382.8c18 0 32.6 14.4 32.6 32v248c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8V161.3c0-19.4-11.7-36.8-29.5-44.3z"/></svg>`,
    shipping: `<svg style="width:28px" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#3949ab"/><stop offset="100%" stop-color="#1a237e"/></linearGradient></defs><path fill="url(#g3)" d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"/></svg>`,
    payment: `<svg style="width:28px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#3949ab"/><stop offset="100%" stop-color="#1a237e"/></linearGradient></defs><path fill="url(#g4)" d="M466.5 83.7l-192-80a48.15 48.15 0 0 0-36.9 0l-192 80C27.7 91.1 16 108.6 16 128c0 198.5 114.5 335.7 221.5 380.3 11.8 4.9 25.1 4.9 36.9 0C360.1 472.6 496 349.3 496 128c0-19.4-11.7-36.9-29.5-44.3z"/></svg>`,
    support: `<svg style="width:28px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g5" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#3949ab"/><stop offset="100%" stop-color="#1a237e"/></linearGradient></defs><path fill="url(#g5)" d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z"/></svg>`,
};

const cards = computed(() => [
    { title: t('why_quality'),    desc: t('why_quality_desc'),    svg: svgs.quality },
    { title: t('why_warehouses'), desc: t('why_warehouses_desc'), svg: svgs.warehouses },
    { title: t('why_shipping'),   desc: t('why_shipping_desc'),   svg: svgs.shipping },
    { title: t('why_payment'),    desc: t('why_payment_desc'),    svg: svgs.payment },
    { title: t('why_support'),    desc: t('why_support_desc'),    svg: svgs.support },
]);
</script>
