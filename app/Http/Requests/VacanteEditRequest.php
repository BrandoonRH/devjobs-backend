<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacanteEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => ['nullable', 'string'],
            'salario' => ['nullable', 'numeric', 'between:1,9'],
            'categoria' => ['nullable', 'numeric', 'between:1,7'],
            'empresa' => ['nullable', 'string'],
            'ultimo_dia' => ['nullable', 'date'],
            'descripcion' => ['nullable'],
            'imagen' => ['nullable'],
        ];
    }
    public function messages()
    {
        return [
            'salario.numeric' => 'El Salario no es valido',
            'categoria.numeric' => 'La Categoria no es valido',
           'ultimo_dia.date' => "El formato de la fecha no es valido",
        ];
    }
}
