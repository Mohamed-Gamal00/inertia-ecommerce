
<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:40px 16px 50px">
            <SeoHead :title="t('all_categories_title')" />
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">{{ t('all_categories_title') }}</h1>
            <p class="text-center mt-2" style="color:rgba(255,255,255,0.75); font-size:14px">
                {{ t('browse_categories') }} {{ categories.length }} {{ t('available_categories') }}
            </p>
        </div>
        <div style="padding:32px 16px">
            <div v-if="categories.length" style="display:flex; flex-wrap:wrap; justify-content:center; align-items:flex-start; gap:16px">
                <a v-for="cat in categories" :key="cat.id" :href="`/categories/${cat.slug}`"
                    style="display:block; width:160px; text-decoration:none; flex-shrink:0">
                    <div class="cat-card">
                        <div class="cat-img-wrap">
                            <img v-if="cat.image_url" :src="cat.image_url" :alt="pick(cat,'name')" />
                            <v-icon v-else size="40" color="primary">mdi-shape-outline</v-icon>
                        </div>
                        <div style="font-size:13px; font-weight:600; color:#111827; text-align:center; margin-top:10px; line-height:1.3">
                            {{ pick(cat, 'name') }}
                        </div>
                    </div>
                </a>
            </div>
            <div v-else style="text-align:center; padding:64px 0">
                <v-icon size="64" color="grey-lighten-1">mdi-shape-outline</v-icon>
                <p style="margin-top:12px; color:#9ca3af">{{ t('no_categories') }}</p>
            </div>
        </div>
    </div>
</template>


<script setup>
import SeoHead from '../../components/Shared/SeoHead.vue';
import { useLocale } from '../../composables/useLocale';
const { t, pick } = useLocale();
defineProps({ categories: Array });
</script>

<style scoped>
.cat-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 16px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    cursor: pointer;
}

.cat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(57,73,171,0.12);
    border-color: #3949ab;
}

.cat-img-wrap {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    background: #e8eaf6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e5e7eb;
    margin: 0 auto;
    transition: border-color 0.2s;
}

.cat-card:hover .cat-img-wrap { border-color: #3949ab; }

.cat-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
</style>
