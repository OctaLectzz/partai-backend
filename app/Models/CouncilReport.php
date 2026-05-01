<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'user_id', 'title', 'description', 'report_type',
    'activity_date', 'start_time', 'end_time', 'location',
    'agenda', 'result', 'recommendation', 'participants_count',
    'status', 'rejection_note',
])]
class CouncilReport extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    /**
     * Get the council member (user) that owns the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the media files for the report.
     */
    public function media(): HasMany
    {
        return $this->hasMany(CouncilReportMedia::class)->orderBy('sort_order');
    }
}
