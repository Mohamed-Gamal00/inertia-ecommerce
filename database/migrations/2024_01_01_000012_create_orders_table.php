<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('order_statuses')) {
            Schema::create('order_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_en')->nullable();
                $table->boolean('default_status')->default(false);
                $table->integer('arrangement')->default(0);
            });
        }

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('number')->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('cookie_id')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('status')->default('pending');
                $table->string('payment_status')->default('unpaid');
                $table->foreignId('order_status_id')->nullable()->constrained('order_statuses')->nullOnDelete();
                $table->boolean('return_order')->default(false);
                $table->text('note')->nullable();
                $table->decimal('totalBeforeDiscount', 10, 2)->nullable();
                $table->decimal('total_price', 10, 2)->default(0);
                $table->decimal('shipping_price', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
                $table->string('product_name')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('quantity')->default(1);
            });
        }

        if (!Schema::hasTable('order_addresses')) {
            Schema::create('order_addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->string('type')->default('shipping');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable();
                $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->string('address')->nullable();
            });
        }

        if (!Schema::hasTable('order_choices')) {
            Schema::create('order_choices', function (Blueprint $table) {
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_item_choices')) {
            Schema::create('order_item_choices', function (Blueprint $table) {
                $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('return_products')) {
            Schema::create('return_products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('guest_id')->nullable()->constrained('guests')->nullOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('return_products');
        Schema::dropIfExists('order_item_choices');
        Schema::dropIfExists('order_choices');
        Schema::dropIfExists('order_addresses');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_statuses');
    }
};
