<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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

        if ($id) {
            $passwordRule = 'nullable|';
        } else {
            $passwordRule = 'required|';
        }        

        return [
            //
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,' . $id,
            'username' => 'required|string|max:100|alpha_num|unique:users,username,' . $id,
            'password' => $passwordRule . 'string|min:6',
            'active' => 'required',

            // 'telp' => 'nullable|string|max:20',
            // 'handphone' => 'required|string|max:20',
            // 'departement_id' => 'required|string',
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
