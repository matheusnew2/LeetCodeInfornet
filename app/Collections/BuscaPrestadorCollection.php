<?php
namespace App\Collections;

use App\Library\ApiInfornet;
use Illuminate\Database\Eloquent\Collection;

class BuscaPrestadorCollection extends Collection
{
    public function filtrar($filtro)
    {
        $prestadores = new Collection($this->all());
        
        if(!empty($filtro['estado']))
        {
            $estado = $filtro['estado'];
            $prestadores = $prestadores->filter(function($item) use ($estado) {
                return $item == $estado;
            });
        }
        if(!empty($filtro['cidade']))
        {
            $cidade = $filtro['cidade'];
            $prestadores = $prestadores->filter(function($item) use ($cidade) {
                return $item == $cidade;
            });
        }
        return $prestadores;
    }
    public function setPrestadoresStatus()
    {
        $prestadores = new Collection($this->all());
        $idsPrestadores =  $prestadores->pluck('id_prestador')->toArray();
        if(empty($idsPrestadores))
            return $this;
        
        $apiInfornet =  new ApiInfornet();
        $prestadoresStatus = $apiInfornet->getPrestadoresOnline($idsPrestadores);
        foreach($prestadoresStatus as $prestadoStatus)
        {
            $prestadorModel = $prestadores->where('id_prestador','=',$prestadoStatus->idPrestador)->first();
            if($prestadorModel)
            {
                $prestadorModel->status = $prestadoStatus->status;
            }
        }
        return $this;
    }
    public function makeCalculos($endereco_origem,$endereco_destino)
    {
        $prestadores = new Collection($this->all());

        $prestadores->map(function($item) use ($endereco_origem,$endereco_destino) {
            $item->distancia_total = $item->calculaDistaciaTotal($endereco_origem,$endereco_destino,[ 'lat' => $item->prestador->latitude,'lon' => $item->prestador->longitude]);
            $item->valor_total = $item->calculaValorTotal();
        });
        return $this;
    }   
    public function orderPrestadores($order = null)
    {
        $prestadores = collect($this->all());
        switch ($order)
        {
            case 'status';
                $prestadores = $this->sortByDesc('status');
                break;
            case 'valor_total':
            case 'distancia_total':
                $prestadores = $this->sortBy($order);
                break;
        }
        return $prestadores;
    }
}