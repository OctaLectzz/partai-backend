<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        $eventId = $this->route('event') ? $this->route('event')->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:events,name,'.$eventId,
            'description' => 'required|string',
            'organizer' => 'required|string|max:255',
            'target_participants' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'status' => 'required|in:draft,published,completed,cancelled',
        ];
    }
}
