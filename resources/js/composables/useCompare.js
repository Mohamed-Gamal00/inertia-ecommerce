import { ref } from 'vue';

const compareList = ref(JSON.parse(localStorage.getItem('compare_list') || '[]'));
const MAX = 4;

function save() {
    localStorage.setItem('compare_list', JSON.stringify(compareList.value));
}

export function useCompare() {
    function toggle(product) {
        const idx = compareList.value.findIndex(p => p.id === product.id);
        if (idx > -1) {
            compareList.value.splice(idx, 1);
        } else {
            if (compareList.value.length >= MAX) {
                compareList.value.shift(); // remove oldest
            }
            compareList.value.push({
                id:             product.id,
                name:           product.name,
                slug:           product.slug,
                price:          product.price,
                discount_price: product.discount_price,
                image_url:      product.image_url,
                parent:         product.parent,
            });
        }
        save();
    }

    function isInCompare(id) {
        return compareList.value.some(p => p.id === id);
    }

    function clear() {
        compareList.value = [];
        save();
    }

    return { compareList, toggle, isInCompare, clear, MAX };
}
