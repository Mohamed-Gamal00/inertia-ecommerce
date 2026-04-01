/**
 * Recently viewed products — stored in localStorage
 */
export function useRecentlyViewed() {
    const KEY   = 'recently_viewed';
    const LIMIT = 8;

    function getAll() {
        try { return JSON.parse(localStorage.getItem(KEY) || '[]'); }
        catch { return []; }
    }

    function add(product) {
        if (!product?.id) return;
        let list = getAll().filter(p => p.id !== product.id);
        list.unshift({
            id:             product.id,
            name:           product.name,
            slug:           product.slug,
            price:          product.price,
            discount_price: product.discount_price,
            image_url:      product.image_url,
        });
        localStorage.setItem(KEY, JSON.stringify(list.slice(0, LIMIT)));
    }

    function getExcluding(id) {
        return getAll().filter(p => p.id !== id).slice(0, 6);
    }

    return { add, getAll, getExcluding };
}
