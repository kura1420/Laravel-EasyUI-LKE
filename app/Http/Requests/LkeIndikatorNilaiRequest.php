<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LkeIndikatorNilaiRequest extends FormRequest
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
            'nilai' => 'required|numeric',
            'lke_id' => 'required|string',
            'lke_predikat_id' => 'required|string',
            'lke_indikator_id' => 'required|string',
            // 'predikat_id' => 'required|string',
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
