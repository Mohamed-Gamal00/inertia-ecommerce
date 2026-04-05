<template>
    <div class="result-page" dir="rtl">
        <div class="result-container">

            <!-- Animated checkmark -->
            <div class="result-icon result-icon--success">
                <svg viewBox="0 0 52 52" class="checkmark">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>

            <h1 class="result-title result-title--success">تم الدفع بنجاح!</h1>
            <p class="result-sub">شكراً لك، تم استلام طلبك وسيتم معالجته قريباً.</p>

            <!-- Order summary card -->
            <div class="result-card">
                <div class="result-row">
                    <span class="result-label">رقم الطلب</span>
                    <span class="result-val fw-bold">#{{ order.number }}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">عدد المنتجات</span>
                    <span class="result-val">{{ order.items_count }} قطعة</span>
                </div>
                <div class="result-row">
                    <span class="result-label">المبلغ المدفوع</span>
                    <span class="result-val result-amount">
                        {{ ((order.total_price || 0) + (order.shipping_price || 0)).toFixed(2) }} ر.س
                    </span>
                </div>
                <div class="result-row">
                    <span class="result-label">حالة الدفع</span>
                    <span class="badge bg-success px-3 py-2">مدفوع ✓</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="result-actions">
                <a href="/user-profile?tab=orders" class="result-btn result-btn--primary">
                    <v-icon size="16" class="me-1">mdi-clipboard-list-outline</v-icon>
                    عرض طلباتي
                </a>
                <a href="/products" class="result-btn result-btn--outline">
                    <v-icon size="16" class="me-1">mdi-shopping-outline</v-icon>
                    متابعة التسوق
                </a>
            </div>

        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

defineOptions({ layout: null });

const { props } = usePage();
const order = computed(() => props.order);
</script>

<style scoped>
.result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

.result-container {
    width: 100%;
    max-width: 460px;
    text-align: center;
}

/* ── Animated checkmark ── */
.result-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
}

.checkmark {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: block;
    stroke-width: 3;
    stroke: #16a34a;
    stroke-miterlimit: 10;
    animation: fill-success 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 3;
    stroke: #16a34a;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% { stroke-dashoffset: 0; }
}
@keyframes scale {
    0%, 100% { transform: none; }
    50% { transform: scale3d(1.1, 1.1, 1); }
}
@keyframes fill-success {
    100% { box-shadow: inset 0 0 0 80px rgba(22,163,74,0.08); }
}

.result-title {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 8px;
}
.result-title--success { color: #15803d; }

.result-sub {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 24px;
}

.result-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    border: 1px solid #e5e7eb;
    margin-bottom: 24px;
    text-align: right;
}

.result-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
}
.result-row:last-child { border-bottom: none; }

.result-label { font-size: 13px; color: #6b7280; }
.result-val   { font-size: 14px; font-weight: 600; color: #111827; }
.result-amount { font-size: 18px; color: #15803d; }

.result-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}

.result-btn {
    display: inline-flex;
    align-items: center;
    padding: 11px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: opacity 0.15s, transform 0.1s;
}
.result-btn:hover { opacity: 0.88; transform: translateY(-1px); }

.result-btn--primary {
    background: #16a34a;
    color: white;
}
.result-btn--outline {
    background: white;
    color: #374151;
    border: 1.5px solid #e5e7eb;
}
</style>
