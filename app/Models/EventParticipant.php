<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'event_id', 'name', 'nik', 'email', 'whatsapp_number',
    'province_id', 'regency_id', 'district_id', 'village_id', 'message',
])]
class EventParticipant extends Model
{
    /**
     * Get the event that the participant is registered to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
