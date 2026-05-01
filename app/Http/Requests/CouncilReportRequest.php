<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CouncilReportRequest extends FormRequest
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
        $isUpdate = $this->route('council_report') !== null;

        return [
            // Activity Information
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'report_type' => 'required|in:meeting,visit,socialization,supervision,aspiration,other',
            'activity_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'required|string|max:255',

            // Report Details
            'agenda' => 'nullable|string',
            'result' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'participants_count' => 'nullable|integer|min:0',

            // Status
            'status' => 'nullable|in:draft,submitted,approved,rejected',
            'rejection_note' => 'nullable|string',

            // Media Files
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,heic,mp4,mov,avi,pdf,doc,docx|max:51200',
            'media_captions' => 'nullable|array',
            'media_captions.*' => 'nullable|string|max:255',
        ];
    }
}
