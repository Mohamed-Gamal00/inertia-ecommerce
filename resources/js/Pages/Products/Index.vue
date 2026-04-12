<template>
    <div style="background:#f5f6fa; min-height:100vh; padding-bottom:48px">
        <SeoHead :title="filters.q ? `${t('results_for')} ${filters.q}` : t('all_products')" />

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab); padding:32px 16px 44px">
            <h1 class="text-white font-weight-bold text-center" style="font-size:26px">
                {{ filters.q ? `${t('results_for')} "${filters.q}"` : t('all_products') }}
            </h1>
            <p class="text-center mt-1" style="color:rgba(255,255,255,0.75); font-size:13px">
                {{ products.total }} {{ t('available_products') }}
            </p>
        </div>

        <div style="max-width:1400px; margin:0 auto; padding:0 16px">

            <!-- Filter bar -->
            <div class="filter-bar">

                <!-- Search -->
                <div class="filter-search">
                    <v-icon size="16" color="grey">mdi-magnify</v-icon>
                    <input v-model="localSearch" :placeholder="t('search_in_products')" class="filter-search-input" />

                </div>

                <select v-model="localCat" class="filter-select" @change="applyFilters">
                    <option value="">{{ t('all_categories') }}</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>

                <select v-model="localSort" class="filter-select" @change="applyFilters">
                    <option value="latest">{{ t('sort_latest') }}</option>
                    <option value="price_asc">{{ t('sort_price_asc') }}</option>
                    <option value="price_desc">{{ t('sort_price_desc') }}</option>
                    <option value="discount">{{ t('sort_discount') }}</option>
                </select>

                <div class="filter-price">
                    <input v-model="localMin" type="number" :placeholder="t('from')" class="filter-price-input" min="0" />
                    <span style="color:#9ca3af; font-size:12px">—</span>
                    <input v-model="localMax" type="number" :placeholder="t('to')" class="filter-price-input" min="0" />
                    <button class="filter-apply-btn" @click="applyFilters">{{ t('apply') }}</button>
                </div>

                <button v-if="hasFilters" class="filter-clear-btn" @click="clearFilters">
                    <v-icon size="14" class="me-1">mdi-close</v-icon>
                    {{ t('clear') }}
                </button>
            </div>

            <div v-if="hasFilters" class="filter-chips">
                <span v-if="filters.q" class="filter-chip">
                    {{ t('filter_search') }} {{ filters.q }}
                    <button @click="removeFilter('q')">×</button>
                </span>
                <span v-if="filters.cat" class="filter-chip">
                    {{ t('filter_category') }} {{ categories.find(c => c.id == filters.cat)?.name }}
                    <button @click="removeFilter('cat')">×</button>
                </span>
                <span v-if="filters.min || filters.max" class="filter-chip">
                    {{ t('filter_price') }} {{ filters.min || '0' }} — {{ filters.max || '∞' }} ر.س
                    <button @click="removeFilter('price')">×</button>
                </span>
            </div>

            <!-- Products grid -->
            <v-row v-if="products.data?.length" class="mt-4">
                <v-col
                    v-for="product in products.data"
                    :key="product.id"
                    cols="6"
                    sm="4"
                    md="3"
                    lg="2"
                >
                    <ProductCard :item="product" @quick-view="openQuickView" />
                </v-col>
            </v-row>

            <div v-else style="text-align:center; padding:64px 0; margin-top:16px">
                <v-icon size="64" color="grey-lighten-1">mdi-shopping-search</v-icon>
                <p style="margin-top:12px; color:#374151; font-weight:600">{{ t('no_products') }}</p>
                <p style="color:#9ca3af; font-size:13px">{{ t('no_products_hint') }}</p>
                <button class="filter-apply-btn mt-4" @click="clearFilters">{{ t('clear_filters') }}</button>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-center mt-8" v-if="products.last_page > 1">
                <v-pagination
                    v-model="page"
                    :length="products.last_page"
                    total-visible="5"
                    rounded="lg"
                    @update:model-value="goto"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, inject } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductCard from '../../components/Shared/ProductCard.vue';
import SeoHead from '../../components/Shared/SeoHead.vue';
import { useLocale } from '../../composables/useLocale';
const { t } = useLocale();

const props = defineProps({
    products:   Object,
    filters:    Object,
    categories: Array,
});

const Emitter = inject('Emitter');
const page = ref(props.products.current_page);

// Local filter state
const localSearch = ref(props.filters?.q    || '');
const localSort   = ref(props.filters?.sort || 'latest');
const localMin    = ref(props.filters?.min  || '');
const localMax    = ref(props.filters?.max  || '');
const localCat    = ref(props.filters?.cat  || '');

const hasFilters = computed(() =>
    props.filters?.q || props.filters?.cat ||
    props.filters?.min || props.filters?.max ||
    (props.filters?.sort && props.filters.sort !== 'latest')
);

function applyFilters() {
    router.get('/products', {
        search:    localSearch.value || undefined,
        sort:      localSort.value !== 'latest' ? localSort.value : undefined,
        min_price: localMin.value || undefined,
        max_price: localMax.value || undefined,
        category:  localCat.value || undefined,
    }, { preserveState: true, replace: true });
}

// Live search — debounced 350ms, same as navbar
let debounceTimer = null;
watch(localSearch, () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => applyFilters(), 350);
});

function clearFilters() {
    localSearch.value = '';
    localSort.value   = 'latest';
    localMin.value    = '';
    localMax.value    = '';
    localCat.value    = '';
    router.get('/products', {}, { replace: true });
}

function removeFilter(key) {
    if (key === 'q')     localSearch.value = '';
    if (key === 'cat')   localCat.value    = '';
    if (key === 'price') { localMin.value = ''; localMax.value = ''; }
    applyFilters();
}

function goto(val) {
    router.get('/products', {
        ...props.filters,
        page: val,
    }, { preserveState: true, preserveScroll: true });
}

function openQuickView(product) { Emitter.emit('openQuickView', product); }

watch(() => props.products.current_page, (val) => page.value = val);
</script>

<style scoped>
/* Filter bar */
.filter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    background: white;
    border-radius: 14px;
    padding: 14px 16px;
    margin-top: -20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
}

.filter-search {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 7px 12px;
    flex: 1;
    min-width: 160px;
}

.filter-search-input {
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
    color: #374151;
    width: 100%;
}

.filter-search-input::placeholder { color: #9ca3af; }

.filter-select {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 13px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    cursor: pointer;
    transition: border-color 0.15s;
}

.filter-select:focus { border-color: #3949ab; }

.filter-price {
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-price-input {
    width: 70px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 7px 8px;
    font-size: 12px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    text-align: center;
}

.filter-apply-btn {
    background: #1a237e;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.15s;
    white-space: nowrap;
}

.filter-apply-btn:hover { opacity: 0.88; }

.filter-clear-btn {
    display: flex;
    align-items: center;
    background: #fef2f2;
    color: #ef4444;
    border: 1px solid #fecaca;
    border-radius: 8px;
    padding: 7px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

/* Active filter chips */
.filter-chips {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.filter-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #e8eaf6;
    color: #1a237e;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

.filter-chip button {
    background: none;
    border: none;
    cursor: pointer;
    color: #3949ab;
    font-size: 14px;
    line-height: 1;
    padding: 0;
}

@media (max-width: 599px) {
    .filter-bar { gap: 8px; }
    .filter-price { flex-wrap: wrap; }
    .filter-price-input { width: 60px; }
}
</style>
