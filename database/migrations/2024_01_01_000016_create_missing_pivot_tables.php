<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Cart item choices pivot (order_item choices at cart level)
        if (!Schema::hasTable('cart_item_choices')) {
            Schema::create('cart_item_choices', function (Blueprint $table) {
                $table->uuid('cart_id');
                $table->foreign('cart_id')->references('id')->on('carts')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }

        // product_user (wishlist or general product-user pivot)
        if (!Schema::hasTable('product_user')) {
            Schema::create('product_user', function (Blueprint $table) {
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->primary(['product_id', 'user_id']);
            });
        }

        // user_discount_codes (separate from cookie_discount_ids)
        if (!Schema::hasTable('user_discount_codes')) {
            Schema::create('user_discount_codes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('discount_code_id')->constrained('discount_codes')->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_discount_codes');
        Schema::dropIfExists('product_user');
        Schema::dropIfExists('cart_item_choices');
    }
};
