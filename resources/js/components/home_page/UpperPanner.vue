<template>
  <v-container fluid class="pa-0">
    <!-- Dynamic banners from DB -->
    <template v-if="banners && banners.length">
      <v-carousel
        v-if="banners.length > 1"
        hide-delimiter-background
        show-arrows="hover"
        cycle
        height="auto"
      >
        <v-carousel-item
          v-for="(banner, index) in banners"
          :key="index"
        >
          <a :href="banner.link || '#'" :target="banner.link ? '_blank' : '_self'">
            <v-img :src="banner.image" alt="Banner Image" cover />
          </a>
        </v-carousel-item>
      </v-carousel>

      <!-- Single banner — no carousel overhead -->
      <a v-else :href="banners[0].link || '#'" :target="banners[0].link ? '_blank' : '_self'">
        <v-img :src="banners[0].image" alt="Banner Image" cover />
      </a>
    </template>

    <!-- Fallback to static image when no banners in DB -->
    <v-img v-else :src="staticBanner" alt="Banner Image" cover />
  </v-container>
</template>

<script setup>
import staticBanner from "@/assets/images/banner-2.jpg";

defineProps({
  banners: {
    type: Array,
    default: () => [],
  },
});
</script>
