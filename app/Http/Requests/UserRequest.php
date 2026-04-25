<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'nik' => 'nullable|string|size:16|unique:users,nik,'.$userId,
            'kta_number' => 'nullable|string|unique:users,kta_number,'.$userId,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,'.$userId,
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20',

            // Biodata
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'religion' => 'nullable|in:islam,christian,catholic,hindu,buddhist,confucian',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'education' => 'nullable|in:high_school,associate_degree,bachelors_degree,masters_degree,doctorate',
            'profession' => 'nullable|string|max:255',

            // Address
            'address' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'province_id' => 'nullable|string',
            'regency_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'village_id' => 'nullable|string',
            'postal_code' => 'nullable|string|max:5',

            // Files & Status
            'photo_url' => 'nullable|string',
            'ktp_photo_url' => 'nullable|string',
            'role' => 'nullable|in:admin,board_member,member,sympathizer',
            'status' => 'nullable|boolean',
        ];
    }
}
