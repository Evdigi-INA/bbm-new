<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelunasanPiutangRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'penjualan' => 'required|integer',
            'bank' => 'nullable|integer',
            'rekening_bank' => 'nullable|integer',
            'kode' => 'required',
            'tanggal' => 'required|date',
            'rate' => 'required',
            'jenis_pembayaran' => 'required',
            'no_cek_giro' => 'nullable',
            'tgl_cek_giro' => 'nullable|date',
            'bayar' => 'required',
            'keterangan' => 'nullable',
        ];
    }
}
