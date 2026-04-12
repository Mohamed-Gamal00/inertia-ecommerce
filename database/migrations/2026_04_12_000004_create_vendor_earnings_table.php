<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $table->decimal('item_total', 10, 2)->comment('Item price * quantity');
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('vendor_amount', 10, 2)->comment('Amount vendor receives');
            $table->decimal('commission_rate', 5, 2);
            $table->enum('status', ['pending', 'available', 'paid'])->default('pending');
            $table->foreignId('payout_id')->nullable()->constrained('vendor_payouts')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['company_id', 'status']);
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_earnings');
    }
};
