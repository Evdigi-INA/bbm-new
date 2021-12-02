<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRekeningBankRequest extends FormRequest
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
            'kode' => 'required|max:5|unique:rekening_bank,kode',
            'nama_rekening' => 'required|min:3',
            'status' => 'required|in:Y,N',
            'nomor_rekening' => 'required',
            'bank' => 'required',
        ];
    }
}
