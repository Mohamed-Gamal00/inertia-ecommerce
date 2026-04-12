<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for better query performance
        // Using raw SQL to avoid Doctrine DBAL dependency
        
        try {
            // Check and add index on order_items.product_id
            if (!$this->indexExists('order_items', 'order_items_product_id_index')) {
                DB::statement('CREATE INDEX order_items_product_id_index ON order_items(product_id)');
            }
        } catch (\Exception $e) {
            // Index might already exist, skip
        }

        try {
            // Check and add index on products.company_id
            if (!$this->indexExists('products', 'products_company_id_index')) {
                DB::statement('CREATE INDEX products_company_id_index ON products(company_id)');
            }
        } catch (\Exception $e) {
            // Index might already exist, skip
        }

        try {
            // Check and add index on products.status
            if (!$this->indexExists('products', 'products_status_index')) {
                DB::statement('CREATE INDEX products_status_index ON products(status)');
            }
        } catch (\Exception $e) {
            // Index might already exist, skip
        }

        try {
            // Check and add index on orders.payment_status
            if (!$this->indexExists('orders', 'orders_payment_status_index')) {
                DB::statement('CREATE INDEX orders_payment_status_index ON orders(payment_status)');
            }
        } catch (\Exception $e) {
            // Index might already exist, skip
        }

        try {
            // Check and add index on orders.created_at
            if (!$this->indexExists('orders', 'orders_created_at_index')) {
                DB::statement('CREATE INDEX orders_created_at_index ON orders(created_at)');
            }
        } catch (\Exception $e) {
            // Index might already exist, skip
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('DROP INDEX IF EXISTS order_items_product_id_index ON order_items');
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            DB::statement('DROP INDEX IF EXISTS products_company_id_index ON products');
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            DB::statement('DROP INDEX IF EXISTS products_status_index ON products');
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            DB::statement('DROP INDEX IF EXISTS orders_payment_status_index ON orders');
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            DB::statement('DROP INDEX IF EXISTS orders_created_at_index ON orders');
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $index): bool
    {
        $result = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]);
        return !empty($result);
    }
};
