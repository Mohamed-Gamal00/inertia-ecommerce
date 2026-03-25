<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('shipping_companies')) {
            Schema::create('shipping_companies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('picture')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('shipping_locations')) {
            Schema::create('shipping_locations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('shipping_company_id')->constrained('shipping_companies')->cascadeOnDelete();
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->foreignId('countery_id')->nullable()->constrained('countries')->nullOnDelete();
                $table->decimal('shipping_price', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('shipping_types')) {
            Schema::create('shipping_types', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('shipping_types_and_price')) {
            Schema::create('shipping_types_and_price', function (Blueprint $table) {
                $table->id();
                $table->boolean('add_pickup_from_store')->default(false);
                $table->boolean('add_wight_price')->default(false);
                $table->boolean('add_normal_price')->default(false);
                $table->boolean('add_price_based_on_city')->default(false);
                $table->decimal('weight_price', 10, 2)->default(0);
                $table->decimal('normal_shipping_price', 10, 2)->default(0);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_types_and_price');
        Schema::dropIfExists('shipping_types');
        Schema::dropIfExists('shipping_locations');
        Schema::dropIfExists('shipping_companies');
    }
};
