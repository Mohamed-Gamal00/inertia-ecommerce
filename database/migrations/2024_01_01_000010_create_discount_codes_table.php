<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('discount_codes')) {
            Schema::create('discount_codes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->decimal('price', 10, 2)->default(0);
                $table->boolean('status')->default(true);
                $table->string('discount_type')->default('fixed');
                $table->integer('number_of_used')->default(0);
                $table->text('product_ids')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('discount_code_product')) {
            Schema::create('discount_code_product', function (Blueprint $table) {
                $table->foreignId('discount_code_id')->constrained('discount_codes')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['discount_code_id', 'product_id']);
            });
        }

        if (!Schema::hasTable('cookie_discount_ids')) {
            Schema::create('cookie_discount_ids', function (Blueprint $table) {
                $table->id();
                $table->string('cookie_id');
                $table->foreignId('discount_id')->constrained('discount_codes')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cookie_discount_ids');
        Schema::dropIfExists('discount_code_product');
        Schema::dropIfExists('discount_codes');
    }
};
