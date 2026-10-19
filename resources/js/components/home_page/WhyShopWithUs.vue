<template>
    <div class="shop-withus py-14">
        <v-container>
            <!-- Section Title -->
            <div class="text-center mb-8">
                <h2 class="section-title mb-3">
                    {{ t('why_us_title') }}
                </h2>
            </div>

            <!-- Cards Grid -->
            <v-row class="justify-center">
                <v-col
                    v-for="(card, index) in cards"
                    :key="index"
                    cols="12"
                    sm="6"
                    md="3"
                    class="d-flex"
                >
                    <v-hover v-slot="{ isHovering, props: hoverProps }">
                        <v-card
                            v-bind="hoverProps"
                            class="feature-card text-center pa-6"
                            :elevation="isHovering ? 4 : 1"
                            rounded="xl"
                            :class="[
                                { 'feature-card--hover': isHovering },
                                index % 2 === 0 ? 'feature-card--green' : 'feature-card--gold'
                            ]"
                        >
                            <!-- Icon Container -->
                            <div class="icon-wrapper mx-auto mb-4">
                                <img
                                    :src="card.image"
                                    :alt="card.title"
                                    width="70"
                                    height="70"
                                    style="object-fit: contain"
                                />
                            </div>

                            <!-- Title -->
                            <h3 class="card-title mb-2">
                                {{ card.title }}
                            </h3>

                            <!-- Description -->
                            <p class="card-desc mb-0">
                                {{ card.desc }}
                            </p>
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

const cards = computed(() => [
    {
        title: t('why_quality'),
        desc:  t('why_quality_desc'),
        image: new URL('@/assets/images/free-shipping.png', import.meta.url).href,
    },
    {
        title: t('why_shipping'),
        desc:  t('why_shipping_desc'),
        image: new URL('@/assets/images/weekly-flash-sales.png', import.meta.url).href,
    },
    {
        title: t('why_payment'),
        desc:  t('why_payment_desc'),
        image: new URL('@/assets/images/discount.png', import.meta.url).href,
    },
    {
        title: t('why_support'),
        desc:  t('why_support_desc'),
        image: new URL('@/assets/images/cash-back.png', import.meta.url).href,
    },
]);
</script>

<style lang="scss" scoped>
.shop-withus {
    background: #F7F0E5; /* Warm cream background */
    text-align: center;
}

/* Section Header */
.section-title {
    font-size: 32px;
    font-weight: 800;
    color: #302F2B; /* Deep charcoal */
    letter-spacing: -0.5px;

    @media (max-width: 600px) {
        font-size: 24px;
    }
}

.section-subtitle {
    font-size: 16px;
    color: #77736B; /* Muted gray */
    font-weight: 400;

    @media (max-width: 600px) {
        font-size: 14px;
    }
}

/* Feature Cards */
.feature-card {
    width: 100%;
    height: 100%;
    transition: all 0.3s ease;
    border: none;

    /* Mocha card */
    &--green {
        background: #76543D;

        .card-title,
        .card-desc {
            color: white;
        }

        .icon-wrapper {
            background: rgba(255, 255, 255, 0.15);
        }
    }

    /* Caramel card */
    &--gold {
        background: #C69763;

        .card-title {
            color: #302F2B;
        }

        .card-desc {
            color: #302F2B;
            opacity: 0.85;
        }

        .icon-wrapper {
            background: rgba(118, 84, 61, 0.15);
        }
    }

    &--hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(48, 47, 43, 0.15);
    }
}

/* Icon Wrapper */
.icon-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

/* Card Content */
.card-title {
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;

    @media (max-width: 600px) {
        font-size: 16px;
    }
}

.card-desc {
    font-size: 14px;
    line-height: 1.6;

    @media (max-width: 600px) {
        font-size: 13px;
    }
}

/* Responsive adjustments */
@media (max-width: 960px) {
    .feature-card {
        margin-bottom: 16px;
    }
}
</style>
