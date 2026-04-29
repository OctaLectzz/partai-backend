<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'nik', 'kta_number', 'name', 'phone_number', 'place_of_birth', 'date_of_birth',
    'gender', 'position', 'address', 'rt', 'rw',
    'province_id', 'regency_id', 'district_id', 'village_id',
    'postal_code', 'photo', 'is_council',
])]
class Kta extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::creating(function ($kta) {
            if (! $kta->kta_number) {
                $date = now()->format('Ymd');
                $count = static::count() + 1;
                $kta->kta_number = $date.str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });

        static::saved(function ($kta) {
            // If it's a council member KTA, update the kta_number in users table
            if ($kta->is_council) {
                User::where('nik', $kta->nik)->update([
                    'kta_number' => $kta->kta_number,
                ]);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    // Photo
    public static function uploadPhoto(UploadedFile $photo, string $nik): string
    {
        $filename = time().'-'.$nik.'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('ktas', $filename, 'public');

        return $filename;
    }

    public function deletePhoto(): void
    {
        if ($this->photo && Storage::disk('public')->exists('ktas/'.$this->photo)) {
            Storage::disk('public')->delete('ktas/'.$this->photo);
        }
    }

    /**
     * Get the province that the KTA belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the regency that the KTA belongs to.
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the district that the KTA belongs to.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the village that the KTA belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
