<?php
namespace Tests\Feature\Controller;

use App\Models\Servico;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnderecoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_coordenada_endereco()
    {     
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)->get('/api/buscarCoordenadas/Belo Horizonte');
        
        $response->assertStatus(200)
        ->assertJson(['lat' => '-19.9227318','lon' => '-43.9450948']);
    }
    public function test_get_coordenada_invalid()
    {     
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)->get('/api/buscarCoordenadas/asd2');
        
        $response->assertStatus(502);
    }
    public function test_get_empty()
    {     
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)->get('/api/buscarCoordenadas/null');
        
        $response->assertStatus(422);
    }
    public function test_invalid_token()
    {
        $response = $this->get('/api/buscarCoordenadas/Belo Horizonte');
        $response->assertStatus(401);
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