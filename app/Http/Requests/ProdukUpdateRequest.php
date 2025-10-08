<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukUpdateRequest extends FormRequest
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
            'nama_produk' => ['required', Rule::unique('produks', 'nama_produk')->ignore($this->produk),  'max:255', 'string'],
            'kategori_id' => ['required','exists:kategoris,id'],
            'deskripsi_produk' => ['nullable'],
        ];
    }
}
