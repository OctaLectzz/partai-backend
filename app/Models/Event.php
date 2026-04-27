<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'category_id', 'name', 'slug', 'description', 'organizer',
    'target_participants', 'start_date', 'start_time', 'end_date', 'end_time',
    'location', 'status',
])]
class Event extends Model
{
    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted(): void
    {
        static::saving(function (Event $event) {
            if (empty($event->slug) || $event->isDirty('name')) {
                $baseSlug = Str::slug($event->name);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $event->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$count++;
                }

                $event->slug = $slug;
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

    /**
     * Get the category that owns the event.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the participants for the event.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}
