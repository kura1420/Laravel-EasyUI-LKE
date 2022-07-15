<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SatkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session()->get('user_login');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request('id') ?? NULL;

        return [
            //
            'kode' => 'required|string|max:50|alpha_num|unique:satkers,kode,' . $id,
            'nama' => 'required|string|max:255',
            // 'provinsi' => 'nullable|string|max:255',
            // 'kota' => 'nullable|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'nullable|string|max:255|unique:satkers,email,' . $id,
            'telp' => 'nullable|numeric|unique:satkers,telp,' . $id,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => $validator->errors(),
            'status' => 'NOT'
        ], 422));
    }
}
