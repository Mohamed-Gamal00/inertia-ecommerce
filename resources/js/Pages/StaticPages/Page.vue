<template>
    <div style="background:#f7f0e5; min-height:100vh; padding-bottom:48px">
        <div style="background:linear-gradient(135deg,#76543D,#8d6b51); padding:40px 16px 50px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:28px">{{ page?.title || t('home') }}</h1>
        </div>

        <div style="max-width:800px; margin:32px auto; padding:0 16px">
            <v-card rounded="xl" elevation="1" class="pa-6">
                <div v-if="page?.content" class="page-content" v-html="page.content" />
                <div v-else class="text-center py-8 text-grey">{{ t('no_content') }}</div>
            </v-card>
        </div>
    </div>
</template>

<script setup>
import { useLocale } from '../../composables/useLocale';
const { t } = useLocale();
defineProps({ page: Object, view: String });
</script>

<style scoped>
.page-content { font-size:14px; line-height:1.9; color:#374151; }
.page-content :deep(h2) { font-size:18px; font-weight:700; margin:20px 0 10px; }
.page-content :deep(p)  { margin-bottom:12px; }
.page-content :deep(ul) { padding-right:20px; margin-bottom:12px; }
</style>
