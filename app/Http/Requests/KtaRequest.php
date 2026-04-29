<?php

namespace App\Http\Requests;

use App\Models\Kta;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KtaRequest extends FormRequest
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
        $kta = $this->route('kta');
        $ktaId = $kta instanceof Kta ? $kta->id : $kta;

        return [
            'nik' => 'required|string|size:16|unique:ktas,nik,'.$ktaId,
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'position' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'province_id' => 'required|string',
            'regency_id' => 'required|string',
            'district_id' => 'required|string',
            'village_id' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'is_council' => 'nullable|boolean',
            'photo' => $ktaId ? 'nullable' : 'required',
        ];
    }
}
