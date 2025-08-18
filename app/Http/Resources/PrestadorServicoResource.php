<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrestadorServicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this->prestador->nome,
            'id_servico' => $this->id_servico,
            'km_saida' => $this->km_saida,
            'valor_saida' => 'R$ '.number_format($this->valor_saida,2,',','.'),
            'valor_km_excedente' => 'R$ '.number_format($this->valor_km_excedente,2,',','.'),
            'distancia_total' => $this->distancia_total.' KM',
            'valor_total' => 'R$ '.number_format($this->valor_total,2,',','.'),
            'status' => $this->status
        ];
    }
}

