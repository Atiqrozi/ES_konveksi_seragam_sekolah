<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PekerjaanUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'nama_pekerjaan' => ['required', Rule::unique('pekerjaans', 'nama_pekerjaan')->ignore($this->pekerjaan), 'max:255', 'string'],
            'gaji_per_pekerjaan' => ['required'],
            'deskripsi_pekerjaan' => ['nullable'],
        ];
    }
}
