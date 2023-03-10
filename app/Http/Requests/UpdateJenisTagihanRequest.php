<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisTagihanRequest extends FormRequest
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
            'thn_ajaran' => 'required',
            'jml_tagihan' => 'required|numeric',
            'periode' => 'required',
            'nama' => [
                'required',
                Rule::unique('jenis_tagihan')->where(function ($query) use ($request) {
                    return $query
                        ->where('thn_ajaran', $request->thn_ajaran)
                        ->where('nama', $request->nama);
                })->ignore($request->id, 'id_jenis_tagihan')
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
            'thn_ajaran.required' => 'Tahun ajaran harus diisi!',
            'nama.required' => 'Nama jenis tagihan harus diisi!',
            'nama.unique' => 'Nama jenis tagihan sudah digunakan!',
            'jml_tagihan.required' => 'Jumlah tagihan harus diisi!',
            'jml_tagihan.numeric' => 'Jumlah tagihan harus diisi dengan angka!',
            'periode.required' => 'Periode tagihan harus diisi!',
        ];
    }
}
