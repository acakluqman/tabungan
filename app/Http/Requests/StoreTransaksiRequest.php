<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
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
            'id_tagihan' => 'required',
            'total_tagihan' => 'required',
            'total_bayar' => 'required',
            'tgl_transaksi' => 'required',
            'id_petugas' => 'required',
        ];
    }
}
