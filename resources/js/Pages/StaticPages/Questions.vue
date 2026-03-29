<template>
    <div class="faq-page">

        <!-- Hero -->
        <div class="faq-hero">
            <div class="faq-hero-content">
                <div class="faq-hero-icon">
                    <v-icon size="40" color="white">mdi-help-circle-outline</v-icon>
                </div>
                <h1 class="text-white font-weight-bold" style="font-size:32px; margin-bottom:8px">
                    الأسئلة الشائعة
                </h1>
                <p style="color:rgba(255,255,255,0.8); font-size:15px">
                    إجابات على أكثر الأسئلة شيوعاً — إذا لم تجد إجابتك
                    <a href="/contact-us" style="color:white; font-weight:700; text-decoration:underline">تواصل معنا</a>
                </p>

                <!-- Search -->
                <div class="faq-search">
                    <v-icon size="18" color="grey">mdi-magnify</v-icon>
                    <input v-model="search" placeholder="ابحث في الأسئلة..." class="faq-search-input" />
                </div>
            </div>
        </div>

        <!-- Categories tabs -->
        <div class="faq-tabs-wrap">
            <div class="faq-tabs">
                <button
                    v-for="cat in categories"
                    :key="cat.key"
                    class="faq-tab"
                    :class="{ 'faq-tab--active': activeCategory === cat.key }"
                    @click="activeCategory = cat.key"
                >
                    <v-icon size="16" class="me-1">{{ cat.icon }}</v-icon>
                    {{ cat.label }}
                </button>
            </div>
        </div>

        <!-- Questions -->
        <div class="faq-body">
            <div v-if="!filteredQuestions.length" class="faq-empty">
                <v-icon size="56" color="grey-lighten-1">mdi-help-circle-outline</v-icon>
                <p class="mt-3 text-grey">لا توجد نتائج مطابقة</p>
            </div>

            <div v-else class="faq-list">
                <div
                    v-for="(q, i) in filteredQuestions"
                    :key="q.id"
                    class="faq-item"
                    :class="{ 'faq-item--open': openIndex === i }"
                    @click="openIndex = openIndex === i ? null : i"
                >
                    <div class="faq-question">
                        <div class="faq-q-num">{{ i + 1 }}</div>
                        <span class="faq-q-text">{{ q.title }}</span>
                        <v-icon
                            size="20"
                            color="primary"
                            class="faq-chevron"
                            :class="{ 'faq-chevron--open': openIndex === i }"
                        >
                            mdi-chevron-down
                        </v-icon>
                    </div>
                    <div class="faq-answer" :class="{ 'faq-answer--open': openIndex === i }">
                        <div class="faq-answer-inner">
                            {{ q.description }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="faq-cta">
                <div class="faq-cta-icon">
                    <v-icon size="28" color="primary">mdi-headset</v-icon>
                </div>
                <div>
                    <div class="font-weight-bold" style="font-size:15px; color:#111827">لم تجد إجابتك؟</div>
                    <div style="font-size:13px; color:#6b7280">فريق الدعم متاح للمساعدة على مدار الساعة</div>
                </div>
                <a href="/contact-us">
                    <v-btn color="primary" rounded="lg" style="text-transform:none; font-size:13px">
                        تواصل معنا
                    </v-btn>
                </a>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({ questions: Array });

const search        = ref('');
const openIndex     = ref(null);
const activeCategory = ref('all');

const categories = [
    { key: 'all',      label: 'الكل',          icon: 'mdi-view-grid-outline' },
    { key: 'shipping', label: 'الشحن',          icon: 'mdi-truck-fast-outline' },
    { key: 'payment',  label: 'الدفع',          icon: 'mdi-credit-card-outline' },
    { key: 'returns',  label: 'الإرجاع',        icon: 'mdi-arrow-u-left-top' },
    { key: 'account',  label: 'الحساب',         icon: 'mdi-account-outline' },
];

// Simple keyword-based categorization
const categoryKeywords = {
    shipping: ['شحن', 'توصيل', 'تتبع', 'مدة'],
    payment:  ['دفع', 'سداد', 'بطاقة', 'تحويل'],
    returns:  ['إرجاع', 'استبدال', 'إلغاء', 'استرداد'],
    account:  ['حساب', 'تسجيل', 'كلمة مرور', 'بيانات'],
};

const filteredQuestions = computed(() => {
    let list = props.questions || [];

    if (activeCategory.value !== 'all') {
        const keywords = categoryKeywords[activeCategory.value] || [];
        list = list.filter(q =>
            keywords.some(kw => q.title.includes(kw) || q.description?.includes(kw))
        );
    }

    if (search.value.trim()) {
        const s = search.value.trim().toLowerCase();
        list = list.filter(q =>
            q.title.toLowerCase().includes(s) || q.description?.toLowerCase().includes(s)
        );
    }

    return list;
});
</script>

<style scoped>
.faq-page { background: #f5f6fa; min-height: 100vh; padding-bottom: 64px; }

/* Hero */
.faq-hero {
    background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
    padding: 56px 16px 80px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.faq-hero::before {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    top: -150px;
    right: -100px;
}

.faq-hero-content { position: relative; z-index: 1; }

.faq-hero-icon {
    width: 72px;
    height: 72px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

/* Search */
.faq-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: white;
    border-radius: 12px;
    padding: 10px 16px;
    max-width: 480px;
    margin: 24px auto 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.faq-search-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14px;
    color: #374151;
    background: transparent;
    direction: rtl;
}

.faq-search-input::placeholder { color: #9ca3af; }

/* Tabs */
.faq-tabs-wrap {
    display: flex;
    justify-content: center;
    padding: 0 16px;
    margin-top: -20px;
    position: relative;
    z-index: 2;
}

.faq-tabs {
    display: flex;
    gap: 8px;
    background: white;
    border-radius: 14px;
    padding: 6px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    flex-wrap: wrap;
    justify-content: center;
}

.faq-tab {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}

.faq-tab:hover { background: #f3f4f6; color: #374151; }
.faq-tab--active { background: #1a237e; color: white; }

/* Body */
.faq-body {
    max-width: 760px;
    margin: 32px auto 0;
    padding: 0 16px;
}

.faq-empty { text-align: center; padding: 48px 0; }

/* FAQ items */
.faq-list { display: flex; flex-direction: column; gap: 10px; }

.faq-item {
    background: white;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: box-shadow 0.2s, border-color 0.2s;
    cursor: pointer;
}

.faq-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.faq-item--open { border-color: #3949ab; box-shadow: 0 4px 16px rgba(57,73,171,0.1); }

.faq-question {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
}

.faq-q-num {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #e8eaf6;
    color: #1a237e;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.15s;
}

.faq-item--open .faq-q-num { background: #1a237e; color: white; }

.faq-q-text {
    flex: 1;
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    line-height: 1.4;
}

.faq-chevron { transition: transform 0.25s; flex-shrink: 0; }
.faq-chevron--open { transform: rotate(180deg); }

/* Answer */
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-answer--open { max-height: 300px; }

.faq-answer-inner {
    padding: 0 18px 18px 18px;
    padding-right: 58px;
    font-size: 13px;
    color: #6b7280;
    line-height: 1.8;
    border-top: 1px solid #f3f4f6;
    padding-top: 14px;
}

/* CTA */
.faq-cta {
    display: flex;
    align-items: center;
    gap: 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    margin-top: 24px;
    flex-wrap: wrap;
}

.faq-cta-icon {
    width: 52px;
    height: 52px;
    background: #e8eaf6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.faq-cta > div:nth-child(2) { flex: 1; }
</style>
