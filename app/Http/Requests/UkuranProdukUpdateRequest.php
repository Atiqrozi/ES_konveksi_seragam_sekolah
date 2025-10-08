<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UkuranProdukUpdateRequest extends FormRequest
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
            'produk_id' => ['required','exists:produks,id'],
            'ukuran' => ['required'],
            'stok' => ['required', 'integer'],
            'harga_produk_1' => ['required', 'integer'],
            'harga_produk_2' => ['required', 'integer'],
            'harga_produk_3' => ['required', 'integer'],
            'harga_produk_4' => ['required', 'integer'],
        ];
    }
}
