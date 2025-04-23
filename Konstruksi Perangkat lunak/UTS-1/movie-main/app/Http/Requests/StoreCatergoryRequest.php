<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCatergoryRequest extends FormRequest
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
     *
     * 
     */
    public function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|max:10',
            'keterangan' => 'required|string|max:255',
        ];
    }
}
