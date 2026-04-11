<template>
    <div class="result-page" dir="rtl">
        <div class="result-container">

            <!-- Error icon -->
            <div class="result-icon">
                <svg viewBox="0 0 52 52" class="crossmark">
                    <circle class="crossmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="crossmark-cross" fill="none" d="M16 16 36 36 M36 16 16 36"/>
                </svg>
            </div>

            <h1 class="result-title result-title--failed">{{ t('payment_failed_title') }}</h1>
            <p class="result-sub">{{ message || t('payment_failed_sub') }}</p>

            <div class="result-card">
                <div class="result-row"><span class="result-label">{{ t('order_number') }}</span><span class="result-val fw-bold">#{{ order.number }}</span></div>
                <div class="result-row"><span class="result-label">{{ t('amount') }}</span><span class="result-val">{{ ((order.total_price || 0) + (order.shipping_price || 0)).toFixed(2) }} ر.س</span></div>
                <div class="result-row"><span class="result-label">{{ t('payment_status') }}</span><span class="badge bg-danger px-3 py-2">{{ t('failed_status') }}</span></div>
            </div>

            <div class="result-actions">
                <a :href="`/payment/${order.number}`" class="result-btn result-btn--primary">
                    <v-icon size="16" class="me-1">mdi-refresh</v-icon>{{ t('retry') }}
                </a>
                <a href="/" class="result-btn result-btn--outline">
                    <v-icon size="16" class="me-1">mdi-home-outline</v-icon>{{ t('home') }}
                </a>
            </div>

            <p class="result-help">
                {{ t('problem_persists') }}
                <a href="/contact-us" class="text-primary">{{ t('contact_support') }}</a>
            </p>

        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useLocale } from '../../composables/useLocale';
defineOptions({ layout: null });
const { props } = usePage();
const order   = computed(() => props.order);
const message = computed(() => props.message);
const { t } = useLocale();
</script>

<style scoped>
.result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 100%);
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

.result-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
}

.crossmark {
    width: 80px;
    height: 80px;
    stroke-width: 3;
    stroke: #dc2626;
    animation: scale 0.3s ease-in-out 0.6s both;
}

.crossmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke: #dc2626;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.crossmark-cross {
    stroke-dasharray: 60;
    stroke-dashoffset: 60;
    stroke-linecap: round;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.7s forwards;
}

@keyframes stroke {
    100% { stroke-dashoffset: 0; }
}
@keyframes scale {
    0%, 100% { transform: none; }
    50% { transform: scale3d(1.1, 1.1, 1); }
}

.result-title {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 8px;
}
.result-title--failed { color: #dc2626; }

.result-sub {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 24px;
    line-height: 1.6;
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

.result-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 16px;
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
    background: #dc2626;
    color: white;
}
.result-btn--outline {
    background: white;
    color: #374151;
    border: 1.5px solid #e5e7eb;
}

.result-help {
    font-size: 12px;
    color: #9ca3af;
    margin: 0;
}
</style>
