<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario') ?? $this->route('id') ?? $this->id;
        $userId = is_object($usuario) ? $usuario->id : $usuario;

        return [
            'rut' => ['sometimes', 'required', 'string', 'max:20', Rule::unique('users', 'rut')->ignore($userId)],
            'nombre' => ['sometimes', 'required', 'string', 'max:100'],
            'apellido' => ['sometimes', 'required', 'string', 'max:100'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($userId),
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/i'
            ],
            'password' => ['nullable', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'El RUT ingresado ya pertenece a otro usuario.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo ya pertenece a otro usuario.',
            'email.regex' => 'El correo debe tener dominio corporativo @ventasfix.cl.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}
