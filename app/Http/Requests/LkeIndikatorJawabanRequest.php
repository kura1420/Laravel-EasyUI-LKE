<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LkeIndikatorJawabanRequest extends FormRequest
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
        $id = request('id');
        
        return [
            //
            'j_urutan' => 'required|string|max:255',
            'j_jawaban' => 'required|string|max:255',
            'j_nilai' => 'required|string|max:255',
            'j_penjelasan' => 'nullable|string|max:255',
            'j_aktif' => 'required|string|max:255',
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
            'j_urutan' => 'urutan',
            'j_jawaban' => 'jawaban',
            'j_nilai' => 'nilai',
            'j_penjelasan' => 'penjelasan',
            'j_aktif' => 'aktif',
            'lke_id' => 'lke',
            'lke_indikator_id' => 'indikator',
        ];
    }
}
