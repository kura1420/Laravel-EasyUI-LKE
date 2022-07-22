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
            'urutan' => 'required|string|max:30',
            'urutan_tampilkan' => 'required',
            'kode' => 'required|string|max:50',
            'alias' => 'required|string|max:255',
            'indikator' => 'required|string',
            'penjelasan' => 'required|string',
            'aktif' => 'required',
            'nilai' => 'nullable|numeric',
            'parent' => 'nullable|string|max:36',
            'tipe_jawaban' => 'nullable|string|max:30',
            'lke_id' => 'required|string',
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
