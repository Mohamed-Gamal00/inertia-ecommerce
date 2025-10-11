<template>
    <div class="top_cat">
        <div class="cyber-banner">
            <!--      <img src="@/assets/images/cyber-banner.webp" class="w-100" alt="banner" />-->
        </div>
    </div>
    <div class="categories pt-13">
        <div class="title d-flex justify-center align-center px-5 mb-3">
            <h3 class="text-center flex-grow-1" style="font-weight: 900">
                Top Categpries
            </h3>
            <a href="#" class="text-black">Shop All</a>
        </div>
        <v-container fluid>
            <v-row>
                <v-col
                    v-for="cat in categories"
                    :key="cat.title"
                    cols="6"
                    sm="6"
                    md="4"
                    lg="2"
                    xl="2"
                    class="d-flex justify-center"
                >
                    <v-card
                        class="text-center py-3 px-2"
                        elevation="0"
                        style="max-width: 200px"
                    >
                        <v-hover v-slot="{ isHovering, props }">
                            <div
                                class="img-parent"
                                style="
                                    overflow: hidden;
                                    width: 150px;
                                    height: 150px;
                                    margin: auto;
                                    border-radius: 50%;
                                "
                            >
                                <img
                                    :src="cat.image"
                                    alt="image"
                                    :style="`
              cursor: pointer;
              height:100%;
              width:100%;
              object-fit: cover;
              transition: all 0.3s ease-in-out;
              scale: ${isHovering ? 1.05 : 1};
            `"
                                    v-bind="props"
                                />
                            </div>
                        </v-hover>
                        <v-card-text class="mt-2 font-weight-medium">{{
                            cat.title
                        }}</v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: [
                {
                    title: "Moblie phones",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/mobile-phones.png?v=1646386792",
                },
                {
                    title: "Laptops & Tablets",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/laptops-tablets.png?v=1646386795",
                },
                {
                    title: "Televisions",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/televisions.png?v=1646386798",
                },
                {
                    title: "PCs & Accessories",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-4_170x.png?v=1646386801",
                },
                {
                    title: "Audio & Video",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-5_170x.png?v=1646386804",
                },
                {
                    title: "Gaming & Accessories",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-6_170x.png?v=1646386806",
                },
                {
                    title: "Moblie phones",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-1_170x.png?v=1646386792",
                },
                {
                    title: "PCs & Accessories",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-4_170x.png?v=1646386801",
                },
                {
                    title: "Audio & Video",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-5_170x.png?v=1646386804",
                },
                {
                    title: "Gaming & Accessories",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-6_170x.png?v=1646386806",
                },
                {
                    title: "Moblie phones",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/home-20-categories-1-1_170x.png?v=1646386792",
                },
                {
                    title: "Laptops & Tablets",
                    image: "https://new-ella-demo.myshopify.com/cdn/shop/files/laptops-tablets.png?v=1646386795",
                },
            ],
        };
    },
};
</script>

<style lang="scss" scoped></style>
