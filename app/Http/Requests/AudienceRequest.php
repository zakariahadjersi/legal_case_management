<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudienceRequest extends FormRequest
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
             'date' => 'required',
             'typecourt' => 'required',
             'dossier_justice_id' => 'required'
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
            'date' => 'Date',
            'typecourt' => 'Type Cour',
            'dossier_justice_id' => 'Code-affaire'
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
            'date' => 'Date est requis',
            'typecourt' => 'Type Cour est requis',
            'dossier_justice_id' => 'Code-affaire est requis'
        ];
    }
}
