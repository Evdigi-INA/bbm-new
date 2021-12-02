<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'kode' => 'required|max:10|unique:supplier,kode',
            'nama_supplier' => 'required',
            'npwp' => 'nullable',
            'nppkp' =>  'nullable',
            'tgl_pkp' => 'required',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'kode_pos' => 'nullable|max:10',
            'telp1' => 'nullable',
            'telp2' => 'nullable',
            'nama_kontak' => 'nullable',
            'telp_kontak' => 'nullable',
            'top' => 'nullable',
            'status' => 'required|in:Y,N',
        ];
    }
}
