<?php
namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_authenticate()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_invalid_credentials()
    {
        $response = $this->postJson('/api/auth', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }
    public function test_invalid_auth_request()
    {
        $response = $this->postJson('/api/auth', [
            'email' => 'wrong@example.com'
        ]);

        $response->assertStatus(422);
    }
    public function test_logout()
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization',$token)->get('/api/logout');
        $response->assertStatus(200);
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