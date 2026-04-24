<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasSlug, HasTranslations;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'image',
        'category_type', 'is_published', 'published_at',
        'seo_title', 'seo_description',
    ];

    public array $translatable = ['title', 'content', 'excerpt', 'seo_title', 'seo_description'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn ($model) => $model->getTranslation('title', 'vi'))
            ->saveSlugsTo('slug');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('published_at', '<=', now());
    }

    public function scopeNews($query)
    {
        return $query->where('category_type', 'tin-tuc');
    }

    public function scopeRecruitment($query)
    {
        return $query->where('category_type', 'tuyen-dung');
    }
}
