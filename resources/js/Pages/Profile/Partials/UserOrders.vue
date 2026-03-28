h<template>
    <div>
        <!-- Empty state -->
        <div v-if="!orders.length" class="empty-state">
            <v-icon size="64" color="grey-lighten-1">mdi-package-variant-closed</v-icon>
            <p class="mt-3 text-grey-darken-1" style="font-size:15px">لا توجد طلبات حتى الآن</p>
            <v-btn color="primary" rounded="lg" href="/products" class="mt-3" style="text-transform:none">
                تسوق الآن
            </v-btn>
        </div>

        <!-- Orders list -->
        <div v-else class="orders-list">
            <div
                v-for="order in orders"
                :key="order.id"
                class="order-card"
                @click="open(order)"
            >
                <!-- Card header -->
                <div class="order-card-head">
                    <div class="d-flex align-center" style="gap:10px">
                        <v-icon size="18" color="primary">mdi-package-variant</v-icon>
                        <span class="font-weight-bold" style="font-size:14px">
                            طلب #{{ order.number }}
                        </span>
                    </div>
                    <div class="d-flex align-center" style="gap:10px">
                        <span class="text-grey" style="font-size:12px">{{ formatDate(order.created_at) }}</span>
                        <v-chip
                            :color="statusColor(order.status)"
                            size="x-small"
                            variant="flat"
                            class="text-white"
                        >
                            {{ statusText(order.status) }}
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
                            +{{ order.order_items.length - 3 }} أخرى
                        </span>
                    </div>
                </div>

                <!-- Card footer -->
                <div class="order-card-foot">
                    <div>
                        <span class="text-grey" style="font-size:12px">الإجمالي</span>
                        <span class="font-weight-bold text-primary ms-2" style="font-size:15px">
                            {{ order.total_price }} ر.س
                        </span>
                    </div>
                    <v-btn size="small" variant="text" color="primary" style="text-transform:none; font-size:12px">
                        عرض التفاصيل
                        <v-icon size="14" class="ms-1">mdi-chevron-left</v-icon>
                    </v-btn>
                </div>
            </div>
        </div>

        <!-- Order details dialog -->
        <v-dialog v-model="dialog" max-width="620" scrollable>
            <v-card rounded="xl" v-if="selected">
                <!-- Dialog header -->
                <div class="dialog-head">
                    <div>
                        <div class="font-weight-bold" style="font-size:16px">طلب #{{ selected.number }}</div>
                        <div class="text-grey" style="font-size:12px">{{ formatDate(selected.created_at) }}</div>
                    </div>
                    <div class="d-flex align-center" style="gap:10px">
                        <v-chip :color="statusColor(selected.status)" size="small" variant="flat" class="text-white">
                            {{ statusText(selected.status) }}
                        </v-chip>
                        <v-btn icon size="small" variant="text" @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </div>
                </div>

                <v-divider />

                <v-card-text class="pa-5">
                    <!-- Order info row -->
                    <div class="info-grid mb-5">
                        <div class="info-cell">
                            <div class="info-label">طريقة الدفع</div>
                            <div class="info-value">
                                <v-icon size="15" color="primary" class="me-1">mdi-credit-card-outline</v-icon>
                                {{ selected.payment_method === 'cash_on_delivery' ? 'الدفع عند الاستلام' : 'بطاقة ائتمانية' }}
                            </div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">حالة الدفع</div>
                            <div class="info-value">
                                <v-chip
                                    :color="selected.payment_status === 'paid' ? 'green' : 'orange'"
                                    size="x-small" variant="flat" class="text-white"
                                >
                                    {{ selected.payment_status === 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                                </v-chip>
                            </div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">سعر الشحن</div>
                            <div class="info-value">{{ selected.shipping_price }} ر.س</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">الإجمالي</div>
                            <div class="info-value font-weight-bold text-primary" style="font-size:15px">
                                {{ selected.total_price }} ر.س
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="section-title mb-3">المنتجات</div>
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
                                <div style="font-size:12px; color:#9ca3af">الكمية: {{ item.quantity }}</div>
                            </div>
                            <div class="font-weight-bold" style="font-size:13px; color:#1a237e">
                                {{ item.price }} ر.س
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <template v-if="selected.note">
                        <div class="section-title mt-4 mb-2">ملاحظة</div>
                        <div class="note-box">{{ selected.note }}</div>
                    </template>

                    <!-- Return request -->
                    <div v-if="!selected.return_order" class="mt-5">
                        <v-divider class="mb-4" />
                        <div class="d-flex align-center justify-space-between">
                            <div>
                                <div class="font-weight-bold" style="font-size:13px">هل تريد إرجاع هذا الطلب؟</div>
                                <div class="text-grey text-caption">سيتم مراجعة طلبك من قِبل الفريق</div>
                            </div>
                            <v-btn
                                color="orange"
                                variant="tonal"
                                rounded="lg"
                                size="small"
                                style="text-transform:none"
                                :loading="returning"
                                prepend-icon="mdi-arrow-u-left-top"
                                @click="requestReturn(selected.id)"
                            >
                                طلب إرجاع
                            </v-btn>
                        </div>
                    </div>
                    <div v-else class="mt-4">
                        <v-alert type="warning" variant="tonal" density="compact" rounded="lg" icon="mdi-arrow-u-left-top">
                            تم تقديم طلب إرجاع لهذا الطلب وهو قيد المراجعة
                        </v-alert>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" location="top right" :color="snackbarColor" timeout="2500">
            {{ snackbarMsg }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import axios from 'axios';

const props = defineProps({ user: { type: Object, required: true } });

const orders = computed(() => (props.user.orders || []).filter(o => !o.return_order));
const dialog    = ref(false);
const selected  = ref(null);
const returning = ref(false);
const snackbar  = ref(false);
const snackbarMsg   = ref('');
const snackbarColor = ref('success');

function open(order) {
    selected.value = order;
    dialog.value = true;
}

async function requestReturn(orderId) {
    returning.value = true;
    try {
        await axios.post('/user_return_orders/store', { return_order_id: orderId });
        const order = orders.value.find(o => o.id === orderId);
        if (order) order.return_order = true;
        if (selected.value?.id === orderId) selected.value.return_order = true;
        snackbarMsg.value = 'تم تقديم طلب الإرجاع بنجاح';
        snackbarColor.value = 'success';
    } catch (e) {
        snackbarMsg.value = e.response?.data?.message || 'حدث خطأ';
        snackbarColor.value = 'error';
    } finally {
        returning.value = false;
        snackbar.value = true;
    }
}

const statusMap = {
    pending:     { text: 'قيد الانتظار', color: 'orange' },
    approved:    { text: 'تمت الموافقة', color: 'blue' },
    in_progress: { text: 'قيد التنفيذ',  color: 'amber' },
    completed:   { text: 'مكتمل',        color: 'green' },
    rejected:    { text: 'مرفوض',        color: 'red' },
};

const statusText  = (s) => statusMap[s]?.text  || s;
const statusColor = (s) => statusMap[s]?.color || 'grey';

const formatDate = (d) => d ? new Date(d).toLocaleDateString('ar-EG', { year: 'numeric', month: 'long', day: 'numeric' }) : '-';
</script>

<style scoped>
.empty-state { text-align: center; padding: 60px 20px; }

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
    background: #fafafa;
}

.order-card-body {
    padding: 12px 16px;
}

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

/* Dialog */
.dialog-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.info-cell {
    background: #f8f9fb;
    border-radius: 10px;
    padding: 12px;
}

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
