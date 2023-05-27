<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'agence_id' => 'required',
            'username' => 'required',
            'nom'     => 'required',
            'prénom'  => 'required',
            'password' => 'required|confirmed',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'agence_id' => 'agence',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'agence_id' => 'agence est requis',
            'username' => 'Username est requis',
            'nom'     => 'nom est requis',
            'prénom'  => 'prénom est requis',
            'password' => 'password est requis',
        ];
    }
}