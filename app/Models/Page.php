<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasSlug, HasTranslations;

    protected $fillable = [
        'title', 'slug', 'content', 'template', 'is_active',
        'seo_title', 'seo_description',
    ];

    public array $translatable = ['title', 'content', 'seo_title', 'seo_description'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn ($model) => $model->getTranslation('title', 'vi'))
            ->saveSlugsTo('slug');
    }
}
