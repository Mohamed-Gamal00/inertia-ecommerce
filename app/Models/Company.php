<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'vendor';

    protected $fillable = [
        'name', 'name_en', 'image', 'cover_image',
        'email', 'password', 'phone', 'description',
        'status', 'is_vendor', 'store_slug', 'banner_color',
        'social_links', 'return_policy', 'shipping_policy',
        'commission_rate', 'rating', 'total_sales', 'total_products',
        'business_license', 'tax_number', 'bank_account', 'bank_name',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'is_vendor' => 'boolean',
        'social_links' => 'array',
        'commission_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'total_sales' => 'integer',
        'total_products' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) return asset('assets/images/no-image.jpg');
        return asset('storage/' . $this->image);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, fn($b, $v) =>
            $b->where('companies.name', 'LIKE', '%' . $v . '%')
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id', 'id');
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        return ($locale === 'ar' || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) return null;
        return asset('storage/' . $this->cover_image);
    }

    public function payouts()
    {
        return $this->hasMany(VendorPayout::class, 'company_id');
    }

    public function earnings()
    {
        return $this->hasMany(VendorEarning::class, 'company_id');
    }

    public function reviews()
    {
        return $this->hasMany(VendorReview::class, 'company_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(VendorReview::class, 'company_id')->where('status', 'approved');
    }

    public function updateRating()
    {
        $avgRating = $this->approvedReviews()->avg('rating');
        $this->update(['rating' => $avgRating ?? 0]);
    }

    public function updateStats()
    {
        $this->update([
            'total_products' => $this->products()->count(),
            'total_sales' => $this->earnings()->where('status', 'paid')->sum('vendor_amount'),
        ]);
    }
}
