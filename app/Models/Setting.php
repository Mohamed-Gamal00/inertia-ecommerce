<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name',
        'website_name_en',
        'subscription_title',
        'phone',
        'image',
        'facebook',
        'twitter',
        'description',
        'address',
        'email',
        'google_play',
        'apple_store',
        'logo',
        'instagram',
        'phone_number',
        'snap',
        'tiktok',
        'tax_number',
        'value_added_tax',
        'publishable_key',
        'secret_key',
        'sms_api_key',
        'sms_user_name',
        'sms_sender',

        // SEO
        'seo_meta_title',
        'seo_meta_description',
        'seo_meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'google_analytics_id',
        'google_tag_manager_id',
        'google_site_verification',
        'canonical_url',
        'robots_index',
    ];

    /**
     * Override the fill method to only fill attributes that have corresponding columns
     */
    public function fill(array $attributes)
    {
        // Get actual table columns
        $columns = Schema::getColumnListing($this->getTable());
        
        // Filter attributes to only include existing columns
        $filteredAttributes = array_filter($attributes, function($key) use ($columns) {
            return in_array($key, $columns);
        }, ARRAY_FILTER_USE_KEY);
        
        return parent::fill($filteredAttributes);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/logo.jpg');
        }
        return asset('storage/' . $this->image);
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->website_name_en)) {
            return $this->website_name;
        }
        return $this->website_name_en;
    }
}
