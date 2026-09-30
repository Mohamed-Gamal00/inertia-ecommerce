<template>
    <div class="static-page">
        <div class="page-hero">
            <h1 class="text-white fw-bold text-center">{{ page?.title || t('home') }}</h1>
        </div>

        <Container class="py-4">
            <div class="page-wrapper">
                <BCard>
                    <div v-if="page?.content" class="page-content" v-html="page.content" />
                    <div v-else class="text-center py-5 text-secondary">{{ t('no_content') }}</div>
                </BCard>
            </div>
        </Container>
    </div>
</template>

<script setup>
import { useLocale } from '../../composables/useLocale';
import { BCard, Container } from '../../components/bootstrap';

const { t } = useLocale();
defineProps({ page: Object, view: String });
</script>

<style scoped>
.static-page {
    background: #f5f6fa;
    min-height: 100vh;
    padding-bottom: 48px;
}

.page-hero {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    padding: 40px 16px 50px;
}

.page-hero h1 {
    font-size: 28px;
}

.page-wrapper {
    max-width: 800px;
    margin: 32px auto;
}

.page-content {
    font-size: 14px;
    line-height: 1.9;
    color: #374151;
}

.page-content :deep(h2) {
    font-size: 18px;
    font-weight: 700;
    margin: 20px 0 10px;
}

.page-content :deep(p) {
    margin-bottom: 12px;
}

.page-content :deep(ul) {
    padding-right: 20px;
    margin-bottom: 12px;
}
</style>
