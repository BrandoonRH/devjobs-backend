<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacanteRequest extends FormRequest
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
            'titulo' => ['required', 'string'],
            'salario' => ['required', 'numeric', 'between:1,9'],
            'categoria' => ['required', 'numeric', 'between:1,7'],
            'empresa' => ['required', 'string'],
            'ultimo_dia' => ['required', 'date'],
            'descripcion' => ['required'],
            'imagen' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'titulo' => 'El Titulo es requerido',
            'salario' => 'El Salario es requerido',
            'salario.numeric' => 'El Salario no es valido',
            'categoria' => 'La Categoria es requerida',
            'categoria.numeric' => 'La Categoria no es valido',
            'empresa' => 'La Empresa es requerida',
            'ultimo_dia' => 'La fecha de ultimo dia es requerida',
           // 'ultimo_dia.date' => "El formato de la fecha no es valido",
            'descripcion' => 'La descripción de la vacante es requerida',
            'imagen' => 'La imagen es requerida',
        ];
    }
}
