<template>
    <div class="categories pt-12 pb-6" :style="{ backgroundColor: bgColor }">
        <div class="title d-flex justify-center align-center px-5 mb-6">
            <h3 class="text-center flex-grow-1 font-weight-bold" style="font-size:22px">
                {{ t('top_categories_title') }}
            </h3>
            <a href="/categories" class="text-decoration-none text-primary" style="font-size:14px; font-weight:600">
                {{ t('shop_all') }}
            </a>
        </div>

        <v-container>
            <div v-if="categories.length" class="categories-grid">
                <a
                    v-for="cat in categories"
                    :key="cat.id"
                    :href="`/categories/${cat.slug}`"
                    class="category-item"
                >
                    <div class="cat-circle">
                        <img v-if="cat.image_url" :src="cat.image_url" :alt="pick(cat,'name')" />
                        <v-icon v-else size="36" color="primary">mdi-shape-outline</v-icon>
                    </div>
                    <div class="cat-name">{{ pick(cat, 'name') }}</div>
                </a>
            </div>
        </v-container>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
const { t, pick } = useLocale();
const categories = computed(() => usePage().props.categories ?? []);

defineProps({
  bgColor: {
    type: String,
    default: '#E6D3BB' // Latte Beige fallback
  }
});
</script>

<style scoped>
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
    gap: 20px;
    justify-items: center;
    padding: 8px;
    max-width: 1000px;
    margin: 0 auto;
}

.category-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    width: 100%;
    max-width: 120px;
}

.cat-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    background: rgba(118, 84, 61, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #D7CDBD;
    transition: all 0.2s;
    margin: 0 auto;
}

.category-item:hover .cat-circle {
    border-color: #76543D;
    box-shadow: 0 4px 12px rgba(118, 84, 61, 0.15);
    transform: translateY(-2px);
}

.cat-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cat-name {
    margin-top: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #302F2B;
    text-align: center;
    line-height: 1.3;
    width: 100%;
}

/* Mobile adjustments */
@media (max-width: 599px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
        gap: 16px;
        padding: 4px;
    }

    .category-item {
        max-width: 100px;
    }

    .cat-circle {
        width: 75px;
        height: 75px;
    }

    .cat-name {
        font-size: 11px;
        margin-top: 8px;
    }
}

/* Tablet adjustments */
@media (min-width: 600px) and (max-width: 959px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 18px;
    }

    .cat-circle {
        width: 85px;
        height: 85px;
    }
}
</style>
