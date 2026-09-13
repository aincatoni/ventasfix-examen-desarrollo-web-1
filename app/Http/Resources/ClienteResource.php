<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rut_empresa' => $this->rut_empresa,
            'rubro' => $this->rubro,
            'razon_social' => $this->razon_social,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'nombre_contacto' => $this->nombre_contacto,
            'email_contacto' => $this->email_contacto,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
