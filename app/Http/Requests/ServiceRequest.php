<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'title' => 'required',
            'price' => 'required',
            'content' => 'required',
            'notes' => 'required'
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
            'title.required' => 'No has escrito un título',
            'price.required' => 'No has escrito un precio',
            'content.required' => 'No has escrito un contenido',
            'notes.required' => 'No has escrito las cláusulas de contratación'
        ];
    }
}
