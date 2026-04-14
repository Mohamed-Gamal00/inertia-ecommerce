<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Check if columns don't already exist before adding them
            if (!Schema::hasColumn('settings', 'seo_meta_title')) {
                // Global SEO
                $table->string('seo_meta_title')->nullable();
                $table->text('seo_meta_description')->nullable();
                $table->string('seo_meta_keywords')->nullable();

                // Open Graph (Facebook / WhatsApp / LinkedIn)
                $table->string('og_title')->nullable();
                $table->text('og_description')->nullable();
                $table->string('og_image')->nullable();

                // Twitter Card
                $table->string('twitter_card')->nullable()->default('summary_large_image');
                $table->string('twitter_title')->nullable();
                $table->text('twitter_description')->nullable();
                $table->string('twitter_image')->nullable();

                // Technical SEO
                $table->string('google_analytics_id')->nullable();
                $table->string('google_tag_manager_id')->nullable();
                $table->string('google_site_verification')->nullable();
                $table->string('canonical_url')->nullable();
                $table->enum('robots_index', ['index,follow', 'noindex,nofollow', 'index,nofollow', 'noindex,follow'])
                      ->default('index,follow');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_meta_title', 'seo_meta_description', 'seo_meta_keywords',
                'og_title', 'og_description', 'og_image',
                'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
                'google_analytics_id', 'google_tag_manager_id', 'google_site_verification',
                'canonical_url', 'robots_index',
            ]);
        });
    }
};
