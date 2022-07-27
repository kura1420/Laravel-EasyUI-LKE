<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LkeIndikatorFormulaRequest extends FormRequest
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
            'f_urutan' => 'required|numeric',
            'f_rumus' => 'required|string|max:50',
            'f_lke_indikator_id_target' => 'nullable|string',
            'nilai_maksimal' => 'required',
            'nilai_maksimal_mengurangi' => 'required',
            'f_tipe_penilaian' => 'required|string|max:50',
            'f_nilai_bilangan' => 'nullable|numeric',
            'f_nilai_bawaaan' => 'nullable|numeric',
            'f_keterangan' => 'nullable|string',
            'lke_id' => 'required|string',
            'lke_indikator_id' => 'required|string',
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
            'f_urutan' => 'urutan',
            'f_rumus' => 'rumus',
            'f_lke_indikator_id_target' => 'indikator target',
            'nilai_maksimal' => 'nilai maksimal',
            'nilai_maksimal_mengurangi' => 'nilai maksimal mengurangi',
            'f_tipe_penilaian' => 'tipe penilaian',
            'f_nilai_bilangan' => 'nilai bilangan',
            'f_nilai_bawaaan' => 'nilai bawaaan',
            'f_keterangan' => 'keterangan',
            'lke_id' => 'lke',
            'lke_indikator_id' => 'indikator',
        ];
    }
}
