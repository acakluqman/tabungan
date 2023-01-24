<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTahunRequest extends FormRequest
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
            'thn_ajaran' => 'required|unique:tahun_ajaran,thn_ajaran',
            'tgl_mulai' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (date_format(date_create($value), 'Y') != request()->thn_ajaran) {
                        $fail('Tanggal mulai harus di tahun ' . request()->thn_ajaran . '!');
                    }
                },
            ],
            'tgl_selesai' => [
                'required',
                'date',
                'after_or_equal:tgl_mulai',
                function ($attribute, $value, $fail) {
                    if (date_format(date_create($value), 'Y') != (request()->thn_ajaran + 1)) {
                        $fail('Tanggal selesai harus di tahun ' . (request()->thn_ajaran + 1) . '!');
                    }
                },
            ],
            'is_aktif' => 'required'
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
            'thn_ajaran.unique' => 'Tahun ajaran sudah ada sebelumnya!',
            'tgl_mulai.required' => 'Tanggal selesai harus diisi!',
            'tgl_mulai.date' => 'Format tanggal selesi tidak valid!',
            'tgl_selesai.required' => 'Tanggal selesai harus diisi!',
            'tgl_selesai.date' => 'Format tanggal selesi tidak valid!',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai harus lebih dari atau sama dengan tanggal mulai!',
            'is_aktif.required' => 'Status harus dipilih!'
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
            'thn_ajaran' => 'Tahun ajaran',
            'tgl_mulai' => 'Tanggal mulai',
            'tgl_selesai' => 'Tanggal selesai',
            'is_aktif' => 'Status'
        ];
    }
}
