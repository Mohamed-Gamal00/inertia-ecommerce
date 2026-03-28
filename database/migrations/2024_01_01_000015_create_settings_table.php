<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('website_name')->nullable();
                $table->string('website_name_en')->nullable();
                $table->string('subscription_title')->nullable();
                $table->string('phone')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('image')->nullable();
                $table->string('logo')->nullable();
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->text('description')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();
                $table->string('snap')->nullable();
                $table->string('tiktok')->nullable();
                $table->string('google_play')->nullable();
                $table->string('apple_store')->nullable();
                $table->string('tax_number')->nullable();
                $table->decimal('value_added_tax', 5, 2)->default(0);
                $table->string('publishable_key')->nullable();
                $table->string('secret_key')->nullable();
                $table->string('sms_api_key')->nullable();
                $table->string('sms_user_name')->nullable();
                $table->string('sms_sender')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('send_news_to_users')) {
            Schema::create('send_news_to_users', function (Blueprint $table) {
                $table->id();
                $table->string('subscription_email')->unique();
            });
        }

        if (!Schema::hasTable('bulk_orders')) {
            Schema::create('bulk_orders', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone');
                $table->string('company_name')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('representatives_orders')) {
            Schema::create('representatives_orders', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->text('comment')->nullable();
                $table->unsignedTinyInteger('rate')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('representatives_orders');
        Schema::dropIfExists('bulk_orders');
        Schema::dropIfExists('send_news_to_users');
        Schema::dropIfExists('settings');
    }
};
