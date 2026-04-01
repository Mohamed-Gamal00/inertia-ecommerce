/**
 * useSeo — composable for per-page SEO meta tags via Inertia Head.
 *
 * Usage in any Vue page:
 *   import { useSeo } from '@/composables/useSeo';
 *   useSeo({ title: 'Product Name', description: 'Great product', image: 'https://...' });
 *
 * Falls back to global SEO settings from props.seo when page-level values are not provided.
 */
import { computed } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';

export function useSeo(pageMeta = {}) {
    const { props } = usePage();
    const global    = computed(() => props.seo || {});

    const title       = computed(() => pageMeta.title       || global.value.meta_title       || global.value.site_name || '');
    const description = computed(() => pageMeta.description || global.value.meta_description || '');
    const keywords    = computed(() => pageMeta.keywords    || global.value.meta_keywords    || '');
    const ogTitle     = computed(() => pageMeta.ogTitle     || pageMeta.title || global.value.og_title || title.value);
    const ogDesc      = computed(() => pageMeta.ogDesc      || description.value || global.value.og_description || '');
    const ogImage     = computed(() => pageMeta.image       || global.value.og_image || '');
    const twTitle     = computed(() => pageMeta.twTitle     || ogTitle.value);
    const twDesc      = computed(() => pageMeta.twDesc      || ogDesc.value);
    const twImage     = computed(() => pageMeta.twImage     || ogImage.value || global.value.twitter_image || '');
    const twCard      = computed(() => global.value.twitter_card || 'summary_large_image');
    const siteName    = computed(() => global.value.site_name || '');
    const canonical   = computed(() => pageMeta.canonical   || global.value.canonical_url || window.location.href);

    return { title, description, keywords, ogTitle, ogDesc, ogImage, twTitle, twDesc, twImage, twCard, siteName, canonical };
}
