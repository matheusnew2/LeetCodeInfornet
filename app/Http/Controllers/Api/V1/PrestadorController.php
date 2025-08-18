<?php

namespace App\Http\Controllers\Api\V1;

use App\Collections\BuscaPrestadorCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetPrestadoresRequest;
use App\Http\Resources\PrestadorServicoResource;
use App\Models\PrestadorServico;
use App\Models\Servico;
use Illuminate\Http\Client\ConnectionException;
use Exception;
class PrestadorController extends Controller
{
   
    public function getPrestadores(GetPrestadoresRequest $request)
    {
        try
        {
            extract($request->validated());
            $order = !empty($order) ? $order : null;
            $qtd = !empty($qtd) ? $qtd : 0;
            $filtro = !empty($filtro) ? $filtro : [];
            
            $prestadores = $this->makeQuery($id_servico,$endereco_origem,$endereco_destino,$filtro,$order,$qtd);
            if($prestadores)
            {
                return response()->json(PrestadorServicoResource::collection($prestadores));
            }
        }
        catch(ConnectionException $e)
        {
            return response('Bad Gateway',502);
        } 
        catch (Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }

    private function makeQuery($id_servico,$endereco_origem,$endereco_destino,$filtro,$order = null,$qtd = 0)
    {
        $query = PrestadorServico::with('prestador')->where('id_servico','=',$id_servico);
      
  
        
        $prestadores =  $query->get();

        if($prestadores)
        {
            
            $prestadorCollection = new BuscaPrestadorCollection($prestadores);
            $prestadorCollection = $prestadorCollection
                ->setPrestadoresStatus()
                ->makeCalculos($endereco_origem,$endereco_destino)
                ->orderPrestadores($order);

            if(!empty($filtro['estado']))
            {
                $estado = $filtro['estado'];
                $prestadorCollection = $prestadorCollection->filter(function($item) use ($estado) {
                    return $item->prestador->uf == $estado;
                });
            }
            if(!empty($filtro['cidade']))
            {
                $cidade = $filtro['cidade'];
                $prestadorCollection = $prestadorCollection->filter(function($item) use ($cidade) {
                    return $item->prestador->cidade == $cidade;
                });
            }
   
        }
      if($qtd)
            $prestadorCollection->take($qtd);
        return $prestadorCollection;
    }
    
    public function getEnderecosDisponiveis()
    {
        try
        {
            $servicos = cache()->get('servicos');
            if(!$servicos)
            {
                $servicos = Servico::all();    
            }
            $arrayResponse = [
                'ufs' => [],
                'cidades' => []
            ];

            foreach($servicos as $servico)
            {
                $arrayResponse['cidades'][$servico->id] = $servico
                    ->enderecosServico
                    ->groupBy('cidade')
                    ->sortKeys()
                    ->keys();

                $arrayResponse['ufs'][$servico->id] = $servico
                    ->enderecosServico
                    ->groupBy('uf')
                    ->sortKeys()
                    ->keys()
                    ->map(function($item){
                        return  [
                            'sigla' => $item,
                            'nome' => $this->getNomeEstado($item)
                        ];
                    });
                    
            }

            return $arrayResponse;
        }
        catch(Exception $e)
        {
            return response('Internal Server Error',500);
        }
        
    }
    public function getNomeEstado($uf)
    {
        $estadosBrasil = [
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AP" => "Amapá",
            "AM" => "Amazonas",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MT" => "Mato Grosso",
            "MS" => "Mato Grosso do Sul",
            "MG" => "Minas Gerais",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PR" => "Paraná",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RS" => "Rio Grande do Sul",
            "RO" => "Rondônia",
            "RR" => "Roraima",
            "SC" => "Santa Catarina",
            "SP" => "São Paulo",
            "SE" => "Sergipe",
            "TO" => "Tocantins"
        ];
        if(empty($estadosBrasil[$uf]))
        {
            return false;
        }
        return $estadosBrasil[$uf];
    }

}