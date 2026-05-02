<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MassaResource extends JsonResource
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
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'phone_number' => $this->phone_number,
            'email' => $this->email,
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
            'profession' => $this->profession,
            'photo' => $this->photo ? asset('storage/massas/'.$this->photo) : null,
            'notes' => $this->notes,
            'status' => $this->status,
            'events' => $this->whenLoaded('events', fn () => $this->events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->name,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'pivot' => [
                        'participant_code' => $event->pivot->participant_code,
                        'qr_code' => $event->pivot->qr_code ? asset('storage/'.$event->pivot->qr_code) : null,
                        'status' => $event->pivot->status,
                        'attended_at' => $event->pivot->attended_at,
                        'message' => $event->pivot->message,
                    ],
                ];
            })),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
