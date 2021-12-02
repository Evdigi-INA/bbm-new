<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TokoRequest extends FormRequest
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
            'nama' => 'required|string|min:3|max:191',
            'telp1' => 'required',
            'telp2' => 'nullable',
            'email' => 'required|email',
            'deskripsi' => 'nullable|string|min:3',
            'npwp' => 'nullable',
            'fax' => 'nullable',
            'nppkp' => 'nullable',
            'website' => 'nullable',
            'tgl_pkp' => 'nullable',
            'alamat' => 'required|string|min:3',
            'kota' => 'required',
            'kode_pos' => 'nullable',
        ];
    }
}
