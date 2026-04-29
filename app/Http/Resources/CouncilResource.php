<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouncilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nik' => $this->nik,
            'kta_number' => $this->kta_number,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'gender' => $this->gender,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'education' => $this->education,
            'profession' => $this->profession,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'province_id' => (string) $this->province_id,
            'province' => $this->whenLoaded('province', fn () => [
                'id' => (string) $this->province->id,
                'name' => $this->province->name,
            ]),
            'regency_id' => (string) $this->regency_id,
            'regency' => $this->whenLoaded('regency', fn () => [
                'id' => (string) $this->regency->id,
                'name' => $this->regency->name,
            ]),
            'district_id' => (string) $this->district_id,
            'district' => $this->whenLoaded('district', fn () => [
                'id' => (string) $this->district->id,
                'name' => $this->district->name,
            ]),
            'village_id' => (string) $this->village_id,
            'village' => $this->whenLoaded('village', fn () => [
                'id' => (string) $this->village->id,
                'name' => $this->village->name,
            ]),
            'postal_code' => $this->postal_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'photo' => $this->photo ? asset('storage/councils/photos/'.$this->photo) : null,
            'ktp_photo' => $this->ktp_photo ? asset('storage/councils/ktp_photos/'.$this->ktp_photo) : null,
            'role' => $this->role,
            'status' => (bool) $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
