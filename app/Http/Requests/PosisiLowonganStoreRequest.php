<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosisiLowonganStoreRequest extends FormRequest
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
            'nama_posisi' => ['required', 'unique:posisi_lowongans,nama_posisi', 'max:255', 'string'],
            'deskripsi_posisi' => ['required'],
        ];
    }
}
