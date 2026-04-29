<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MassaRequest extends FormRequest
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
        $massaId = $this->route('massa') ? $this->route('massa')->id : null;

        return [
            'nik' => 'required|string|size:16|unique:massas,nik,'.$massaId,
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',

            // Address
            'address' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'province_id' => 'required|string',
            'regency_id' => 'required|string',
            'district_id' => 'required|string',
            'village_id' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Additional
            'profession' => 'nullable|string|max:255',
            'photo' => $massaId ? 'nullable' : 'nullable|image|mimes:jpg,jpeg,png,webp,heic|max:2056',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
