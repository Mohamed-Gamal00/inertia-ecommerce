<template>
    <div class="shop-withus py-14">
        <div class="title mb-8">
            <h2 class="text-center"><span>Why Shop</span> With Us</h2>
        </div>

        <v-container fluid>
            <v-row class="justify-center">
                <v-col
                    v-for="(card, index) in cards"
                    :key="index"
                    cols="12"
                    sm="6"
                    md="3"
                    class="d-flex justify-center"
                >
                    <v-card
                        elevation="0"
                        class="text-center text-white px-3 py-6"
                        color="transparent"
                    >
                        <div class="image-parent mb-4">
                            <img
                                :src="card.image"
                                :alt="card.title"
                                width="90"
                                height="90"
                                style="object-fit: contain"
                            />
                        </div>

                        <v-card-title
                            style="white-space: pre-wrap; line-height: 1.3; font-weight: 700"
                        >
                            {{ card.title }}
                        </v-card-title>

                        <v-card-text
                            class="pb-0 px-3"
                            style="font-size: 15px; opacity: 0.85"
                        >
                            {{ card.desc }}
                        </v-card-text>

                        <a
                            href="#"
                            class="learn-more"
                            style="color: white; font-weight: 700; font-size: 14px"
                        >
                            Learn More
                        </a>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    name: "WhyShopWithUs",
    data() {
        return {
            cards: [
                {
                    title: "Free Shipping On First Order",
                    desc: "Get your first order delivered for free anywhere.",
                    image: new URL('@/assets/images/free-shipping.png', import.meta.url).href,
                },
                {
                    title: "Weekly Flash Sale",
                    desc: "Save big with discounts every weekend.",
                    image: new URL('@/assets/images/weekly-flash-sales.png', import.meta.url).href,
                },
                {
                    title: "Annual Payment Discount",
                    desc: "Pay annually and enjoy exclusive savings.",
                    image: new URL('@/assets/images/discount.png', import.meta.url).href,
                },
                {
                    title: "Cashback Reward Program",
                    desc: "Earn cashback on every purchase you make.",
                    image: new URL('@/assets/images/cash-back.png', import.meta.url).href,
                },
            ],
        };
    },
};
</script>

<style lang="scss" scoped>
.shop-withus {
    background-image: url("@/assets/images/why-shop-with-us-banner.webp");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    text-align: center;

    h2 {
        color: white;
        font-size: 34px;
        font-weight: 900;
        span {
            color: rgb(45, 251, 223);
            margin-right: 6px;
        }
    }

    .learn-more {
        text-decoration: underline;
        transition: 0.3s;
        &:hover {
            color: rgb(45, 251, 223);
        }
    }

    @media (max-width: 960px) {
        .v-card {
            padding: 30px 10px;
        }
        h2 {
            font-size: 26px;
        }
    }
}
</style>
