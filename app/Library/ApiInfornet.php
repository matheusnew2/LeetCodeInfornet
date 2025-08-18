<?php 
namespace App\Library;
use Illuminate\Support\Facades\Http;

class ApiInfornet{
    private $http;
    private $url;
    private $user;
    private $password;
    public function __construct()
    {   
        $this->url = env('INFORNET_API_BASE_URL');
        $this->user = env('INFORNET_API_USER');
        $this->password = env('INFORNET_API_PASSWORD');
        $this->http = Http::withHeaders([
            'Authorization' => 'Basic '.base64_encode($this->user.':'.$this->password)
        ]);
    }
    public function getEnderenco($endereco)
    {
        $cache = cache()->get($endereco);
        
        if($cache) 
            return $cache;
        
        $response = $this->http->get($this->url.'/v1/api/endereco/geocode/'.$endereco);
        if($response->status() == 200)
        {
            $body = json_decode($response->body(),true);
            if($body)
            {
                $arrayRetorno = [
                    'lat' => $body['lat'],
                    'lon' => $body['lon']
                ];
                cache()->set($endereco,$arrayRetorno);
                return $arrayRetorno;
            }
        }
        return false;
    }
    public function getPrestadoresOnline($idsPrestadores)
    {
        $response = $this->http->post($this->url.'/v1/api/prestadores/online',[
            'prestadores' => $idsPrestadores
        ]);
        
        if($response->status() == 200)
        {
            $body = json_decode($response->body());
            if($body && !empty($body->prestadores))
            {
                return $body->prestadores;
            }
        }
        return false;
    }
}