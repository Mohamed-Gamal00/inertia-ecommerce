<template>
    <div>
        <div v-if="loading" class="text-center py-8">
            <v-progress-circular indeterminate color="primary" />
        </div>

        <!-- Empty state -->
        <div v-else-if="!returnOrders.length" class="empty-state">
            <v-icon size="56" color="grey-lighten-1">mdi-package-variant-remove</v-icon>
            <p class="mt-3 text-grey-darken-1" style="font-size:14px">{{ t('returns_empty') }}</p>
            <p class="text-grey text-caption">{{ t('returns_hint') }}</p>
        </div>

        <!-- Return orders list -->
        <div v-else class="orders-list">
            <div
                v-for="order in returnOrders"
                :key="order.id"
                class="order-card"
                @click="open(order)"
            >
                <!-- Card header -->
                <div class="order-card-head">
                    <div class="d-flex align-center" style="gap:10px">
                        <v-icon size="18" color="orange">mdi-arrow-u-left-top</v-icon>
                        <span class="font-weight-bold" style="font-size:14px">
                            {{ t('return_order_label') }} #{{ order.number }}
                        </span>
                    </div>
                    <div class="d-flex align-center" style="gap:10px">
                        <span class="text-grey" style="font-size:12px">{{ formatDate(order.created_at) }}</span>
                        <v-chip color="orange" size="x-small" variant="flat" class="text-white">
                            {{ t('under_review') }}
                        </v-chip>
                    </div>
                </div>

                <v-divider />

                <!-- Items preview -->
                <div class="order-card-body">
                    <div class="d-flex align-center" style="gap:8px; flex-wrap:wrap">
                        <div
                            v-for="item in (order.order_items || []).slice(0, 3)"
                            :key="item.id"
                            class="order-item-preview"
                        >
                            <span style="font-size:12px; color:#374151">{{ item.product_name }}</span>
                            <span class="text-grey" style="font-size:11px">x{{ item.quantity }}</span>
                        </div>
                        <span v-if="(order.order_items || []).length > 3" class="text-grey" style="font-size:12px">
                            +{{ order.order_items.length - 3 }} {{ t('more_items') }}
                        </span>
                    </div>
                </div>

                <!-- Card footer -->
                <div class="order-card-foot">
                    <div>
                        <span class="text-grey" style="font-size:12px">{{ t('total') }}</span>
                        <span class="font-weight-bold text-primary ms-2" style="font-size:15px">
                            {{ order.total_price }} ر.س
                        </span>
                    </div>
                    <v-btn size="small" variant="text" color="primary" style="text-transform:none; font-size:12px">
                        {{ t('view_details') }}
                        <v-icon size="14" class="ms-1">mdi-chevron-left</v-icon>
                    </v-btn>
                </div>
            </div>
        </div>

        <!-- Order details dialog (same as orders tab) -->
        <v-dialog v-model="dialog" max-width="620" scrollable>
            <v-card rounded="xl" v-if="selected">
                <!-- Dialog header -->
                <div class="dialog-head">
                    <div>
                        <div class="font-weight-bold" style="font-size:16px">{{ t('return_order_label') }} #{{ selected.number }}</div>
                        <div class="text-grey" style="font-size:12px">{{ formatDate(selected.created_at) }}</div>
                    </div>
                    <div class="d-flex align-center" style="gap:10px">
                        <v-chip color="orange" size="small" variant="flat" class="text-white">
                            {{ t('under_review') }}
                        </v-chip>
                        <v-btn icon size="small" variant="text" @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </div>
                </div>

                <v-divider />

                <v-card-text class="pa-5">
                    <!-- Order info grid -->
                    <div class="info-grid mb-5">
                        <div class="info-cell">
                            <div class="info-label">{{ t('payment_method') }}</div>
                            <div class="info-value">
                                <v-icon size="15" color="primary" class="me-1">mdi-credit-card-outline</v-icon>
                                {{ selected.payment_method === 'cash_on_delivery' ? t('cash_on_delivery') : t('card_payment') }}
                            </div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">{{ t('payment_status') }}</div>
                            <div class="info-value">
                                <v-chip
                                    :color="selected.payment_status === 'paid' ? 'green' : 'orange'"
                                    size="x-small" variant="flat" class="text-white"
                                >
                                    {{ selected.payment_status === 'paid' ? t('paid') : t('unpaid') }}
                                </v-chip>
                            </div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">{{ t('shipping_price') }}</div>
                            <div class="info-value">{{ selected.shipping_price }} ر.س</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">{{ t('total') }}</div>
                            <div class="info-value font-weight-bold text-primary" style="font-size:15px">
                                {{ selected.total_price }} ر.س
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="section-title mb-3">{{ t('products') }}</div>
                    <div class="items-list">
                        <div
                            v-for="item in selected.order_items || []"
                            :key="item.id"
                            class="order-item-row"
                        >
                            <div class="order-item-icon">
                                <v-icon size="18" color="primary">mdi-package-variant-closed</v-icon>
                            </div>
                            <div style="flex:1">
                                <div style="font-size:13px; font-weight:600">{{ item.product_name }}</div>
                                <div style="font-size:12px; color:#9ca3af">{{ t('quantity') }}: {{ item.quantity }}</div>
                            </div>
                            <div class="font-weight-bold" style="font-size:13px; color:#1a237e">
                                {{ item.price }} ر.س
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <template v-if="selected.note">
                        <div class="section-title mt-4 mb-2">{{ t('note') }}</div>
                        <div class="note-box">{{ selected.note }}</div>
                    </template>

                    <!-- Return status notice -->
                    <div class="mt-4">
                        <v-alert type="warning" variant="tonal" density="compact" rounded="lg" icon="mdi-arrow-u-left-top">
                            {{ t('return_submitted_review') }}
                        </v-alert>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useLocale } from '../../../composables/useLocale';

const { t } = useLocale();
defineProps({ user: { type: Object, required: true } });

const loading      = ref(false);
const returnOrders = ref([]);
const dialog       = ref(false);
const selected     = ref(null);

function open(order) {
    selected.value = order;
    dialog.value = true;
}

async function fetchReturns() {
    loading.value = true;
    try {
        const { data } = await axios.get('/user_return_orders');
        returnOrders.value = data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
}

const formatDate = (d) => d
    ? new Date(d).toLocaleDateString('ar-EG', { year: 'numeric', month: 'long', day: 'numeric' })
    : '-';

onMounted(fetchReturns);
</script>

<style scoped>
.empty-state { text-align: center; padding: 48px 20px; }

/* Reuse same styles as UserOrders */
.orders-list { display: flex; flex-direction: column; gap: 12px; }

.order-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: box-shadow 0.2s, transform 0.2s;
    background: white;
}

.order-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transform: translateY(-1px);
}

.order-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    background: #fffbf5;
}

.order-card-body { padding: 12px 16px; }

.order-item-preview {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f6;
    border-radius: 6px;
    padding: 3px 8px;
}

.order-card-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    border-top: 1px solid #f3f4f6;
}

.dialog-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
}

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

.info-cell { background: #f8f9fb; border-radius: 10px; padding: 12px; }
.info-label { font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
.info-value { font-size: 13px; font-weight: 600; color: #111827; display: flex; align-items: center; }

.section-title { font-size: 13px; font-weight: 700; color: #374151; }

.items-list { display: flex; flex-direction: column; gap: 8px; }

.order-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.order-item-icon {
    width: 36px;
    height: 36px;
    background: #e8eaf6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.note-box {
    background: #f8f9fb;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}
</style>
