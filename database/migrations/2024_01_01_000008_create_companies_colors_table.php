<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_en')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('colors')) {
            Schema::create('colors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('color_code');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('colors');
        Schema::dropIfExists('companies');
    }
};
