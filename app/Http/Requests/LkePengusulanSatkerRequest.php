<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LkePengusulanSatkerRequest extends FormRequest
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
        $lke_id = request('lke_id');
        $predikat_id = request('predikat_id');

        return [
            //
            'aktif' => 'required',
            'lke_id' => 'required|string',
            'predikat_id' => 'required|string',
            'satker_id' => [
                'required',
                'string',
                Rule::unique('lke_pengusulan_satkers')->where(function($query) use ($lke_id, $predikat_id) {
                    return $query->where('lke_id', $lke_id)
                        ->where('predikat_id', $predikat_id);
                }),
            ],
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
            'satker_id' => 'satker',
            'predikat_id' => 'predikat',
        ];
    }
}
