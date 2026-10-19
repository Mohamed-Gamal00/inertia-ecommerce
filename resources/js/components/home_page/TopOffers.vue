<template>
  <div class="top-offer bg-grey-lighten-4 py-9" v-if="offers.length">
    <v-container fluid>
      <!-- Top row: 3 images -->
      <v-row v-if="topRow.length">
        <v-col
          v-for="offer in topRow"
          :key="offer.id"
          cols="12"
          sm="6"
          md="4"
          class="py-0"
          :class="{ 'pr-6': offer !== topRow[topRow.length - 1] }"
        >
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="offer-image-wrapper"
              v-bind="props"
            >
              <img
                :src="offer.image_url"
                :alt="offer.description || offer.title"
                :title="offer.description"
                :style="`transform: scale(${isHovering ? 1.05 : 1})`"
                class="offer-image"
              />
            </div>
          </v-hover>
        </v-col>
      </v-row>

      <!-- Bottom row: 2 images -->
      <v-row class="mt-8" v-if="bottomRow.length">
        <v-col
          v-for="offer in bottomRow"
          :key="offer.id"
          cols="12"
          sm="6"
          class="mt-3 py-0"
        >
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="offer-image-wrapper"
              :class="{ 'pr-2': offer === bottomRow[0], 'pl-2': offer === bottomRow[1] }"
              v-bind="props"
            >
              <img
                :src="offer.image_url"
                :alt="offer.description || offer.title"
                :title="offer.description"
                :style="`transform: scale(${isHovering ? 1.05 : 1})`"
                class="offer-image"
              />
            </div>
          </v-hover>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const offers = computed(() => usePage().props.topOffers || []);

// Split offers into top row (first 3) and bottom row (remaining 2)
const topRow = computed(() => offers.value.slice(0, 3));
const bottomRow = computed(() => offers.value.slice(3, 5));
</script>

<style scoped>
.offer-image-wrapper {
  overflow: hidden;
  border-radius: 8px;
  height: 100%;
  position: relative;
  background: #F7F0E5;
}

.offer-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
  transition: transform 0.5s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 959px) {
  .offer-image-wrapper {
    height: 200px;
  }
}

@media (max-width: 599px) {
  .offer-image-wrapper {
    height: 180px;
  }
}
</style>
