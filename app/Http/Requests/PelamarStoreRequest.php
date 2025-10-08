<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelamarStoreRequest extends FormRequest
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
            'nama' => ['required', 'unique:pelamars,nama', 'max:255', 'string'],
            'email' => ['required', 'unique:pelamars,email', 'email'],
            'alamat' => ['required'],
            'no_telepon' => ['required'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'tanggal_lahir' => ['required', 'date'],
            'no_telepon' => ['required'],
            'pendidikan_terakhir' => ['required'],
            'pengalaman' => ['nullable'],
            'status' => ['required'],
            'tentang_diri' => ['nullable'],
            'posisi_id' => ['required','exists:posisi_lowongans,id'],
        ];
    }
}
