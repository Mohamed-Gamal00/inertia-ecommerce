<template>
    <Head>
        <title>{{ fullTitle }}</title>
        <meta v-if="description" name="description" :content="description" />
        <meta v-if="keywords" name="keywords" :content="keywords" />

        <!-- Open Graph -->
        <meta property="og:type"        content="website" />
        <meta property="og:site_name"   :content="siteName" />
        <meta property="og:title"       :content="ogTitle || fullTitle" />
        <meta v-if="ogDesc"  property="og:description" :content="ogDesc" />
        <meta v-if="ogImage" property="og:image"       :content="ogImage" />
        <meta property="og:url"         :content="canonical" />

        <!-- Twitter Card -->
        <meta name="twitter:card"        :content="twCard" />
        <meta name="twitter:title"       :content="twTitle || fullTitle" />
        <meta v-if="twDesc"  name="twitter:description" :content="twDesc" />
        <meta v-if="twImage" name="twitter:image"       :content="twImage" />

        <!-- Canonical -->
        <link rel="canonical" :href="canonical" />
    </Head>
</template>

<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    title:       { type: String, default: '' },
    description: { type: String, default: '' },
    keywords:    { type: String, default: '' },
    image:       { type: String, default: '' },
    canonical:   { type: String, default: '' },
});

const { props: pageProps } = usePage();
const global = computed(() => pageProps.seo || {});

const siteName    = computed(() => global.value.site_name || '');
const fullTitle   = computed(() => props.title
    ? `${props.title} — ${siteName.value}`
    : (global.value.meta_title || siteName.value));
const description = computed(() => props.description || global.value.meta_description || '');
const keywords    = computed(() => props.keywords    || global.value.meta_keywords    || '');
const ogTitle     = computed(() => props.title       || global.value.og_title         || fullTitle.value);
const ogDesc      = computed(() => description.value || global.value.og_description   || '');
const ogImage     = computed(() => props.image       || global.value.og_image         || '');
const twCard      = computed(() => global.value.twitter_card || 'summary_large_image');
const twTitle     = computed(() => ogTitle.value);
const twDesc      = computed(() => ogDesc.value);
const twImage     = computed(() => props.image || global.value.twitter_image || ogImage.value);
const canonical   = computed(() => props.canonical || global.value.canonical_url || (typeof window !== 'undefined' ? window.location.href : ''));
</script>
