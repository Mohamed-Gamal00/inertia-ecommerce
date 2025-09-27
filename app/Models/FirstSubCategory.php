<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FirstSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function secSubCategories(): HasMany
    {
        return $this->hasMany(SecSubCategory::class);
    }
}
