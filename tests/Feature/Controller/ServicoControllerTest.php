<?php
namespace Tests\Feature\Controller;
use App\Exceptions\InvalidOrderException;
use Illuminate\Support\Facades\Exceptions;
   use App\Listeners\StoreServicosCache;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Event;
use App\Events\ServicosRetrieved;
use App\Models\Servico;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ServicoControllerTest extends TestCase
{
     use RefreshDatabase;
    public function test_get_servicos()
    {
        $user = Servico::create([
            'nome' => 'Guincho',
            'situacao' => 1
        ]);
        
        $token = $this->getToken();
        
        $response = $this->withHeader('Authorization',$token)->get('/api/servico');
        
        $response->assertStatus(200)
        ->assertJson([['nome'=>'Guincho']]);
    }
    public function test_eventCache()
    {
        $servico  = Servico::create([
            'nome' => 'Guincho',
            'situacao' => 1
        ]);
        cache()->set('servicos',[$servico]);

        $token = $this->getToken();
        
        $response = $this->withHeader('Authorization',$token)->get('/api/servico');
        
        $response->assertStatus(200);

    }
    public function test_invalid_token()
    {
        $user = Servico::create([
            'nome' => 'Guincho',
            'situacao' => 1
        ]);
        
        $token = $this->getToken();
        
        $response = $this->get('/api/servico');
        
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