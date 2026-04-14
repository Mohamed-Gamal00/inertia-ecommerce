<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

final class CartSingleVendor
{
    /**
     * Normalize vendor bucket: same company_id (including null) = same checkout.
     */
    public static function vendorKey(?Product $product): string
    {
        if (! $product) {
            return '0';
        }

        return (string) ($product->company_id ?? '0');
    }

    /**
     * @param  Collection<int, \App\Models\Cart>  $cartLines  Lines must load product when possible.
     */
    public static function validateCartLinesForProduct(Collection $cartLines, Product $productToAdd): ?string
    {
        // Multi-vendor support: Allow products from different vendors
        // The checkout process will handle splitting orders by vendor
        return null;
    }

    /**
     * @param  Collection<int, \App\Models\Cart>  $cartLines
     *
     * @throws \InvalidArgumentException
     */
    public static function assertCheckoutCartSingleVendor(Collection $cartLines): void
    {
        // Multi-vendor support: Allow checkout with multiple vendors
        // The MultiVendorOrderService will handle splitting orders by vendor
        return;
    }

    /**
     * Resolved company_id for a single-vendor cart (null = legacy / platform bucket).
     * For multi-vendor carts, returns null (will be handled by MultiVendorOrderService)
     *
     * @param  Collection<int, \App\Models\Cart>  $cartLines
     */
    public static function resolveCompanyId(Collection $cartLines): ?int
    {
        $withProduct = $cartLines->filter(fn ($line) => $line->product);
        if ($withProduct->isEmpty()) {
            return null;
        }

        // Check if cart has multiple vendors
        $vendorIds = $withProduct->map(fn ($line) => $line->product->company_id)->unique()->filter();

        // If multiple vendors, return null (multi-vendor cart)
        if ($vendorIds->count() > 1) {
            return null;
        }

        // Single vendor cart
        $first = $cartLines->first(fn ($line) => $line->product);
        if (! $first || ! $first->product) {
            return null;
        }

        return $first->product->company_id;
    }
}
