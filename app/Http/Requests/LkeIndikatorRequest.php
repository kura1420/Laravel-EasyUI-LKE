<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LkeIndikatorRequest extends FormRequest
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
            'i_urutan' => 'required|string|max:30',
            'urutan_tampilkan' => 'required',
            'i_kode' => 'required|string|max:50',
            'i_alias' => 'required|string|max:255',
            'i_indikator' => 'required|string',
            'i_penjelasan' => 'required|string',
            'aktif' => 'required',
            'i_nilai' => 'nullable|numeric',
            'i_parent' => 'nullable|string|max:36',
            'i_tipe_jawaban' => 'nullable|string|max:30',
            'i_lke_id' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => $validator->errors(),
            'status' => 'NOT'
        ], 422));
    }

    public function attributes()
    {
        return [
            'lke_id' => 'lke',
        ];
    }
}
