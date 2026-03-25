<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('header_banners')) {
            Schema::create('header_banners', function (Blueprint $table) {
                $table->id();
                $table->string('header_image')->nullable();
                $table->string('header_image_en')->nullable();
                $table->string('image_link')->nullable();
            });
        }

        if (!Schema::hasTable('header_texts')) {
            Schema::create('header_texts', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('advertisements')) {
            Schema::create('advertisements', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('title_en')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('designs')) {
            Schema::create('designs', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('page_name')->nullable();
                $table->string('image')->nullable();
                $table->string('image_en')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('designs_extra')) {
            Schema::create('designs_extra', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('image')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('content')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('common_questions')) {
            Schema::create('common_questions', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contact_us')) {
            Schema::create('contact_us', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('store_featuers')) {
            Schema::create('store_featuers', function (Blueprint $table) {
                $table->id();
                $table->string('image')->nullable();
                $table->string('title')->nullable();
                $table->string('title_en')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('store_featuers');
        Schema::dropIfExists('contact_us');
        Schema::dropIfExists('common_questions');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('designs_extra');
        Schema::dropIfExists('designs');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('header_texts');
        Schema::dropIfExists('header_banners');
    }
};
