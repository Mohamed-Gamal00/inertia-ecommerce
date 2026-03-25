<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('product_availabilities')) {
            Schema::create('product_availabilities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_en')->nullable();
            });
        }

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_en')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('discount_price', 10, 2)->nullable();
                $table->boolean('status')->default(true);
                $table->foreignId('category_id')->nullable()->constrained('main_categories')->nullOnDelete();
                $table->foreignId('parent_id')->nullable()->constrained('main_categories')->nullOnDelete();
                $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
                $table->foreignId('main_category_setting_id')->nullable()->constrained('main_category_settings')->nullOnDelete();
                $table->foreignId('product_availability_id')->nullable()->constrained('product_availabilities')->nullOnDelete();
                $table->integer('quantity')->default(0);
                $table->boolean('is_special')->default(false);
                $table->decimal('weight', 8, 2)->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_features')) {
            Schema::create('product_features', function (Blueprint $table) {
                $table->id();
                $table->string('feature_name');
                $table->string('feature_name_en')->nullable();
                $table->text('feature_description')->nullable();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('color_product')) {
            Schema::create('color_product', function (Blueprint $table) {
                $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['color_id', 'product_id']);
            });
        }

        if (!Schema::hasTable('choices_products')) {
            Schema::create('choices_products', function (Blueprint $table) {
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['choice_id', 'product_id']);
            });
        }

        if (!Schema::hasTable('product_sub_settings')) {
            Schema::create('product_sub_settings', function (Blueprint $table) {
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->foreignId('sub_settings_id')->constrained('sub_settings')->cascadeOnDelete();
                $table->primary(['product_id', 'sub_settings_id']);
            });
        }

        if (!Schema::hasTable('wishlist_products_user')) {
            Schema::create('wishlist_products_user', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['user_id', 'product_id']);
            });
        }

        if (!Schema::hasTable('wishlist_products_guest')) {
            Schema::create('wishlist_products_guest', function (Blueprint $table) {
                $table->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['guest_id', 'product_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist_products_guest');
        Schema::dropIfExists('wishlist_products_user');
        Schema::dropIfExists('product_sub_settings');
        Schema::dropIfExists('choices_products');
        Schema::dropIfExists('color_product');
        Schema::dropIfExists('product_features');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_availabilities');
    }
};
