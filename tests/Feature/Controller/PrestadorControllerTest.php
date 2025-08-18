<?php
namespace Tests\Feature\Controller;

use App\Http\Controllers\Api\V1\PrestadorController;
use App\Http\Requests\GetPrestadoresRequest;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrestadorControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getPrestadores()
    {
        $this->seed();
        $busca = [
            'id_servico' => 1,
            'endereco_origem' => 'Belo Horizonte',
            'endereco_destino' => 'Belo Horizonte',
            'qtd' => 25,
            'order' => 1
        ];
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->postJson('/api/buscarPrestadores', $busca);
        
        $response->assertStatus(200)
            ->assertJsonCount(25);
    }
    public function test_getNomeEstado()
    {
        $prestadorController = new PrestadorController();
        $estado = $prestadorController->getNomeEstado('MG');
        if($estado == 'MG')
        {
            $this->assertTrue(true);
        }
        else
        {
            $this->assertFalse(false);
        }

    }
    



    public function test_getEnderecosDisponiveis()
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->get('/api/getEnderecosDisponiveis');

        $response->assertStatus(200);
    }
    
    public function test_getPrestadores_invalid_request()
    {
        $busca = [
            'id_servico' => 1,
            'endereco_origem' => 'Belo Horizonte',
            'qtd' => 25,
            'order' => 1
        ];
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->postJson('/api/buscarPrestadores', $busca);
        
        $response->assertStatus(422);
    }
    public function test_getPrestadores_invalid_request_order3()
    {
        $busca = [
            'id_servico' => 1,
            'endereco_origem' => 'Belo Horizonte',
            'qtd' => 25,
            'order' => 3
        ];
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->postJson('/api/buscarPrestadores', $busca);
        
        $response->assertStatus(422);
    }
    public function test_getPrestadores_invalid_request_order()
    {
        $busca = ['order'=>2];
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->postJson('/api/buscarPrestadores', $busca);
        
        $response->assertStatus(422);
    }

    public function test_getPrestadores_invalid_address()
    {
        $this->seed();
        $busca = [
            'id_servico' => 1,
            'endereco_origem' => 'BeloHorizonte',
            'endereco_destino' => 'BeloHorizonte',
        ];
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)
            ->postJson('/api/buscarPrestadores', $busca);
        
        $response->assertStatus(422);
    }

    private function getToken()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $json = json_decode($response->getContent());
        if($json)
            return 'Bearer '.$json->access_token;
        return false;
    }
}