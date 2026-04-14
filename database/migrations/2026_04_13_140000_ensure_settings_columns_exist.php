<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('settings', 'website_name')) {
                $table->string('website_name')->nullable();
            }
            if (!Schema::hasColumn('settings', 'website_name_en')) {
                $table->string('website_name_en')->nullable();
            }
            if (!Schema::hasColumn('settings', 'subscription_title')) {
                $table->string('subscription_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('settings', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('settings', 'logo')) {
                $table->string('logo')->nullable();
            }
            if (!Schema::hasColumn('settings', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('settings', 'twitter')) {
                $table->string('twitter')->nullable();
            }
            if (!Schema::hasColumn('settings', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('settings', 'snap')) {
                $table->string('snap')->nullable();
            }
            if (!Schema::hasColumn('settings', 'tiktok')) {
                $table->string('tiktok')->nullable();
            }
            if (!Schema::hasColumn('settings', 'google_play')) {
                $table->string('google_play')->nullable();
            }
            if (!Schema::hasColumn('settings', 'apple_store')) {
                $table->string('apple_store')->nullable();
            }
            if (!Schema::hasColumn('settings', 'tax_number')) {
                $table->string('tax_number')->nullable();
            }
            if (!Schema::hasColumn('settings', 'value_added_tax')) {
                $table->decimal('value_added_tax', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('settings', 'publishable_key')) {
                $table->string('publishable_key')->nullable();
            }
            if (!Schema::hasColumn('settings', 'secret_key')) {
                $table->string('secret_key')->nullable();
            }
            if (!Schema::hasColumn('settings', 'sms_api_key')) {
                $table->string('sms_api_key')->nullable();
            }
            if (!Schema::hasColumn('settings', 'sms_user_name')) {
                $table->string('sms_user_name')->nullable();
            }
            if (!Schema::hasColumn('settings', 'sms_sender')) {
                $table->string('sms_sender')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $columns = [
                'website_name', 'website_name_en', 'subscription_title', 'phone',
                'image', 'logo', 'facebook', 'twitter', 'instagram', 'snap',
                'tiktok', 'google_play', 'apple_store', 'tax_number',
                'value_added_tax', 'publishable_key', 'secret_key',
                'sms_api_key', 'sms_user_name', 'sms_sender'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};