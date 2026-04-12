import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

// Translation dictionaries loaded from lang files
import ar from '../../../lang/ar.json';
import en from '../../../lang/en.json';

const translations = { ar, en };

export function useLocale() {
    const { props } = usePage();

    const locale  = computed(() => props.locale || 'ar');
    const isAr    = computed(() => locale.value === 'ar');
    const isEn    = computed(() => locale.value === 'en');
    const dir     = computed(() => isAr.value ? 'rtl' : 'ltr');

    /**
     * Translate a key.
     * t('add_to_cart') → 'أضف للسلة' or 'Add to Cart'
     */
    function t(key) {
        return translations[locale.value]?.[key] ?? translations['ar']?.[key] ?? key;
    }

    /**
     * Pick the right field from a bilingual object.
     * pick(product, 'name') → product.name_en (if en) or product.name (if ar)
     */
    function pick(obj, field) {
        if (!obj) return '';
        if (isEn.value && obj[`${field}_en`]) return obj[`${field}_en`];
        return obj[field] ?? '';
    }

    /**
     * Switch locale — posts to /locale/{lang} and reloads.
     */
    function switchLocale(lang) {
        router.post(`/locale/${lang}`, {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Force full reload so html dir attribute updates
                window.location.reload();
            },
        });
    }

    return { locale, isAr, isEn, dir, t, pick, switchLocale };
}
