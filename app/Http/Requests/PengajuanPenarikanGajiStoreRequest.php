<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanPenarikanGajiStoreRequest extends FormRequest
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
            'pegawai_id' => 'required|exists:users,id',
            'gaji_yang_diajukan' => 'required',
            'status' => 'required',
            'mulai_tanggal' => ['required', 'date'],
            'akhir_tanggal' => ['required', 'date'],
            'gaji_diberikan' => ['required', 'date'],
        ];
    }
}
