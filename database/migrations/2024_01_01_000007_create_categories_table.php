<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('main_categories')) {
            Schema::create('main_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')->nullable()->constrained('main_categories')->nullOnDelete();
                $table->string('name');
                $table->string('name_en')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('main_category_settings')) {
            Schema::create('main_category_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('main_category_main_category_setting')) {
            Schema::create('main_category_main_category_setting', function (Blueprint $table) {
                $table->id();
                $table->foreignId('main_category_id')->constrained('main_categories')->cascadeOnDelete();
                $table->foreignId('category_setting_id')->constrained('main_category_settings')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('sub_settings')) {
            Schema::create('sub_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('main_category_setting_id')->constrained('main_category_settings')->cascadeOnDelete();
                $table->timestamps();
            });
        }

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

        if (!Schema::hasTable('choices')) {
            Schema::create('choices', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_en')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('choices')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('category_choices')) {
            Schema::create('category_choices', function (Blueprint $table) {
                $table->foreignId('main_category_id')->constrained('main_categories')->cascadeOnDelete();
                $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
                $table->primary(['main_category_id', 'choice_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('category_choices');
        Schema::dropIfExists('choices');
        Schema::dropIfExists('sec_sub_categories');
        Schema::dropIfExists('first_sub_categories');
        Schema::dropIfExists('sub_settings');
        Schema::dropIfExists('main_category_main_category_setting');
        Schema::dropIfExists('main_category_settings');
        Schema::dropIfExists('main_categories');
    }
};
