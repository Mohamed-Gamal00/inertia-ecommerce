<template>
    <div class="gs-wrap" ref="wrapRef">
        <div class="gs-input-wrap" :class="{ 'gs-open': open }">
            <input
                ref="inputRef"
                v-model="query"
                class="gs-input"
                :placeholder="t('search_placeholder')"
                @input="onInput"
                @focus="open = true"
                @keydown.escape="close"
                @keydown.enter="goToProducts"
            />
            <button v-if="query" class="gs-clear" @click.stop="clear">
                <v-icon size="15" color="grey">mdi-close</v-icon>
            </button>
            <v-icon size="17" color="grey" class="gs-icon">mdi-magnify</v-icon>
        </div>

        <!-- Teleport dropdown to body to avoid z-index issues -->
        <Teleport to="body">
            <div
                v-if="open && query.length >= 2"
                class="gs-dropdown"
                :style="dropdownStyle"
            >
                <div v-if="loading" class="gs-state">
                    <v-progress-circular indeterminate size="18" color="primary" />
                    <span>{{ t('searching') }}</span>
                </div>

                <template v-else-if="results.length">
                    <div class="gs-section">المنتجات</div>
                    <a
                        v-for="item in results"
                        :key="item.id"
                        :href="`/products/${item.slug}`"
                        class="gs-item"
                        @click="close"
                    >
                        <img :src="item.image_url" class="gs-item-img" alt="" />
                        <div class="gs-item-info">
                            <div class="gs-item-name">{{ pick(item, 'name') }}</div>
                            <div class="gs-item-price">
                                ${{ Math.ceil(item.discount_price || item.price) }}
                                <span v-if="item.discount_price && item.discount_price < item.price" class="gs-item-old">
                                    ${{ item.price }}
                                </span>
                            </div>
                        </div>
                        <v-icon size="13" color="grey">mdi-chevron-left</v-icon>
                    </a>
                    <a :href="`/products?search=${encodeURIComponent(query)}`" class="gs-view-all" @click="close">
                        {{ t('search_view_all') }} "{{ query }}"
                        <v-icon size="14">mdi-arrow-left</v-icon>
                    </a>
                </template>

                <div v-else class="gs-state">
                    <v-icon size="28" color="grey-lighten-1">mdi-magnify-close</v-icon>
                    <span>{{ t('search_no_results') }} "{{ query }}"</span>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { useLocale } from '../../composables/useLocale';
const { t, pick } = useLocale();

const query    = ref('');
const results  = ref([]);
const loading  = ref(false);
const open     = ref(false);
const wrapRef  = ref(null);
const inputRef = ref(null);
const rect     = ref({ top: 0, left: 0, width: 0 });
let debounce   = null;

// Position dropdown under the input
const dropdownStyle = computed(() => ({
    position: 'fixed',
    top:      `${rect.value.top + rect.value.height + 6}px`,
    left:     `${rect.value.left}px`,
    width:    `${Math.max(rect.value.width, 320)}px`,
    zIndex:   99999,
}));

function updateRect() {
    if (wrapRef.value) {
        const r = wrapRef.value.getBoundingClientRect();
        rect.value = { top: r.top, left: r.left, width: r.width, height: r.height };
    }
}

function onInput() {
    updateRect();
    clearTimeout(debounce);
    if (query.value.length < 2) { results.value = []; return; }
    loading.value = true;
    debounce = setTimeout(async () => {
        try {
            const { data } = await axios.get('/search', {
                params: { q: query.value },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            results.value = data;
        } catch { results.value = []; }
        loading.value = false;
    }, 280);
}

function clear() {
    query.value = '';
    results.value = [];
    inputRef.value?.focus();
}

function close() {
    open.value = false;
}

function goToProducts() {
    if (!query.value.trim()) return;
    close();
    // Navigate to products page with search — same as filter
    router.get('/products', { search: query.value }, { preserveState: false });
}

// Close on outside click
function onClickOutside(e) {
    if (wrapRef.value && !wrapRef.value.contains(e.target)) {
        close();
    }
}

onMounted(() => {
    document.addEventListener('click', onClickOutside);
    window.addEventListener('scroll', updateRect, { passive: true });
    window.addEventListener('resize', updateRect, { passive: true });
});

onUnmounted(() => {
    document.removeEventListener('click', onClickOutside);
    window.removeEventListener('scroll', updateRect);
    window.removeEventListener('resize', updateRect);
});
</script>

<style scoped>
.gs-wrap {
    position: relative;
    width: 100%;
    max-width: 340px;
}

.gs-input-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 10px;
    padding: 7px 12px;
    transition: all 0.2s;
}

.gs-open {
    background: white;
    border-color: white;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
}

.gs-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
    color: rgba(255,255,255,0.9);
    min-width: 0;
    direction: rtl;
}

.gs-open .gs-input { color: #111827; }
.gs-input::placeholder { color: rgba(255,255,255,0.55); }
.gs-open .gs-input::placeholder { color: #9ca3af; }

.gs-clear, .gs-icon {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    padding: 0;
    flex-shrink: 0;
}
</style>

<!-- Dropdown styles are global since it's teleported to body -->
<style>
.gs-dropdown {
    background: white;
    border-radius: 14px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.18);
    overflow: hidden;
    max-height: 420px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
}

.gs-state {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 20px 16px;
    font-size: 13px;
    color: #6b7280;
    flex-direction: column;
    text-align: center;
}

.gs-section {
    font-size: 10px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 14px 4px;
}

.gs-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    text-decoration: none;
    border-bottom: 1px solid #f3f4f6;
    transition: background 0.1s;
}

.gs-item:hover { background: #f8f9fb; }

.gs-item-img {
    width: 42px;
    height: 42px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.gs-item-info { flex: 1; min-width: 0; }

.gs-item-name {
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gs-item-price {
    font-size: 12px;
    color: #1a237e;
    font-weight: 700;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.gs-item-old {
    font-size: 11px;
    color: #9ca3af;
    text-decoration: line-through;
    font-weight: 400;
}

.gs-view-all {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #1a237e;
    text-decoration: none;
    background: #f0f2ff;
    border-top: 1px solid #e8eaf6;
}

.gs-view-all:hover { background: #e8eaf6; }
</style>
