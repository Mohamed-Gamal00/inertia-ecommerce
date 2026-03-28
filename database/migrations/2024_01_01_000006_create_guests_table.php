<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('guests')) {
            Schema::create('guests', function (Blueprint $table) {
                $table->id();
                $table->string('cookie_id')->unique();
                $table->string('first_name')->nullable();
                $table->string('family_name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('address')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
