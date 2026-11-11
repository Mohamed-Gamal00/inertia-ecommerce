<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('order_item_choices');
    }

    public function down(): void
    {
        if (!Schema::hasTable('order_item_choices')) {
            Schema::create('order_item_choices', function (Blueprint $table) {
                $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }
    }
};
