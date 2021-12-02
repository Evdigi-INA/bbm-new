<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiayaRequest extends FormRequest
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
            'matauang' => 'required',
            'bank' => 'nullable',
            'rekening' => 'required_with:bank',
            'kode' => 'required',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'kas_bank' => 'required|in:Kas,Bank',
            'keterangan' => 'required',
            'rate' => 'required|numeric',
            'jumlah' => 'required|array',
            'deskripsi' => 'required|array',
        ];
    }
}
