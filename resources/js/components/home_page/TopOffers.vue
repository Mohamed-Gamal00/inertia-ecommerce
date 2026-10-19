<template>
  <div class="top-offers py-9" v-if="offers.length">
    <v-container fluid>
      <div class="offers-grid">
        <div
          v-for="(offer, index) in offers"
          :key="offer.id"
          class="offer-card"
          :class="index < 3 ? 'offer-card--top' : 'offer-card--bottom'"
        >
          <img
            :src="offer.image_url"
            :alt="offer.description || offer.title"
            :title="offer.description"
            class="offer-image"
            loading="lazy"
            decoding="async"
          />
        </div>
      </div>
    </v-container>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const offers = computed(() => usePage().props.topOffers || []);
</script>

<style scoped>
.top-offers {
  background:  #d7cdbd;
}

.offers-grid {
  display: grid;
  grid-template-columns: repeat(6, minmax(0, 1fr));
  gap: 20px;
}

.offer-card {
  position: relative;
  height: clamp(180px, 15vw, 240px);
  min-width: 0;
  overflow: hidden;
  border-radius: 12px;
  background: var(--brand-latte, #ff8000);
  cursor: pointer;
}

.offer-card--top {
  grid-column: span 2;
}

.offer-card--bottom {
  grid-column: span 3;
}

.offer-image {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.5s ease-in-out;
}

.offer-card:hover .offer-image {
  transform: scale(1.05);
}

@media (max-width: 959px) {
  .offers-grid {
    gap: 16px;
  }

  .offer-card {
    height: 200px;
  }

  .offer-card--top {
    grid-column: span 3;
  }

  .offer-card--top:nth-child(3) {
    grid-column: span 6;
  }

  .offer-card--bottom {
    grid-column: span 6;
  }
}

@media (max-width: 599px) {
  .offers-grid {
    gap: 12px;
  }

  .offer-card {
    height: 170px;
  }

  .offer-card--top,
  .offer-card--bottom {
    grid-column: span 6;
  }
}
</style>
