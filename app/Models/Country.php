<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'status',
        'phone_code'
    ];
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public $timestamps = false;
    
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->name_en)) {
            return $this->name_ar;
        }
        return $this->name_en;
    }
}
