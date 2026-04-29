<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CouncilRequest extends FormRequest
{
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
        $council = $this->route('council');
        $userId = $council instanceof User ? $council->id : $council;

        return [
            'nik' => 'required|string|size:16|unique:users,nik,'.$userId,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'phone_number' => 'required|string|max:20',

            // Biodata
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'religion' => 'required|in:islam,christian,catholic,hindu,buddhist,confucian',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'education' => 'required|in:high_school,associate_degree,bachelors_degree,masters_degree,doctorate',
            'profession' => 'required|string|max:255',

            // Address
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'province_id' => 'required|string',
            'regency_id' => 'required|string',
            'district_id' => 'required|string',
            'village_id' => 'required|string',
            'postal_code' => 'required|string|max:5',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Files & Status
            'photo' => $userId ? 'nullable' : 'nullable|image|mimes:jpg,jpeg,png,webp,heic|max:2056',
            'ktp_photo' => $userId ? 'nullable' : 'nullable|image|mimes:jpg,jpeg,png,webp,heic|max:2056',
            'status' => 'nullable|boolean',
        ];
    }
}
