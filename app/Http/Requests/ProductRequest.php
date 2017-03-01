<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description' => 'required',
            'code' => 'required',
            'stock' => 'required|numeric',
            'regular_price' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required'
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
            'description.required' => 'No has escrito una descripción',
            'code.required' => 'No has escrito un código',
            'stock.required' => 'No has escrito una cantidad',
            'stock.numeric' => 'La cantidad debe ser un número entero',
            'regular_price.required' => 'No has escrito un precio',
            'brand_id.required' => 'No has seleccionado una marca',
            'category_id.required' => 'No has seleccionado una categoría'
        ];
    }
}
