<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventParticipantResource extends JsonResource
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
            'event_id' => $this->event_id,
            'massa_id' => $this->massa_id,
            'massa' => new MassaResource($this->whenLoaded('massa')),
            'participant_code' => $this->participant_code,
            'qr_code' => $this->qr_code ? asset('storage/qrcodes/'.$this->qr_code) : null,
            'message' => $this->message,
            'status' => $this->status,
            'attended_at' => $this->attended_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
