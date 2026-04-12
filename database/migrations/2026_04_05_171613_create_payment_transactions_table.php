<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('moyasar_payment_id')->nullable()->index(); // Moyasar payment ID
            $table->string('status');                                   // paid, failed, initiated, authorized
            $table->decimal('amount', 10, 2);                          // in SAR (not halalas)
            $table->string('currency', 10)->default('SAR');
            $table->string('payment_method')->nullable();               // creditcard, stcpay, applepay
            $table->string('card_brand')->nullable();                   // visa, mastercard, mada
            $table->string('card_last_four', 4)->nullable();
            $table->string('description')->nullable();
            $table->text('raw_response')->nullable();                   // full JSON from Moyasar
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
