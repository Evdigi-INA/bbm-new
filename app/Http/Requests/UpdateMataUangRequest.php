<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMataUangRequest extends FormRequest
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
            'kode' => 'required|max:5|unique:matauang,kode,' . $this->matauang->id,
            'nama' => 'required|min:3',
            'default' => 'required|in:Y,N',
            'status' => 'required|in:Y,N',
        ];
    }
}
