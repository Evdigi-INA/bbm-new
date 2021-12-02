<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelangganRequest extends FormRequest
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
            'kode' => 'required|max:10|unique:pelanggan,kode,' . $this->pelanggan->id,
            'area' => 'required',
            'nama_pelanggan' => 'required',
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
            'limit' => 'nullable',
            'status' => 'required|in:Y,N',
        ];
    }
}
