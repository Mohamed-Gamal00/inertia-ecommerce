<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('product_sub_settings');
        Schema::dropIfExists('sub_settings');
        Schema::dropIfExists('sec_sub_categories');
        Schema::dropIfExists('first_sub_categories');
    }

    public function down(): void
    {
        if (!Schema::hasTable('first_sub_categories')) {
            Schema::create('first_sub_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('category_id')->constrained('main_categories')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('sec_sub_categories')) {
            Schema::create('sec_sub_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('first_subcategory')->constrained('first_sub_categories')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('sub_settings')) {
            Schema::create('sub_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_sub_settings')) {
            Schema::create('product_sub_settings', function (Blueprint $table) {
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->foreignId('sub_settings_id')->constrained('sub_settings')->cascadeOnDelete();
                $table->primary(['product_id', 'sub_settings_id']);
            });
        }
    }
};
