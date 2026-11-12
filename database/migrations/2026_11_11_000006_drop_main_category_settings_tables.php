<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('products', 'main_category_setting_id')) {
            Schema::table('products', function (Blueprint $table) {
                try {
                    $table->dropForeign(['main_category_setting_id']);
                } catch (\Throwable) {
                }

                $table->dropColumn('main_category_setting_id');
            });
        }

        if (Schema::hasColumn('sub_settings', 'main_category_setting_id')) {
            Schema::table('sub_settings', function (Blueprint $table) {
                try {
                    $table->dropForeign(['main_category_setting_id']);
                } catch (\Throwable) {
                }

                $table->dropColumn('main_category_setting_id');
            });
        }

        Schema::dropIfExists('main_category_main_category_setting');
        Schema::dropIfExists('main_category_settings');
    }

    public function down(): void
    {
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

        if (!Schema::hasColumn('products', 'main_category_setting_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('main_category_setting_id')->nullable()->constrained('main_category_settings')->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('sub_settings', 'main_category_setting_id')) {
            Schema::table('sub_settings', function (Blueprint $table) {
                $table->foreignId('main_category_setting_id')->nullable()->constrained('main_category_settings')->nullOnDelete();
            });
        }
    }
};
