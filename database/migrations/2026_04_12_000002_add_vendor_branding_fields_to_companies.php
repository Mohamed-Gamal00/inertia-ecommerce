<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Branding fields
            $table->string('cover_image')->nullable()->after('image');
            $table->string('banner_color', 7)->default('#3490dc')->after('cover_image');
            $table->string('store_slug')->unique()->nullable()->after('name_en');
            $table->json('social_links')->nullable()->after('description');
            
            // Policies
            $table->text('return_policy')->nullable()->after('social_links');
            $table->text('shipping_policy')->nullable()->after('return_policy');
            
            // Commission & financial
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('shipping_policy')->comment('Platform commission percentage');
            
            // Stats (computed/cached)
            $table->decimal('rating', 3, 2)->default(0)->after('commission_rate');
            $table->unsignedInteger('total_sales')->default(0)->after('rating');
            $table->unsignedInteger('total_products')->default(0)->after('total_sales');
            
            // Business info
            $table->string('business_license')->nullable()->after('total_products');
            $table->string('tax_number')->nullable()->after('business_license');
            $table->string('bank_account')->nullable()->after('tax_number');
            $table->string('bank_name')->nullable()->after('bank_account');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'cover_image', 'banner_color', 'store_slug', 'social_links',
                'return_policy', 'shipping_policy', 'commission_rate',
                'rating', 'total_sales', 'total_products',
                'business_license', 'tax_number', 'bank_account', 'bank_name'
            ]);
        });
    }
};
