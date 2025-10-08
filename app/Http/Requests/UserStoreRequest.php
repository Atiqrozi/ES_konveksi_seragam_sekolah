<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'nama' => ['required', 'unique:users,nama', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'alamat' => ['required'],
            'no_telepon' => ['required'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'tanggal_lahir' => ['required', 'date'],
            'roles' => 'array',
            'tagihan' => ['nullable']
        ];
    }
}
