<template>
  <div class="top-offers py-9" :style="{ backgroundColor: bgColor }" v-if="offers.length">
    <v-container fluid>
      <div class="offers-grid">
        <div
          v-for="(offer, index) in offers"
          :key="offer.id"
          class="offer-card"
          :class="index < 3 ? 'offer-card--top' : 'offer-card--bottom'"
        >
          <div class="offer-image-wrapper">
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
      </div>
    </v-container>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

defineProps({
  bgColor: {
    type: String,
    default: '#E6D3BB' // Latte Beige fallback
  }
});

const offers = computed(() => usePage().props.topOffers || []);
</script>

<style scoped>
.offers-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 20px;
}

.offer-card {
  position: relative;
  width: 100%;
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
}

.offer-card--top {
  grid-column: span 2;
}

.offer-card--bottom {
  grid-column: span 3;
}

/* Aspect ratio container to prevent overlapping */
.offer-image-wrapper {
  position: relative;
  width: 100%;
  padding-bottom: 60%; /* 5:3 aspect ratio */
  overflow: hidden;
  border-radius: 12px;
  background: var(--brand-border);
}

.offer-image {
  position: absolute;
  top: 0;
  left: 0;
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

  .offer-card--top,
  .offer-card--bottom {
    grid-column: span 6;
  }

  .offer-image-wrapper {
    padding-bottom: 65%; /* Slightly taller on mobile */
  }
}
</style>
