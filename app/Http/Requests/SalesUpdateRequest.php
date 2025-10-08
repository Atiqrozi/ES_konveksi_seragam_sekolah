<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SalesUpdateRequest extends FormRequest
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
            'nama' => [
                'required', 
                Rule::unique('users', 'nama')->ignore($this->sale),
                'max:255', 
                'string'
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->sale),
                'email',
            ],
            'password' => ['nullable'],
            'alamat' => ['required'],
            'no_telepon' => ['required'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'tanggal_lahir' => ['required', 'date'],
            'roles' => 'array',
            'tagihan' => ['nullable'],
        ];
    }
}
