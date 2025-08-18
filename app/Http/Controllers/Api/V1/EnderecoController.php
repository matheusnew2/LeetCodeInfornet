<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LatitudeLongitudeResource;
use App\Library\ApiInfornet;
use Illuminate\Http\Client\ConnectionException;
use Exception;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function getCoordenadaEndereco(Request $request)
    {
        try
        {   
            if(empty($request->endereco) || $request->endereco == 'null')
            {
                return response('Campo enderenço obrigatório',422);
            }
            $apiInfornet = new ApiInfornet();
            $retorno = $apiInfornet->getEnderenco($request->endereco);
            if($retorno)
            {
                return response()->json( new LatitudeLongitudeResource($retorno));
            }
            return response('Bad Gateway',502);
        }
        catch(ConnectionException $e)
        {
            return response('Bad Gateway',502);
        }
        catch(Exception $e)
        {
            return response('Internal Server Error',500);
        }
    }
}
