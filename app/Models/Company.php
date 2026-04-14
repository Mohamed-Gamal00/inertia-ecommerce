<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'vendor';

    protected $fillable = [
        'name', 'name_en', 'image',
        'email', 'password', 'phone', 'description',
        'status', 'is_vendor',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed', 'is_vendor' => 'boolean'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) return asset('assets/images/no-image.jpg');
        return Storage::url($this->image);
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
}
