<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JenisPengeluaranUpdateRequest extends FormRequest
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
            'nama_pengeluaran' => ['required', Rule::unique('jenis_pengeluarans', 'nama_pengeluaran')->ignore($this->jenis_pengeluaran),  'max:255', 'string'],
            'keterangan' => ['nullable'],
        ];
    }
}
