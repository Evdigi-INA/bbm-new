<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGudangRequest extends FormRequest
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
            'kode' => 'required|max:5|unique:gudang,kode,' . $this->gudang->id,
            'nama' => 'required|min:3',
            'status' => 'required|in:Y,N',
            'gudang_penjualan' => 'required|in:1,0'
        ];
    }
}
