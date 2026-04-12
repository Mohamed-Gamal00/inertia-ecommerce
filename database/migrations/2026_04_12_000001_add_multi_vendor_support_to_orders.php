<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // For multi-vendor order splitting
            $table->foreignId('parent_order_id')->nullable()->after('id')->constrained('orders')->cascadeOnDelete();
            $table->boolean('is_parent')->default(false)->after('parent_order_id');
            
            // Make company_id required for sub-orders
            $table->index('company_id');
            $table->index('parent_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['parent_order_id']);
            $table->dropColumn(['parent_order_id', 'is_parent']);
        });
    }
};
