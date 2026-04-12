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
        $withProduct = $cartLines->filter(fn ($line) => $line->product);
        if ($withProduct->isEmpty()) {
            return null;
        }

        $keys = $withProduct->map(fn ($line) => self::vendorKey($line->product))->unique()->values();
        if ($keys->count() > 1) {
            return 'سلة التسوق تحتوي على منتجات من بائعين مختلفين. يرجى إفراغ السلة والبدء من جديد.';
        }

        $newKey = self::vendorKey($productToAdd);
        if ($keys->first() !== $newKey) {
            return 'لا يمكن إضافة منتج من بائع مختلف. أكمل طلبك الحالي أو أفرغ السلة.';
        }

        return null;
    }

    /**
     * @param  Collection<int, \App\Models\Cart>  $cartLines
     *
     * @throws \InvalidArgumentException
     */
    public static function assertCheckoutCartSingleVendor(Collection $cartLines): void
    {
        $withProduct = $cartLines->filter(fn ($line) => $line->product);
        if ($withProduct->isEmpty()) {
            return;
        }

        $keys = $withProduct->map(fn ($line) => self::vendorKey($line->product))->unique();
        if ($keys->count() > 1) {
            throw new \InvalidArgumentException(
                'لا يمكن إتمام الطلب: السلة تحتوي على منتجات من أكثر من بائع. أفرغ السلة أو أزل المنتجات غير المتوافقة.'
            );
        }
    }

    /**
     * Resolved company_id for a single-vendor cart (null = legacy / platform bucket).
     *
     * @param  Collection<int, \App\Models\Cart>  $cartLines
     */
    public static function resolveCompanyId(Collection $cartLines): ?int
    {
        $first = $cartLines->first(fn ($line) => $line->product);
        if (! $first || ! $first->product) {
            return null;
        }

        return $first->product->company_id;
    }
}
