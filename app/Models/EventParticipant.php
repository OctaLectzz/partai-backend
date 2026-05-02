<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

#[Fillable([
    'event_id', 'massa_id', 'message', 'status', 'qr_code', 'attended_at',
])]
class EventParticipant extends Model
{
    /**
     * The relations to eager load on every query.
     *
     * @var array<int, string>
     */
    protected $with = ['massa'];

    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted(): void
    {
        static::creating(function (EventParticipant $participant) {
            do {
                $code = 'TKT'.now()->format('YmdHis').strtoupper(Str::random(8));
            } while (static::where('participant_code', $code)->exists());

            $participant->participant_code = $code;
            $participant->qr_code = $code.'.png';

            // Generate QR Code
            Storage::disk('public')->put('qrcodes/'.$code.'.png', QrCode::format('png')->size(300)->generate($code));
        });
    }

    /**
     * Get the event that the participant is registered to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the massa for this participant.
     */
    public function massa(): BelongsTo
    {
        return $this->belongsTo(Massa::class);
    }
}
