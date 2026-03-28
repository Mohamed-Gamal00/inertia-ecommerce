<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name_ar');
                $table->string('name_en');
                $table->string('code')->nullable();
                $table->string('phone_code')->nullable();
                $table->enum('status', ['used', 'not_used'])->default('not_used');
            });
        }

        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name_ar');
                $table->string('name_en')->nullable();
                $table->string('code')->nullable();
                $table->enum('status', ['used', 'not_used'])->default('not_used');
                $table->decimal('shipping_price', 10, 2)->default(0);
                $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('countries');
    }
};
