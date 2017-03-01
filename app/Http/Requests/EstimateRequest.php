<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest
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
            'client_id' => 'required',
            'email' => 'email',
            'phone' => 'numeric',
            'service' => 'required',
            'services' => 'required'
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
            'client_id.required' => 'No has seleccionado un cliente',
            'email.email' => 'No has escrito un correo electrónico válido',
            'phone.numeric' => 'No has escrito un número de teléfono válido',
            'service' => 'No has escrito un servicio',
            'services' => 'No has seleccionado ningún servicio'
        ];
    }
}
