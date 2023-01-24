<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreKelasRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'thn' => 'required',
            'nama' => [
                'required',
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query
                        ->where('thn_ajaran', $request->thn)
                        ->where('nama', $request->nama);
                }),
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'thn.required' => 'Tahun ajaran harus diisi!',
            'nama.required' => 'Nama kelas harus diisi!',
            'nama.unique' => 'Nama kelas sudah digunakan!',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'thn' => 'Tahun ajaran',
            'nama' => 'Nama kelas'
        ];
    }
}
