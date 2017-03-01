<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'bank_details' => 'required',
            'logo' => 'mimes:jpeg,png,svg'
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company.required' => 'No has escrito el nombre de la compañía',
            'email.required' => 'No has escrito un correo electrónico',
            'email.email' => 'No has escrito un correo electrónico válido',
            'phone.required' => 'No has escrito un teléfono',
            'address.required' => 'No has escrito una dirección',
            'notes.required' => 'No has escrito notas',
            'bank_details.required' => 'No has escrito datos bancarios',
            'logo.mimes' => 'No has seleccionado un archivo de tipo imagen (jpg, png, svg)'
        ];
    }
}
