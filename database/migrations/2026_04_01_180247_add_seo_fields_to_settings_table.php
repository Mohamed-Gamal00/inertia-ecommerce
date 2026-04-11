<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Global SEO
            $table->string('seo_meta_title')->nullable()->after('description');
            $table->text('seo_meta_description')->nullable()->after('seo_meta_title');
            $table->string('seo_meta_keywords')->nullable()->after('seo_meta_description');

            // Open Graph (Facebook / WhatsApp / LinkedIn)
            $table->string('og_title')->nullable()->after('seo_meta_keywords');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');

            // Twitter Card
            $table->string('twitter_card')->nullable()->default('summary_large_image')->after('og_image');
            $table->string('twitter_title')->nullable()->after('twitter_card');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');

            // Technical SEO
            $table->string('google_analytics_id')->nullable()->after('twitter_image');
            $table->string('google_tag_manager_id')->nullable()->after('google_analytics_id');
            $table->string('google_site_verification')->nullable()->after('google_tag_manager_id');
            $table->string('canonical_url')->nullable()->after('google_site_verification');
            $table->enum('robots_index', ['index,follow', 'noindex,nofollow', 'index,nofollow', 'noindex,follow'])
                  ->default('index,follow')->after('canonical_url');
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
