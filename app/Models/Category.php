<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'description'])]
class Category extends Model
{
    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug) || $category->isDirty('name')) {
                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $category->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$count++;
                }

                $category->slug = $slug;
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
