<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartieAdverseRequest extends FormRequest
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
            'nomprénom' => 'required|min:5|max:255',
            'telephone' => 'regex:/^\+?\d{1,3}[-.\s]?\(?\d{1,3}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}$/',
            'naturecontractant'  => 'required',
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
            'nomprénom' => 'nom complete de personnel ou entreprise ',
            'telephone' => 'numéro de telephone',
            'naturecontractant'  => 'Nature de contractant',
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
            'nomprénom' => 'nom complete de personnel ou entreprise est requis ',
            'naturecontractant'  => 'Nature de contractant est requis',
        ];
    }
}
