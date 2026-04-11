<template>
    <div class="categories pt-12 pb-6">
        <div class="title d-flex justify-center align-center px-5 mb-6">
            <h3 class="text-center flex-grow-1 font-weight-bold" style="font-size:22px">
                {{ t('top_categories_title') }}
            </h3>
            <a href="/categories" class="text-decoration-none text-primary" style="font-size:14px; font-weight:600">
                {{ t('shop_all') }}
            </a>
        </div>

        <v-container fluid>
            <div v-if="categories.length" style="display:flex; flex-wrap:wrap; justify-content:center; align-items:flex-start; gap:12px; padding:8px 0">
                <a
                    v-for="cat in categories"
                    :key="cat.id"
                    :href="`/categories/${cat.slug}`"
                    style="display:block; width:120px; text-decoration:none; flex-shrink:0; text-align:center"
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
</script>

<style scoped>
.cat-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    background: #e8eaf6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e5e7eb;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.cat-circle img { width: 100%; height: 100%; object-fit: cover; }

.cat-name {
    margin-top: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    text-align: center;
    max-width: 90px;
    line-height: 1.3;
}

@media (max-width: 599px) {
    .cat-circle { width: 72px; height: 72px; }
    .cat-name { font-size: 11px; max-width: 72px; }
}
</style>
