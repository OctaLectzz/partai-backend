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
    'nik', 'full_name', 'gender', 'place_of_birth', 'date_of_birth',
    'phone_number', 'email', 'address', 'rt', 'rw',
    'province_id', 'regency_id', 'district_id', 'village_id',
    'postal_code', 'latitude', 'longitude',
    'profession', 'photo', 'notes', 'status',
])]
class Massa extends Model
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
            'date_of_birth' => 'date',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    // Photo
    public static function uploadPhoto(UploadedFile $photo, string $nik): string
    {
        $filename = time().'-'.$nik.'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('massas', $filename, 'public');

        return $filename;
    }

    public function deletePhoto(): void
    {
        if ($this->photo && Storage::disk('public')->exists('massas/'.$this->photo)) {
            Storage::disk('public')->delete('massas/'.$this->photo);
        }
    }

    /**
     * Get the province that the massa belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the regency that the massa belongs to.
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the district that the massa belongs to.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the village that the massa belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
