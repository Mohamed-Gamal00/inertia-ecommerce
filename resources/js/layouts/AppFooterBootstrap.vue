<template>
  <footer class="site-footer">

    <!-- Top Wave -->
    <div class="footer-wave">
      <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#1a237e" />
      </svg>
    </div>

    <!-- Main Footer Body -->
    <div class="footer-body">
      <div class="container-fluid" style="max-width: 1280px;">
        <div class="row g-4">

          <!-- Brand Column -->
          <div class="col-12 col-md-6 col-lg-3">
            <div class="footer-brand">
              <div class="brand-logo">
                <i class="bi bi-shop" style="font-size: 28px;"></i>
                <span>{{ siteName }}</span>
              </div>
              <p class="brand-desc">{{ t('footer_tagline') }}</p>

              <!-- Trust Badges -->
              <div class="trust-badges">
                <div class="trust-badge">
                  <i class="bi bi-shield-check"></i>
                  <span>{{ t('footer_secure_payment') }}</span>
                </div>
                <div class="trust-badge">
                  <i class="bi bi-truck"></i>
                  <span>{{ t('footer_fast_shipping') }}</span>
                </div>
                <div class="trust-badge">
                  <i class="bi bi-arrow-repeat"></i>
                  <span>{{ t('footer_free_returns') }}</span>
                </div>
              </div>

              <!-- Social Links -->
              <div class="social-links">
                <a href="#" class="social-btn" aria-label="Facebook">
                  <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="social-btn" aria-label="Twitter">
                  <i class="bi bi-twitter"></i>
                </a>
                <a href="#" class="social-btn" aria-label="Instagram">
                  <i class="bi bi-instagram"></i>
                </a>
                <a href="#" class="social-btn" aria-label="Snapchat">
                  <i class="bi bi-snapchat"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Quick Links Column -->
          <div class="col-6 col-md-6 col-lg-2">
            <div class="footer-col">
              <h5 class="footer-col-title">{{ t('footer_quick_links') }}</h5>
              <ul class="footer-links">
                <li><Link href="/">{{ t('home') }}</Link></li>
                <li><Link href="/products">{{ t('products') }}</Link></li>
                <li><Link href="/categories">{{ t('categories') }}</Link></li>
                <li><Link href="/brands">{{ t('brands') }}</Link></li>
                <li><Link href="/offers">{{ t('offers') }}</Link></li>
                <li><Link href="/contact-us">{{ t('contact_us') }}</Link></li>
              </ul>
            </div>
          </div>

          <!-- Policies Column -->
          <div class="col-6 col-md-6 col-lg-2">
            <div class="footer-col">
              <h5 class="footer-col-title">{{ t('footer_policies') }}</h5>
              <ul class="footer-links">
                <li><Link href="/terms-conditions">{{ t('footer_terms') }}</Link></li>
                <li><Link href="/privacy-policy">{{ t('footer_privacy') }}</Link></li>
                <li><Link href="/shipping-policy">{{ t('footer_shipping_policy') }}</Link></li>
                <li><Link href="/exchanges-returns">{{ t('footer_exchanges') }}</Link></li>
                <li><Link href="/faq">{{ t('footer_faq') }}</Link></li>
              </ul>
            </div>
          </div>

          <!-- Services Column -->
          <div class="col-6 col-md-6 col-lg-2">
            <div class="footer-col">
              <h5 class="footer-col-title">{{ t('footer_services') }}</h5>
              <ul class="footer-links">
                <li><Link href="/bulk-order">{{ t('footer_bulk') }}</Link></li>
                <li><Link href="/representative-order">{{ t('footer_reps') }}</Link></li>
                <li><Link href="/contact-us">{{ t('contact_us') }}</Link></li>
              </ul>

              <!-- Contact Info -->
              <div class="contact-info mt-4">
                <div class="contact-item">
                  <i class="bi bi-telephone"></i>
                  <span dir="ltr">+966 50 000 0000</span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-envelope"></i>
                  <span>info@store.com</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Newsletter Column -->
          <div class="col-12 col-md-6 col-lg-3">
            <div class="footer-newsletter">
              <h5 class="footer-col-title">{{ t('footer_newsletter') }}</h5>
              <p class="newsletter-desc">{{ t('footer_newsletter_desc') }}</p>

              <div class="newsletter-form">
                <input
                  v-model="email"
                  type="email"
                  :placeholder="t('footer_newsletter_placeholder')"
                  class="newsletter-input"
                  dir="ltr"
                  @keyup.enter="subscribe"
                >
                <button
                  class="newsletter-btn"
                  :disabled="subscribing"
                  @click="subscribe"
                >
                  <i class="bi bi-send"></i>
                </button>
              </div>

              <p v-if="subscribeMsg" class="subscribe-msg">{{ subscribeMsg }}</p>

              <!-- App Badges -->
              <div class="app-badges mt-4">
                <div class="app-badge">
                  <i class="bi bi-apple"></i>
                  <div>
                    <div style="font-size: 9px; opacity: 0.7;">{{ t('footer_download_from') }}</div>
                    <div style="font-size: 12px; font-weight: 700;">App Store</div>
                  </div>
                </div>
                <div class="app-badge">
                  <i class="bi bi-google-play"></i>
                  <div>
                    <div style="font-size: 9px; opacity: 0.7;">{{ t('footer_download_from') }}</div>
                    <div style="font-size: 12px; font-weight: 700;">Google Play</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
      <div class="container-fluid" style="max-width: 1280px;">
        <div class="footer-bottom-inner">
          <span>© {{ new Date().getFullYear() }} {{ siteName }} — {{ t('footer_rights') }}</span>
          <div class="bottom-links">
            <Link href="/terms-conditions">{{ t('footer_terms_short') }}</Link>
            <span>·</span>
            <Link href="/privacy-policy">{{ t('footer_privacy_short') }}</Link>
            <span>·</span>
            <Link href="/contact-us">{{ t('contact_us') }}</Link>
          </div>
        </div>
      </div>
    </div>

  </footer>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { useLocale } from '../composables/useLocale';

const email = ref('');
const subscribing = ref(false);
const subscribeMsg = ref('');
const siteName = computed(() => usePage().props.seo?.site_name || 'متجري');
const { t } = useLocale();

async function subscribe() {
  if (!email.value.trim()) return;
  subscribing.value = true;
  subscribeMsg.value = '';

  try {
    const { data } = await axios.post('/subscribe', { email: email.value.trim() });
    subscribeMsg.value = data.message;
    email.value = '';
  } catch (e) {
    subscribeMsg.value = e.response?.data?.message || 'حدث خطأ، حاول مرة أخرى';
  } finally {
    subscribing.value = false;
  }
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
  padding: 48px 24px 32px;
  color: white;
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
  color: rgba(255, 255, 255, 0.75);
  line-height: 1.8;
  margin-bottom: 16px;
  max-width: 320px;
}

/* Trust Badges */
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
  background: rgba(255, 255, 255, 0.1);
  border-radius: 20px;
  padding: 4px 10px;
  font-size: 11px;
  color: rgba(255, 255, 255, 0.85);
}

.trust-badge i {
  font-size: 14px;
}

/* Social Links */
.social-links {
  display: flex;
  gap: 8px;
}

.social-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.12);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-decoration: none;
  transition: background 0.2s, transform 0.2s;
  font-size: 18px;
}

.social-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
}

/* Footer Columns */
.footer-col-title {
  font-size: 14px;
  font-weight: 700;
  color: white;
  margin-bottom: 16px;
  padding-bottom: 8px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
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
  color: rgba(255, 255, 255, 0.7);
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

/* Contact Info */
.contact-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: rgba(255, 255, 255, 0.65);
}

.contact-item i {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.6);
}

/* Newsletter */
.newsletter-desc {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 14px;
  line-height: 1.6;
}

.newsletter-form {
  display: flex;
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.newsletter-input {
  flex: 1;
  background: rgba(255, 255, 255, 0.08);
  border: none;
  outline: none;
  padding: 10px 14px;
  font-size: 13px;
  color: white;
}

.newsletter-input::placeholder {
  color: rgba(255, 255, 255, 0.4);
}

.newsletter-btn {
  background: white;
  border: none;
  padding: 0 16px;
  cursor: pointer;
  color: #1a237e;
  transition: background 0.15s;
  display: flex;
  align-items: center;
  font-size: 18px;
}

.newsletter-btn:hover {
  background: #e8eaf6;
}

.newsletter-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.subscribe-msg {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.85);
  margin-top: 8px;
}

/* App Badges */
.app-badges {
  display: flex;
  gap: 10px;
}

.app-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  padding: 8px 12px;
  color: white;
  cursor: pointer;
  transition: background 0.15s;
  flex: 1;
}

.app-badge:hover {
  background: rgba(255, 255, 255, 0.18);
}

.app-badge i {
  font-size: 20px;
}

/* Footer Bottom */
.footer-bottom {
  background: rgba(0, 0, 0, 0.25);
  padding: 14px 24px;
}

.footer-bottom-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 12px;
  color: rgba(255, 255, 255, 0.6);
}

.bottom-links {
  display: flex;
  align-items: center;
  gap: 8px;
}

.bottom-links a {
  color: rgba(255, 255, 255, 0.6);
  text-decoration: none;
  transition: color 0.15s;
}

.bottom-links a:hover {
  color: white;
}

@media (max-width: 768px) {
  .footer-bottom-inner {
    flex-direction: column;
    text-align: center;
  }
}
</style>

