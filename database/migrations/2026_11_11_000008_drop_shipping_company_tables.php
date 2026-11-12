<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('shipping_locations');
        Schema::dropIfExists('shipping_companies');
    }

    public function down(): void
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
    }
};
