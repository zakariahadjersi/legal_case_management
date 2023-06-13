<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DossierJusticeRequest extends FormRequest
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
            'state'   => 'required',
            'secteur' => 'required',
            'partie_adverse_id' => 'required'
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
            'state' => 'Etat',
            'partie_adverse_id' => 'Partie Adverse'
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
            'state'   => 'Etat est requis',
            'secteur' => 'Secteur est requis',
            'partie_adverse_id' => 'Partie Adverse est requis'
        ];
    }
}
