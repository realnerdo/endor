<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'code' => 'required',
            'symbol' => 'required',
            'precision' => 'required|numeric'
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
            'code.required' => 'No has escrito un código',
            'symbol.required' => 'No has escrito un símbolo',
            'precision.required' => 'No has escrito una precisión',
            'precision.numeric' => 'La precisión debe ser un número entero'
        ];
    }
}
