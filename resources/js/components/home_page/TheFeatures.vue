<template>
    <div class="features-bar">
        <v-container>
            <v-row>
                <v-col
                    v-for="(f, i) in features"
                    :key="i"
                    cols="6"
                    sm="6"
                    md="3"
                    class="d-flex justify-center"
                >
                    <div class="feature-item" :class="{ 'feature-item--bordered': i > 0 }">
                        <div class="feature-icon">
                            <v-icon :color="f.color" size="26">{{ f.icon }}</v-icon>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">{{ f.title }}</div>
                            <div class="feature-sub">{{ f.sub }}</div>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
const features = [
    { icon: 'mdi-truck-fast-outline',   color: '#1a237e', title: 'شحن مجاني',       sub: 'على الطلبات فوق 200 ر.س' },
    { icon: 'mdi-shield-check-outline', color: '#1a237e', title: 'دفع آمن',          sub: 'بيانات مشفرة 100%' },
    { icon: 'mdi-refresh',              color: '#1a237e', title: 'إرجاع مجاني',      sub: 'خلال 14 يوم من الاستلام' },
    { icon: 'mdi-headset',              color: '#1a237e', title: 'دعم 24/7',         sub: 'فريق جاهز لمساعدتك' },
];
</script>

<style scoped>
.features-bar {
    background: white;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    padding: 20px 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 16px;
    width: 100%;
}

.feature-icon {
    width: 48px;
    height: 48px;
    background: #e8eaf6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.feature-text { display: flex; flex-direction: column; }

.feature-title {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    line-height: 1.3;
}

.feature-sub {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 2px;
}

/* Vertical divider on md+ */
@media (min-width: 960px) {
    .feature-item--bordered {
        border-right: 1px solid #e5e7eb;
    }
}

/* Mobile: 2 columns, no border */
@media (max-width: 599px) {
    .feature-item {
        padding: 8px;
        gap: 8px;
    }
    .feature-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
    }
    .feature-title { font-size: 12px; }
    .feature-sub { font-size: 10px; }
}
</style>
