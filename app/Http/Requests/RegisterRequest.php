<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
            'rol' => ['required', 'numeric', 'between:1,2']
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El Nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El usuario ya esta registrado',
            'password' => 'El password debe contener al menos, 8 caracteres, un simbolo y un número',
            'rol.required' => 'El rol es requerdio',
            'rol.numeric' => 'El rol debe ser un número valido'

        ];
    }
}
