<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cliente = $this->route('cliente') ?? $this->route('id') ?? $this->id;
        $clienteId = is_object($cliente) ? $cliente->id : $cliente;

        return [
            'rut_empresa' => ['required', 'string', 'max:20', Rule::unique('clientes', 'rut_empresa')->ignore($clienteId)],
            'rubro' => ['required', 'string', 'max:100'],
            'razon_social' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:50'],
            'direccion' => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'max:100'],
            'email_contacto' => ['required', 'string', 'email', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'rut_empresa.required' => 'El RUT de la empresa es obligatorio.',
            'rut_empresa.unique' => 'El RUT de la empresa ya pertenece a otro registro.',
            'rubro.required' => 'El rubro de la empresa es obligatorio.',
            'razon_social.required' => 'La razón social es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'nombre_contacto.required' => 'El nombre de la persona de contacto es obligatorio.',
            'email_contacto.required' => 'El correo electrónico de contacto es obligatorio.',
        ];
    }
}
