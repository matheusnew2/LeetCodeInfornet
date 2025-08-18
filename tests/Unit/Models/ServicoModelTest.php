<?php
namespace Tests\Feature\Models;

use App\Models\Servico;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicoModelTest extends TestCase
{
     use RefreshDatabase;
    public function test_enderecosServico()
    {
        $servico = Servico::create([
            'nome' => 'Guincho',
            'situacao' => 1
        ]);
        if($servico)
        {
            if(!empty($servico->enderecosServico) && is_array($servico->enderecosServico))
            {
                $this->assertTrue(true);
            }
            else
            {
                $this->assertFalse(false);
            }
        }
     
    }


}