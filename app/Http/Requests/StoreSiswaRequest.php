<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
            'nis' => 'required|unique:siswa,nis|numeric',
            'nama' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'confirm'=>'required|same:password',
            'jk' => 'required'
        ];
    }
}
