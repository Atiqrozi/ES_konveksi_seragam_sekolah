<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesananStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'global_tipe_harga' => 'required|in:harga_produk_1,harga_produk_2,harga_produk_3,harga_produk_4',
            'produk_id.*' => 'required|exists:produks,id',
            'harga.*' => 'required',
            'jumlah_pesanan.*' => 'required|integer|min:1',
            'ukuran.*' => 'required',
        ];
    }
}
