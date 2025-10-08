<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KegiatanUpdateRequest extends FormRequest
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
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'user_id' => 'required|exists:users,id',
            'status_kegiatan' => 'required',
            'jumlah_kegiatan' => 'integer|min:1',
            'tanggal_selesai' => 'nullable',
            'catatan' => 'nullable',
        ];
    }
}
