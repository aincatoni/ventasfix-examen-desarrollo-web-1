<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $producto = $this->route('producto') ?? $this->route('id') ?? $this->id;
        $prodId = is_object($producto) ? $producto->id : $producto;

        return [
            'sku' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('productos', 'sku')->ignore($prodId)],
            'nombre' => ['sometimes', 'required', 'string', 'max:150'],
            'descripcion_corta' => ['sometimes', 'required', 'string', 'max:255'],
            'descripcion_larga' => ['sometimes', 'required', 'string'],
            'imagen' => ['sometimes', 'required', 'string'],
            'precio_neto' => ['sometimes', 'required', 'numeric', 'min:0'],
            'precio_venta' => ['nullable', 'numeric', 'min:0'],
            'stock_actual' => ['sometimes', 'required', 'integer', 'min:0'],
            'stock_minimo' => ['sometimes', 'required', 'integer', 'min:0'],
            'stock_bajo' => ['sometimes', 'required', 'integer', 'min:0'],
            'stock_alto' => ['sometimes', 'required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'sku.required' => 'El código SKU es obligatorio.',
            'sku.unique' => 'El código SKU ya pertenece a otro producto.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'descripcion_corta.required' => 'La descripción corta es obligatoria.',
            'descripcion_larga.required' => 'La descripción larga es obligatoria.',
            'imagen.required' => 'La imagen del producto es obligatoria.',
            'precio_neto.required' => 'El precio neto es obligatorio.',
            'stock_actual.required' => 'El stock actual es obligatorio.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'stock_bajo.required' => 'El stock bajo es obligatorio.',
            'stock_alto.required' => 'El stock alto es obligatorio.',
        ];
    }
}
