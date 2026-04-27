<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'event_id', 'name', 'nik', 'email', 'whatsapp_number',
    'province_id', 'regency_id', 'district_id', 'village_id',
    'message', 'status',
])]
class EventParticipant extends Model
{
    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted(): void
    {
        static::creating(function (EventParticipant $participant) {
            do {
                $code = 'EVT-'.strtoupper(Str::random(8));
            } while (static::where('participant_code', $code)->exists());

            $participant->participant_code = $code;
        });
    }

    /**
     * Get the event that the participant is registered to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
