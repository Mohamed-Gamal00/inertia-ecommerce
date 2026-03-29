<template>
    <footer class="site-footer">

        <!-- Top wave -->
        <div class="footer-wave">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#1a237e" />
            </svg>
        </div>

        <!-- Main footer body -->
        <div class="footer-body">
            <div class="footer-container">
                <div class="footer-grid">

                    <!-- Brand -->
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <v-icon size="28" color="white">mdi-storefront</v-icon>
                            <span>متجري</span>
                        </div>
                        <p class="brand-desc">
                            وجهتك الأولى للتسوق الإلكتروني. نقدم أفضل المنتجات بأعلى جودة وأنسب الأسعار مع توصيل سريع وموثوق.
                        </p>

                        <!-- Trust badges -->
                        <div class="trust-badges">
                            <div class="trust-badge">
                                <v-icon size="14">mdi-shield-check-outline</v-icon>
                                <span>دفع آمن</span>
                            </div>
                            <div class="trust-badge">
                                <v-icon size="14">mdi-truck-fast-outline</v-icon>
                                <span>شحن سريع</span>
                            </div>
                            <div class="trust-badge">
                                <v-icon size="14">mdi-refresh</v-icon>
                                <span>إرجاع مجاني</span>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="social-links">
                            <a href="#" class="social-btn" aria-label="Facebook">
                                <v-icon size="18">mdi-facebook</v-icon>
                            </a>
                            <a href="#" class="social-btn" aria-label="Twitter">
                                <v-icon size="18">mdi-twitter</v-icon>
                            </a>
                            <a href="#" class="social-btn" aria-label="Instagram">
                                <v-icon size="18">mdi-instagram</v-icon>
                            </a>
                            <a href="#" class="social-btn" aria-label="Snapchat">
                                <v-icon size="18">mdi-snapchat</v-icon>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-col">
                        <h5 class="footer-col-title">روابط سريعة</h5>
                        <ul class="footer-links">
                            <li><Link href="/">الرئيسية</Link></li>
                            <li><Link href="/products">المنتجات</Link></li>
                            <li><Link href="/categories">الأقسام</Link></li>
                            <li><Link href="/brands">الماركات</Link></li>
                            <li><Link href="/offers">العروض</Link></li>
                            <li><Link href="/contact-us">تواصل معنا</Link></li>
                        </ul>
                    </div>

                    <!-- Policies -->
                    <div class="footer-col">
                        <h5 class="footer-col-title">السياسات</h5>
                        <ul class="footer-links">
                            <li><Link href="/terms-conditions">الشروط والأحكام</Link></li>
                            <li><Link href="/privacy-policy">سياسة الخصوصية</Link></li>
                            <li><Link href="/shipping-policy">سياسة الشحن</Link></li>
                            <li><Link href="/exchanges-returns">الإرجاع والاستبدال</Link></li>
                            <li><Link href="/faq">الأسئلة الشائعة</Link></li>
                        </ul>
                    </div>

                    <!-- Services -->
                    <div class="footer-col">
                        <h5 class="footer-col-title">خدماتنا</h5>
                        <ul class="footer-links">
                            <li><Link href="/bulk-order">طلبات الجملة</Link></li>
                            <li><Link href="/representative-order">طلبات المناديب</Link></li>
                            <li><Link href="/contact-us">تواصل معنا</Link></li>
                        </ul>

                        <!-- Contact info -->
                        <div class="contact-info mt-4">
                            <div class="contact-item">
                                <v-icon size="14" color="rgba(255,255,255,0.6)">mdi-phone-outline</v-icon>
                                <span dir="ltr">+966 50 000 0000</span>
                            </div>
                            <div class="contact-item">
                                <v-icon size="14" color="rgba(255,255,255,0.6)">mdi-email-outline</v-icon>
                                <span>info@store.com</span>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="footer-newsletter">
                        <h5 class="footer-col-title">النشرة البريدية</h5>
                        <p class="newsletter-desc">اشترك ليصلك أحدث العروض والخصومات أولاً بأول.</p>
                        <div class="newsletter-form">
                            <input
                                v-model="email"
                                type="email"
                                placeholder="بريدك الإلكتروني..."
                                class="newsletter-input"
                                dir="ltr"
                                @keyup.enter="subscribe"
                            />
                            <button class="newsletter-btn" :disabled="subscribing" @click="subscribe">
                                <v-icon size="18">mdi-send</v-icon>
                            </button>
                        </div>
                        <p v-if="subscribeMsg" class="subscribe-msg">{{ subscribeMsg }}</p>

                        <!-- App store badges -->
                        <div class="app-badges mt-4">
                            <div class="app-badge">
                                <v-icon size="20">mdi-apple</v-icon>
                                <div>
                                    <div style="font-size:9px; opacity:0.7">تحميل من</div>
                                    <div style="font-size:12px; font-weight:700">App Store</div>
                                </div>
                            </div>
                            <div class="app-badge">
                                <v-icon size="20">mdi-google-play</v-icon>
                                <div>
                                    <div style="font-size:9px; opacity:0.7">تحميل من</div>
                                    <div style="font-size:12px; font-weight:700">Google Play</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-container">
                <div class="footer-bottom-inner">
                    <span>© {{ new Date().getFullYear() }} متجري — جميع الحقوق محفوظة</span>
                    <div class="bottom-links">
                        <Link href="/terms-conditions">الشروط</Link>
                        <span>·</span>
                        <Link href="/privacy-policy">الخصوصية</Link>
                        <span>·</span>
                        <Link href="/contact-us">تواصل معنا</Link>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const email        = ref('');
const subscribing  = ref(false);
const subscribeMsg = ref('');

async function subscribe() {
    if (!email.value) return;
    subscribing.value = true;
    try {
        await axios.post('/api/subscribe', { email: email.value });
    } catch {}
    subscribeMsg.value = '✓ تم الاشتراك بنجاح!';
    email.value = '';
    subscribing.value = false;
}
</script>

<style scoped>
.site-footer {
    direction: rtl;
    font-family: inherit;
}

/* Wave */
.footer-wave {
    line-height: 0;
    background: #f5f6fa;
}

.footer-wave svg {
    display: block;
    width: 100%;
    height: 60px;
}

/* Body */
.footer-body {
    background: #1a237e;
    padding: 48px 0 32px;
}

.footer-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
    gap: 40px;
}

@media (max-width: 1024px) {
    .footer-grid { grid-template-columns: 1fr 1fr 1fr; }
    .footer-brand { grid-column: 1 / -1; }
    .footer-newsletter { grid-column: 1 / -1; }
}

@media (max-width: 600px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 24px; }
    .footer-brand, .footer-newsletter { grid-column: 1 / -1; }
}

/* Brand */
.brand-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    font-size: 20px;
    font-weight: 800;
    color: white;
}

.brand-desc {
    font-size: 13px;
    color: rgba(255,255,255,0.75);
    line-height: 1.8;
    margin-bottom: 16px;
    max-width: 320px;
}

/* Trust badges */
.trust-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.trust-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 11px;
    color: rgba(255,255,255,0.85);
}

/* Social */
.social-links {
    display: flex;
    gap: 8px;
}

.social-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
}

.social-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

/* Columns */
.footer-col-title {
    font-size: 14px;
    font-weight: 700;
    color: white;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.footer-links a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    font-size: 13px;
    transition: color 0.15s, padding-right 0.15s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.footer-links a::before {
    content: '›';
    font-size: 16px;
    opacity: 0.5;
}

.footer-links a:hover {
    color: white;
    padding-right: 4px;
}

/* Contact info */
.contact-info { display: flex; flex-direction: column; gap: 8px; }

.contact-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: rgba(255,255,255,0.65);
}

/* Newsletter */
.footer-newsletter {}

.newsletter-desc {
    font-size: 13px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 14px;
    line-height: 1.6;
}

.newsletter-form {
    display: flex;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.2);
}

.newsletter-input {
    flex: 1;
    background: rgba(255,255,255,0.08);
    border: none;
    outline: none;
    padding: 10px 14px;
    font-size: 13px;
    color: white;
}

.newsletter-input::placeholder { color: rgba(255,255,255,0.4); }

.newsletter-btn {
    background: white;
    border: none;
    padding: 0 16px;
    cursor: pointer;
    color: #1a237e;
    transition: background 0.15s;
    display: flex;
    align-items: center;
}

.newsletter-btn:hover { background: #e8eaf6; }
.newsletter-btn:disabled { opacity: 0.6; cursor: not-allowed; }

.subscribe-msg {
    font-size: 12px;
    color: rgba(255,255,255,0.85);
    margin-top: 8px;
}

/* App badges */
.app-badges { display: flex; gap: 10px; }

.app-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 10px;
    padding: 8px 12px;
    color: white;
    cursor: pointer;
    transition: background 0.15s;
    flex: 1;
}

.app-badge:hover { background: rgba(255,255,255,0.18); }

/* Bottom bar */
.footer-bottom {
    background: rgba(0,0,0,0.25);
    padding: 14px 0;
}

.footer-bottom-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 12px;
    color: rgba(255,255,255,0.6);
}

.bottom-links {
    display: flex;
    align-items: center;
    gap: 8px;
}

.bottom-links a {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    transition: color 0.15s;
}

.bottom-links a:hover { color: white; }
</style>
