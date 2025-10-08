<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Kriteria;

class PelamarUpdateRequest extends FormRequest
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
        $rules = [];

        $kriteria = Kriteria::all();

        foreach ($kriteria as $kriterium) {
            $columnName = strtolower(str_replace(' ', '_', $kriterium->nama));
            $rules[$columnName] = ['required', 'integer', 'min:1', 'max:5'];
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        $kriteria = Kriteria::all();

        foreach ($kriteria as $kriterium) {
            $columnName = strtolower(str_replace(' ', '_', $kriterium->nama));
            $messages["$columnName.required"] = "Pilih salah satu tingkat {$kriterium->nama}.";
        }

        return $messages;
    }
}
