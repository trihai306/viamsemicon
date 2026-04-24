<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasSlug, HasTranslations;

    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'price', 'price_text', 'image', 'gallery', 'specifications',
        'is_featured', 'is_active', 'sort_order', 'seo_title', 'seo_description',
    ];

    public array $translatable = ['name', 'short_description', 'description', 'seo_title', 'seo_description'];

    protected $casts = [
        'gallery' => 'array',
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn ($model) => $model->getTranslation('name', 'vi'))
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDisplayPriceAttribute(): string
    {
        return $this->price ?: ($this->price_text ?: 'Liên hệ');
    }
}
