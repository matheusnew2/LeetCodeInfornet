<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestadorServico extends Model
{
    use HasFactory;
    protected $table = 'prestador_servico';
    public function prestador()
    {
        return $this->hasOne(Prestador::class,'id','id_prestador');
    }
    
  
    public function calculaValorTotal()
    {
        $total = $this->valor_saida;
        if($this->distancia_total > $this->km_saida)
        {
            $restante = $this->distancia_total - $this->km_saida;
            $total += $restante * $this->valor_km_excedente;
        }
        return $total;
    }
    public function calculaDistaciaTotal($endereco_prestador,$endereco_origem,$endereco_destino)
    {
        $deslocamento_inicial = $this->calcularDistancia($endereco_prestador['lat'],$endereco_prestador['lon'],$endereco_origem['lat'],$endereco_origem['lon']);
        $deslocamento_final = $this->calcularDistancia($endereco_origem['lat'],$endereco_origem['lon'],$endereco_destino['lat'],$endereco_destino['lon']);
        $retorno = $this->calcularDistancia($endereco_destino['lat'],$endereco_destino['lon'],$endereco_prestador['lat'],$endereco_prestador['lon']);
        return number_format(($deslocamento_inicial + $deslocamento_final + $retorno),0,'','');
    }
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Raio médio da Terra em km

        // Converte graus para radianos
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        // Calcula a diferença de latitude e longitude
        $deltaLat = $lat2Rad - $lat1Rad;
        $deltaLon = $lon2Rad - $lon1Rad;

        // Aplica a fórmula de Haversine
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calcula a distância
        $distance = $earthRadius * $c;

        return $distance;
    }
}
