<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('cart_item_choices');
    }

    public function down(): void
    {
        if (!Schema::hasTable('cart_item_choices')) {
            Schema::create('cart_item_choices', function (Blueprint $table) {
                $table->uuid('cart_id');
                $table->foreign('cart_id')->references('id')->on('carts')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }
    }
};
