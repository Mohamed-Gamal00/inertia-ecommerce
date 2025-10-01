<template>
  <div class="shop-withus py-14">
    <div class="title mb-5">
      <h2 class="text-center"><span>Why Shop </span> With Us</h2>
    </div>
    <v-container fluid>
      <v-row>
        <v-col cols="3" v-for="card in cards" :key="card">
          <v-card
            elevation="0"
            class="text-center text-white px-1"
            color="transparent"
          >
            <div class="image-parent">
              <img :src="card.image" alt="free-shipping" />
            </div>
            <v-card-title
              style="white-space: pre-wrap; line-height: 1.2; font-weight: 700"
            >
              {{ card.title }}
            </v-card-title>
            <v-card-text class="pb-0" style="font-size: 15px">
              {{ card.desc }}
            </v-card-text>
            <a href="#" style="color: white; font-weight: 700; font-size: 14px"
              >Learn More</a
            >
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
      cards: [
        {
          title: "Free Shipping On Frist Order",
          desc: "Lorem ipsum dolor sit amet consectetur",
          image: require("@/assets/images/free-shipping.png"),
        },
        {
          title: "Weekly Flash Sale",
          desc: "Lorem ipsum dolor sit amet consectetur",
          image: require("@/assets/images/weekly-flash-sales.png"),
        },
        {
          title: "Anual Payment Discount",
          desc: "Lorem ipsum dolor sit amet consectetur",
          image: require("@/assets/images/discount.png"),
        },
        {
          title: "Cashback Reward Program",
          desc: "Lorem ipsum dolor sit amet consectetur",
          image: require("@/assets/images/cash-back.png"),
        },
      ],
    };
  },
};
</script>

<style lang="scss" scoped>
.shop-withus {
  background-image: url("@/assets/images/why-shop-with-us-banner.webp");
  background-repeat: repeat-x;
  background-size: cover;
  h2 {
    color: white;
    font-size: 30px;
    font-weight: 900;
    span {
      color: rgb(45, 251, 223);
    }
  }
}
</style>
