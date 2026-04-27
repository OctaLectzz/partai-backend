<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'province_id' => 'required|string',
            'regency_id' => 'required|string',
            'district_id' => 'required|string',
            'village_id' => 'required|string',
            'message' => 'nullable|string',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function ($validator) {
                $event = $this->route('event');
                if (! $event) {
                    return;
                }

                // Check participant quota
                if ($event->target_participants && $event->participants()->count() >= $event->target_participants) {
                    $validator->errors()->add('event', 'Sorry, the participant quota for this event is full.');
                }

                // Check if NIK is already registered for this event
                $nik = $this->input('nik');
                if ($nik && $event->participants()->where('nik', $nik)->exists()) {
                    $validator->errors()->add('nik', 'This NIK is already registered for this event.');
                }
            },
        ];
    }
}
