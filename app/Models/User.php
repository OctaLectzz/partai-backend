<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'nik', 'kta_number', 'name', 'email', 'password', 'phone_number',
    'place_of_birth', 'date_of_birth', 'gender', 'religion', 'marital_status',
    'education', 'profession', 'address', 'rt', 'rw', 'province_id',
    'regency_id', 'district_id', 'village_id', 'postal_code',
    'latitude', 'longitude',
    'photo', 'ktp_photo', 'role', 'type', 'status',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'status' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    // Photo
    public static function uploadPhoto(UploadedFile $photo, string $nik): string
    {
        $filename = time().'-'.$nik.'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('councils/photos', $filename, 'public');

        return $filename;
    }

    public function deletePhoto(): void
    {
        if ($this->photo && Storage::disk('public')->exists('councils/photos/'.$this->photo)) {
            Storage::disk('public')->delete('councils/photos/'.$this->photo);
        }
    }

    // KTP Photo
    public static function uploadKtpPhoto(UploadedFile $photo, string $nik): string
    {
        $filename = time().'-'.$nik.'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('councils/ktp_photos', $filename, 'public');

        return $filename;
    }

    public function deleteKtpPhoto(): void
    {
        if ($this->ktp_photo && Storage::disk('public')->exists('councils/ktp_photos/'.$this->ktp_photo)) {
            Storage::disk('public')->delete('councils/ktp_photos/'.$this->ktp_photo);
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

    /**
     * Get the council reports for the user.
     */
    public function councilReports(): HasMany
    {
        return $this->hasMany(CouncilReport::class);
    }
}
