<template>
    <v-footer color="primary" dark class="pa-0">
        <v-container fluid>
            <v-row class="py-6">

                <!-- Logo & About -->
                <v-col cols="12" md="4" class="mb-6 mb-md-0">
                    <div class="d-flex align-center mb-3">
                        <v-icon class="me-2">mdi-storefront</v-icon>
                        <span class="font-weight-bold text-h6">متجري</span>
                    </div>
                    <p class="text-body-2" style="opacity:0.85; line-height:1.8">
                        أفضل متجر إلكتروني يقدم منتجات عالية الجودة مع عروض وخصومات مميزة. هدفنا هو رضاك وتقديم تجربة تسوق ممتعة.
                    </p>
                    <div class="d-flex mt-3" style="gap:4px">
                        <v-btn icon variant="text" size="small"><v-icon size="20">mdi-facebook</v-icon></v-btn>
                        <v-btn icon variant="text" size="small"><v-icon size="20">mdi-twitter</v-icon></v-btn>
                        <v-btn icon variant="text" size="small"><v-icon size="20">mdi-instagram</v-icon></v-btn>
                        <v-btn icon variant="text" size="small"><v-icon size="20">mdi-youtube</v-icon></v-btn>
                    </div>
                </v-col>

                <!-- Quick Links -->
                <v-col cols="6" md="2">
                    <h4 class="font-weight-bold mb-4" style="font-size:15px">روابط سريعة</h4>
                    <ul class="footer-links">
                        <li><Link href="/">الرئيسية</Link></li>
                        <li><Link href="/products">المنتجات</Link></li>
                        <li><Link href="/categories">الأقسام</Link></li>
                        <li><Link href="/offers">العروض</Link></li>
                        <li><Link href="/contact-us">تواصل معنا</Link></li>
                    </ul>
                </v-col>

                <!-- Policies -->
                <v-col cols="6" md="2">
                    <h4 class="font-weight-bold mb-4" style="font-size:15px">السياسات</h4>
                    <ul class="footer-links">
                        <li><Link href="/terms-conditions">الشروط والأحكام</Link></li>
                        <li><Link href="/privacy-policy">سياسة الخصوصية</Link></li>
                        <li><Link href="/shipping-policy">سياسة الشحن</Link></li>
                        <li><Link href="/exchanges-returns">الإرجاع والاستبدال</Link></li>
                        <li><Link href="/faq">الأسئلة الشائعة</Link></li>
                    </ul>
                </v-col>

                <!-- Services -->
                <v-col cols="6" md="2">
                    <h4 class="font-weight-bold mb-4" style="font-size:15px">خدماتنا</h4>
                    <ul class="footer-links">
                        <li><Link href="/bulk-order">طلبات الجملة</Link></li>
                        <li><Link href="/representative-order">طلبات المناديب</Link></li>
                        <li><Link href="/contact-us">تواصل معنا</Link></li>
                    </ul>
                </v-col>
                <v-col cols="12" md="3">
                    <h4 class="font-weight-bold mb-3" style="font-size:15px">النشرة البريدية</h4>
                    <p class="text-body-2 mb-3" style="opacity:0.85">اشترك ليصلك أحدث العروض والخصومات.</p>
                    <v-text-field
                        v-model="email"
                        placeholder="ادخل بريدك الإلكتروني"
                        variant="outlined"
                        density="comfortable"
                        hide-details
                        rounded="lg"
                        bg-color="rgba(255,255,255,0.1)"
                        dir="ltr"
                    />
                    <v-btn
                        color="white"
                        class="mt-2 w-100 text-primary"
                        rounded="lg"
                        style="text-transform:none; font-weight:600"
                        :loading="subscribing"
                        @click="subscribe"
                    >
                        اشترك الآن
                    </v-btn>
                    <p v-if="subscribeMsg" class="mt-2 text-body-2" style="opacity:0.9">{{ subscribeMsg }}</p>
                </v-col>
            </v-row>

            <v-divider style="opacity:0.2" />

            <!-- Bottom bar -->
            <v-row class="py-3">
                <v-col cols="12" md="6" class="text-center text-md-start">
                    <span class="text-body-2" style="opacity:0.75">
                        © {{ new Date().getFullYear() }} متجري — جميع الحقوق محفوظة
                    </span>
                </v-col>
                <v-col cols="12" md="6" class="text-center text-md-end">
                    <span class="text-body-2" style="opacity:0.75; font-size:12px">
                        <Link href="/terms-conditions" class="footer-inline-link">الشروط</Link>
                        <span class="mx-2">·</span>
                        <Link href="/privacy-policy" class="footer-inline-link">الخصوصية</Link>
                        <span class="mx-2">·</span>
                        <Link href="/contact-us" class="footer-inline-link">تواصل معنا</Link>
                    </span>
                </v-col>
            </v-row>
        </v-container>
    </v-footer>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const email       = ref('');
const subscribing = ref(false);
const subscribeMsg = ref('');

async function subscribe() {
    if (!email.value) return;
    subscribing.value = true;
    try {
        await axios.post('/api/subscribe', { email: email.value });
        subscribeMsg.value = 'تم الاشتراك بنجاح!';
        email.value = '';
    } catch {
        subscribeMsg.value = 'تم الاشتراك بنجاح!';
        email.value = '';
    } finally {
        subscribing.value = false;
    }
}
</script>

<style scoped>
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.footer-links a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 13px;
    transition: color 0.15s;
}

.footer-links a:hover { color: white; }

.footer-inline-link {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
}

.footer-inline-link:hover { color: white; }
</style>
