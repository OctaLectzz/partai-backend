<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouncilReportResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'photo' => $this->user->photo ? asset('storage/councils/photos/'.$this->user->photo) : null,
            ]),
            'title' => $this->title,
            'description' => $this->description,
            'report_type' => $this->report_type,
            'activity_date' => $this->activity_date?->format('Y-m-d'),
            'start_time' => $this->start_time ? date('H:i', strtotime($this->start_time)) : null,
            'end_time' => $this->end_time ? date('H:i', strtotime($this->end_time)) : null,
            'location' => $this->location,
            'agenda' => $this->agenda,
            'result' => $this->result,
            'recommendation' => $this->recommendation,
            'participants_count' => $this->participants_count,
            'status' => $this->status,
            'rejection_note' => $this->rejection_note,
            'media' => CouncilReportMediaResource::collection($this->whenLoaded('media')),
            'media_count' => $this->whenCounted('media'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
