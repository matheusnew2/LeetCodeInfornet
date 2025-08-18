<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ServicosRetrieved;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServicoResource;
use App\Models\Servico;
use Exception;
class ServicoController extends Controller
{
    public function getServicos()
    {
        try
        {
            $cache = cache()->get('servicos');
            if(!empty($cache))
                return response()->json(ServicoResource::collection($cache));
            $servicos = Servico::where('situacao','=',1)->get();
            event(new ServicosRetrieved($servicos));
            return response()->json(ServicoResource::collection($servicos));
        }
        catch(Exception $e)
        {
            return response('Internal Server Error',500);
        }
      
    }
}
