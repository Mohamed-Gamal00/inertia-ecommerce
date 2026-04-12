<template>
    <Transition name="compare-bar">
        <div v-if="compareList.length" class="compare-bar">
            <div class="compare-bar-inner">
                <div class="compare-items">
                    <div v-for="item in compareList" :key="item.id" class="compare-item">
                        <img :src="item.image_url" :alt="pick(item,'name')" class="compare-item-img" />
                        <div class="compare-item-name">{{ pick(item, 'name') }}</div>
                        <button class="compare-item-remove" @click="toggle(item)">×</button>
                    </div>
                    <div v-for="i in (MAX - compareList.length)" :key="`empty-${i}`" class="compare-item compare-item--empty">
                        <v-icon size="24" color="grey-lighten-1">mdi-plus</v-icon>
                        <span style="font-size:11px; color:#9ca3af">{{ t('compare_add_product') }}</span>
                    </div>
                </div>
                <div class="compare-actions">
                    <a :href="`/compare?ids=${compareList.map(p=>p.id).join(',')}`" class="compare-btn-go">
                        <v-icon size="16" class="me-1">mdi-compare</v-icon>
                        {{ t('compare') }} ({{ compareList.length }})
                    </a>
                    <button class="compare-btn-clear" @click="clear">{{ t('compare_clear') }}</button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { useCompare } from '../../composables/useCompare';
import { useLocale } from '../../composables/useLocale';
const { compareList, toggle, clear, MAX } = useCompare();
const { t, pick } = useLocale();
</script>

<style scoped>
.compare-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-top: 2px solid #1a237e;
    box-shadow: 0 -4px 24px rgba(0,0,0,0.12);
    z-index: 400;
    padding: 12px 16px;
}

.compare-bar-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.compare-items {
    display: flex;
    gap: 10px;
    flex: 1;
    flex-wrap: wrap;
}

.compare-item {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 6px 10px;
    position: relative;
    min-width: 140px;
}

.compare-item--empty {
    flex-direction: column;
    justify-content: center;
    border-style: dashed;
    min-height: 52px;
    opacity: 0.6;
}

.compare-item-img {
    width: 36px;
    height: 36px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
}

.compare-item-name {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

.compare-item-remove {
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    font-size: 16px;
    line-height: 1;
    padding: 0;
    flex-shrink: 0;
}

.compare-item-remove:hover { color: #ef4444; }

.compare-actions { display: flex; gap: 8px; align-items: center; }

.compare-btn-go {
    background: #1a237e;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    white-space: nowrap;
    transition: opacity 0.15s;
}

.compare-btn-go:hover { opacity: 0.88; }

.compare-btn-clear {
    background: #f3f4f6;
    color: #6b7280;
    border: none;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 12px;
    cursor: pointer;
    white-space: nowrap;
}

.compare-bar-enter-active, .compare-bar-leave-active { transition: transform 0.3s ease; }
.compare-bar-enter-from, .compare-bar-leave-to { transform: translateY(100%); }
</style>
