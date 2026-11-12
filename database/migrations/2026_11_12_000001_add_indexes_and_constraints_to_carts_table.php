<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds performance indexes and a partial unique constraint to the carts table.
 *
 * The unique constraint uses a generated column (active_key) that is non-NULL
 * only for active cart items (status = 0). This simulates a partial unique index
 * (WHERE status = 0) which MySQL does not natively support.
 *
 * active_key = CASE WHEN status = 0 THEN
 *   CONCAT(COALESCE(CONCAT('u:', user_id), CONCAT('g:', cookie_id)), ':p:', product_id)
 * END
 *
 * For authenticated users the key is based on user_id; for guests on cookie_id.
 * This prevents duplicate active rows for the same product in the same cart.
 */
return new class extends Migration
{
    public function up(): void
    {
        // --- 1. Performance indexes (idempotent — DDL auto-commits in MySQL) ---
        Schema::table('carts', function (Blueprint $table) {
            if (!$this->indexExists('carts', 'carts_cookie_id_index')) {
                $table->index('cookie_id', 'carts_cookie_id_index');
            }
            if (!$this->indexExists('carts', 'carts_user_id_index')) {
                $table->index('user_id', 'carts_user_id_index');
            }
            if (!$this->indexExists('carts', 'carts_cookie_product_status_index')) {
                $table->index(['cookie_id', 'product_id', 'status'], 'carts_cookie_product_status_index');
            }
            if (!$this->indexExists('carts', 'carts_user_product_status_index')) {
                $table->index(['user_id', 'product_id', 'status'], 'carts_user_product_status_index');
            }
        });

        // --- 2. Clean up duplicate active items before adding the unique constraint ---
        $this->deduplicateByOwner('cookie_id', true);
        $this->deduplicateByOwner('user_id', false);

        // --- 3. Add generated column + unique index for active items ---
        if (!$this->columnExists('carts', 'active_key')) {
            DB::statement(
                "ALTER TABLE carts ADD COLUMN active_key VARCHAR(255)
                 GENERATED ALWAYS AS (
                    CASE WHEN status = 0 THEN
                        CONCAT(
                            COALESCE(CONCAT('u:', user_id), CONCAT('g:', cookie_id)),
                            ':p:',
                            product_id
                        )
                    END
                 ) VIRTUAL"
            );
        }

        if (!$this->indexExists('carts', 'carts_active_key_unique')) {
            DB::statement("ALTER TABLE carts ADD UNIQUE INDEX carts_active_key_unique (active_key)");
        }
    }

    public function down(): void
    {
        if ($this->indexExists('carts', 'carts_active_key_unique')) {
            DB::statement("ALTER TABLE carts DROP INDEX carts_active_key_unique");
        }
        if ($this->columnExists('carts', 'active_key')) {
            DB::statement("ALTER TABLE carts DROP COLUMN active_key");
        }

        Schema::table('carts', function (Blueprint $table) {
            foreach (['carts_cookie_id_index', 'carts_user_id_index', 'carts_cookie_product_status_index', 'carts_user_product_status_index'] as $idx) {
                if ($this->indexExists('carts', $idx)) {
                    $table->dropIndex($idx);
                }
            }
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$index]))->isNotEmpty();
    }

    private function columnExists(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }

    /**
     * Mark duplicate active cart items as completed (status = 1),
     * keeping the one with the highest quantity.
     *
     * @param string $ownerColumn  'cookie_id' or 'user_id'
     * @param bool   $isGuest      true for guests (user_id IS NULL), false for users
     */
    private function deduplicateByOwner(string $ownerColumn, bool $isGuest): void
    {
        $baseQuery = DB::table('carts')->where('status', 0);

        if ($isGuest) {
            $baseQuery->whereNull('user_id');
        } else {
            $baseQuery->whereNotNull('user_id');
        }

        $duplicates = (clone $baseQuery)
            ->select($ownerColumn, 'product_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy($ownerColumn, 'product_id')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $items = (clone $baseQuery)
                ->where($ownerColumn, $dup->{$ownerColumn})
                ->where('product_id', $dup->product_id)
                ->orderBy('quantity', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();

            $keepId = $items->first()->id;

            (clone $baseQuery)
                ->where($ownerColumn, $dup->{$ownerColumn})
                ->where('product_id', $dup->product_id)
                ->where('id', '!=', $keepId)
                ->update(['status' => 1]);
        }
    }
};
