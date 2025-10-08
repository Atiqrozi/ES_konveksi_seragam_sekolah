<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukStoreRequest extends FormRequest
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
            'nama_produk' => ['required', 'unique:produks,nama_produk', 'max:255', 'string'],
            'kategori_id' => ['required','exists:kategoris,id'],
            'deskripsi_produk' => ['nullable'],
        ];
    }
}
