/**
 * Cart fly animation — product image flies to the cart icon, no drawer open
 */
export function useCartFly() {

    function flyToCart(sourceEl) {
        const cartIcon = document.querySelector('[data-cart-icon]');
        if (!cartIcon) return;

        // Get positions
        const destRect = cartIcon.getBoundingClientRect();
        const destX = destRect.left + destRect.width / 2;
        const destY = destRect.top + destRect.height / 2;

        // Source position — use element center or fallback to center of screen
        let srcX = window.innerWidth / 2;
        let srcY = window.innerHeight / 2;

        if (sourceEl) {
            const srcRect = sourceEl.getBoundingClientRect();
            srcX = srcRect.left + srcRect.width / 2;
            srcY = srcRect.top + srcRect.height / 2;
        }

        // Create flying dot
        const fly = document.createElement('div');
        const size = 52;
        fly.style.cssText = `
            position: fixed;
            z-index: 99999;
            width: ${size}px;
            height: ${size}px;
            border-radius: 50%;
            overflow: hidden;
            pointer-events: none;
            box-shadow: 0 6px 24px rgba(26,35,126,0.4);
            border: 2px solid white;
            top: ${srcY - size / 2}px;
            left: ${srcX - size / 2}px;
            transition: none;
            will-change: transform, opacity;
        `;

        // Use product image
        const img = sourceEl?.querySelector('img');
        if (img) {
            const clone = img.cloneNode();
            clone.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
            fly.appendChild(clone);
        } else {
            fly.style.background = 'linear-gradient(135deg,#1a237e,#3949ab)';
            fly.innerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:22px">🛒</div>';
        }

        document.body.appendChild(fly);

        // Step 1: slight scale up (excitement)
        requestAnimationFrame(() => {
            fly.style.transition = 'transform 0.15s ease';
            fly.style.transform = 'scale(1.15)';

            setTimeout(() => {
                // Step 2: fly to cart with arc
                const dx = destX - srcX;
                const dy = destY - srcY;

                fly.style.transition = 'all 0.65s cubic-bezier(0.4, 0, 0.2, 1)';
                fly.style.transform = `translate(${dx}px, ${dy}px) scale(0.15)`;
                fly.style.opacity = '0.6';
                fly.style.borderRadius = '50%';

                setTimeout(() => {
                    fly.remove();
                    triggerCartMagic(cartIcon);
                }, 660);
            }, 150);
        });
    }

    function triggerCartMagic(cartIcon) {
        // 1. Bounce + rotate
        cartIcon.style.transition = 'none';
        cartIcon.classList.add('cart-magic');

        // 2. Flash ring
        const ring = document.createElement('div');
        const rect = cartIcon.getBoundingClientRect();
        ring.style.cssText = `
            position: fixed;
            z-index: 99998;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 3px solid #ffd600;
            top: ${rect.top + rect.height / 2 - 24}px;
            left: ${rect.left + rect.width / 2 - 24}px;
            pointer-events: none;
            animation: ringExpand 0.5s ease-out forwards;
        `;
        document.body.appendChild(ring);
        setTimeout(() => ring.remove(), 520);

        // 3. Floating "+1" text
        const plus = document.createElement('div');
        plus.textContent = '+1';
        plus.style.cssText = `
            position: fixed;
            z-index: 99999;
            font-size: 14px;
            font-weight: 800;
            color: #ffd600;
            text-shadow: 0 1px 4px rgba(0,0,0,0.4);
            top: ${rect.top - 8}px;
            left: ${rect.left + rect.width / 2 - 10}px;
            pointer-events: none;
            animation: floatUp 0.7s ease-out forwards;
        `;
        document.body.appendChild(plus);
        setTimeout(() => plus.remove(), 720);

        setTimeout(() => cartIcon.classList.remove('cart-magic'), 600);
    }

    return { flyToCart };
}
