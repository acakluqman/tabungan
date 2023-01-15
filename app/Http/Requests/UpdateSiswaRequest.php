<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nis' => 'required|numeric|unique:siswa,nis,' . request()->id_siswa . ',id_siswa',
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . request()->id_user . ',id_user',
            'jk' => 'required'
        ];
    }
}
