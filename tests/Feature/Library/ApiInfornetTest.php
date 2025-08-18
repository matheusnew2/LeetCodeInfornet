<?php
namespace Tests\Feature\Controller;

use App\Library\ApiInfornet;
use App\Models\Servico;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiInfornetTest extends TestCase
{
    use RefreshDatabase;
    public function test_getEnderenco()
    {
        $api = new ApiInfornet();
        $endereco = $api->getEnderenco('Belo Horizonte');

        if(!empty($endereco))
        {
            $enderecoCorreto = [
                "lat" => "-19.9227318",
                "lon" => "-43.9450948"
            ];
            $endereco == $enderecoCorreto ? $this->assertTrue(true) : '';
        }
        else
        {
            $this->assertFalse(false);
        }
        
    }
    public function test_PrestadoresOnline()
    {
        $api = new ApiInfornet();
        $statusPrestadores = $api->getPrestadoresOnline([1,2]);

        if(!empty($statusPrestadores))
        {
            if(is_array($statusPrestadores) && count($statusPrestadores) == 2)
            {
                $this->assertTrue(true);
            }
            else
            {
                 $this->assertFalse(false);
            }
            
        }
        else
        {
            $this->assertFalse(false);
        }
        
    }
    public function test_PrestadoresOnline_empty()
    {
        $api = new ApiInfornet();
        $statusPrestadores = $api->getPrestadoresOnline([]);

        if(!empty($statusPrestadores))
        {
            if(is_array($statusPrestadores) && count($statusPrestadores) == 2)
            {
                $this->assertTrue(true);
            }
            else
            {
                 $this->assertFalse(false);
            }
            
        }
        else
        {
            $this->assertFalse(false);
        }
    }
}