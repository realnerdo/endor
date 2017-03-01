<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required'
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
            'name.required' => 'No has escrito un nombre',
            'email.required' => 'No has escrito un correo electrónico',
            'email.email' => 'El correo electrónico que escribiste no es válido',
            'email.unique' => 'El correo electrónico que escribiste ya existe',
            'phone.required' => 'No has escrito un teléfono'
        ];
    }
}
