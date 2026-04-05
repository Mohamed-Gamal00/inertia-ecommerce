<template>
    <div class="pay-page" dir="rtl">
        <div class="pay-container">

            <!-- Header -->
            <div class="pay-header">
                <div class="pay-logo">
                    <v-icon size="28" color="white">mdi-lock-outline</v-icon>
                </div>
                <h1 class="pay-title">إتمام الدفع</h1>
                <p class="pay-sub">بيئة دفع آمنة ومشفرة</p>
            </div>

            <!-- Order summary -->
            <div class="pay-card pay-summary">
                <div class="pay-summary-row">
                    <span class="pay-summary-label">رقم الطلب</span>
                    <span class="pay-summary-val">#{{ order.number }}</span>
                </div>
                <div class="pay-summary-row">
                    <span class="pay-summary-label">المبلغ الإجمالي</span>
                    <span class="pay-summary-val pay-amount">
                        {{ totalAmount.toFixed(2) }} ر.س
                    </span>
                </div>
            </div>

            <!-- Flash messages -->
            <div v-if="flash.error" class="pay-alert pay-alert--error">
                <v-icon size="18" class="me-2">mdi-alert-circle-outline</v-icon>
                {{ flash.error }}
            </div>
            <div v-if="flash.success" class="pay-alert pay-alert--success">
                <v-icon size="18" class="me-2">mdi-check-circle-outline</v-icon>
                {{ flash.success }}
            </div>

            <!-- Moyasar form container -->
            <div class="pay-card">
                <div id="moyasar-form" class="mysr-form"></div>
            </div>

            <!-- Security badges -->
            <div class="pay-badges">
                <div class="pay-badge">
                    <v-icon size="14" class="me-1">mdi-shield-check-outline</v-icon>
                    SSL مشفر
                </div>
                <div class="pay-badge">
                    <v-icon size="14" class="me-1">mdi-credit-card-outline</v-icon>
                    Moyasar
                </div>
                <div class="pay-badge">
                    <v-icon size="14" class="me-1">mdi-lock-outline</v-icon>
                    PCI DSS
                </div>
            </div>

            <div class="pay-back">
                <a href="/" class="pay-back-link">
                    <v-icon size="14" class="me-1">mdi-arrow-right</v-icon>
                    العودة للرئيسية
                </a>
            </div>

        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

defineOptions({ layout: null });

const { props } = usePage();
const order          = computed(() => props.order);
const publishableKey = computed(() => props.publishable_key);
const callbackUrl    = computed(() => props.callback_url);
const flash          = computed(() => props.flash || {});

const totalAmount = computed(() =>
    (order.value.total_price || 0) + (order.value.shipping_price || 0)
);

// Amount in halalas (smallest unit) — must be integer
const amountInHalalas = computed(() => Math.round(totalAmount.value * 100));

function loadScript(src) {
    return new Promise((resolve, reject) => {
        if (document.querySelector(`script[src="${src}"]`)) { resolve(); return; }
        const s = document.createElement('script');
        s.src = src;
        s.onload = resolve;
        s.onerror = reject;
        document.head.appendChild(s);
    });
}

function loadStyle(href) {
    if (document.querySelector(`link[href="${href}"]`)) return;
    const l = document.createElement('link');
    l.rel  = 'stylesheet';
    l.href = href;
    document.head.appendChild(l);
}

onMounted(async () => {
    // Load Moyasar v2 assets (correct CDN per docs)
    loadStyle('https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.2.7/dist/moyasar.css');
    await loadScript('https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.2.7/dist/moyasar.umd.min.js');

    window.Moyasar.init({
        element:            '#moyasar-form',
        amount:             amountInHalalas.value,
        currency:           'SAR',
        description:        `طلب رقم #${order.value.number}`,
        publishable_api_key: publishableKey.value,
        callback_url:       callbackUrl.value,
        supported_networks: ['visa', 'mastercard', 'mada'],
        methods:            ['creditcard'],
        on_completed: async function (payment) {
            // Optionally save payment ID before 3DS redirect
            console.log('Payment initiated:', payment.id);
        },
    });
});
</script>

<style scoped>
.pay-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f2f8 0%, #e8eaf6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

.pay-container {
    width: 100%;
    max-width: 500px;
}

.pay-header {
    text-align: center;
    margin-bottom: 24px;
}

.pay-logo {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #1a237e, #3949ab);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    box-shadow: 0 4px 16px rgba(26,35,126,0.3);
}

.pay-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px;
}

.pay-sub {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.pay-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    margin-bottom: 16px;
    border: 1px solid #e5e7eb;
}

.pay-summary { padding: 16px 20px; }

.pay-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
}

.pay-summary-row + .pay-summary-row {
    border-top: 1px solid #f3f4f6;
    margin-top: 6px;
    padding-top: 10px;
}

.pay-summary-label { font-size: 13px; color: #6b7280; }
.pay-summary-val   { font-size: 14px; font-weight: 700; color: #111827; }
.pay-amount        { font-size: 18px; color: #1a237e; }

.pay-alert {
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    margin-bottom: 16px;
}

.pay-alert--error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.pay-alert--success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

.pay-badges {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 16px;
}

.pay-badge {
    display: flex;
    align-items: center;
    font-size: 11px;
    color: #6b7280;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 4px 10px;
}

.pay-back { text-align: center; }

.pay-back-link {
    font-size: 13px;
    color: #6b7280;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: color 0.15s;
}

.pay-back-link:hover { color: #1a237e; }
</style>
