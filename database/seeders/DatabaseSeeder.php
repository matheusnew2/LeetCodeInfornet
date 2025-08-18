<?php

namespace Database\Seeders;

use App\Library\ApiInfornet;
use App\Models\Prestador;
use App\Models\PrestadorServico;
use App\Models\Servico;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'email' => 'user@infornet.com'
        ]);

        Servico::factory()->create(["id" => 1, "nome" => "Guincho","situacao" => 1]);
        Servico::factory()->create(["id" => 2,"nome" => "Mecânico","situacao" => 1]);
        Servico::factory()->create(["id" => 3,"nome" => "Chaveiro","situacao" => 1]);


        $enderecos = [
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Parque Duval de Barros',
                'logradouro' => 'Rua Coronel Durval de Barros',
                'numero' => '222',
                'latitude' => '-19.9754195',
                'longitude' => '-44.0588912'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Jardim do Lago',
                'logradouro' => 'R. Mandarim',
                'numero' => '100',
                'latitude' => '-19.8813479',
                'longitude' => '-44.0465488'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Serra',
                'logradouro' => 'R. Muzambinho',
                'numero' => '551',
                'latitude' => '-19.9449825',
                'longitude' => '-43.9203413'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Santa Lúcia',
                'logradouro' => 'R. Zodíaco',
                'numero' => '493',
                'latitude' => '-19.9657646',
                'longitude' => '-43.9457007'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Nova Granada',
                'logradouro' => 'Av. Barão Homem de Melo',
                'numero' => '2212',
                'latitude' => '-19.9342281',
                'longitude' => '-19.9342281'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Padre Eustáquio',
                'logradouro' => 'Rua Aquidaban',
                'numero' => '1039',
                'latitude' => '-19.9199249',
                'longitude' => '-43.9782776'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'São Geraldo',
                'logradouro' => 'R. Sucuri',
                'numero' => '504',
                'latitude' => '-19.8952688',
                'longitude' => '-43.8981256'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Jardim Vitoria',
                'logradouro' => 'Rua Geraldo Ferreira da Glória',
                'numero' => '299',
                'latitude' => '-19.8548773',
                'longitude' => '-43.8822604'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Ouro Preto',
                'logradouro' => 'R. Monteiro Lobato',
                'numero' => '187',
                'latitude' => '-19.8731907',
                'longitude' => '-43.9854815'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Alípio de Melo',
                'logradouro' => 'R. dos Geólogos',
                'numero' => '621',
                'latitude' => '-19.8951602',
                'longitude' => '-44.0001618'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Contagem',
                'bairro' => 'Retiro',
                'logradouro' => 'Av. dos Retirantes',
                'numero' => '322',
                'latitude' => '-19.8351084',
                'longitude' => '-44.1507458'
            ],
             [
                'uf' => 'MG',
                'cidade' => 'Betim',
                'bairro' => 'Centro',
                'logradouro' => 'R. Prof. Clóvis Salgado',
                'numero' => '239',
                'latitude' => '-19.9680976',
                'longitude' => '-44.1978058'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Barreiro',
                'logradouro' => 'R. Benjamin Dias',
                'numero' => '365',
                'latitude' => '-19.9782772',
                'longitude' => '-44.0162070'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Pedro Leopoldo',
                'bairro' => 'Centro',
                'logradouro' => 'Herbster',
                'numero' => '293a',
                'latitude' => '-19.6211883',
                'longitude' => '-44.0432721'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Sete Lagoas',
                'bairro' => 'Canaã',
                'logradouro' => 'Av. Dr. Renato Azeredo',
                'numero' => '678',
                'latitude' => '-19.609179',
                'longitude' => '-43.936199'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Centro',
                'logradouro' => 'Av. Oiapoque',
                'numero' => '156',
                'latitude' => '-19.9131077',
                'longitude' => '-43.9393344'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Ribeirão das Neves',
                'bairro' => 'Guadalajara',
                'logradouro' => 'Av. Denise Cristina da Rocha',
                'numero' => '857',
                'latitude' => '-19.8016683',
                'longitude' => '-44.0080058'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Buritis',
                'logradouro' => 'Av. Eng. Carlos Goulart',
                'numero' => '21',
                'latitude' => '-19.9681495',
                'longitude' => '-43.9627811'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Belvedere',
                'logradouro' => 'BR-356',
                'numero' => '3049',
                'latitude' => '-19.9950414',
                'longitude' => '-43.9603500'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Gameleira',
                'logradouro' => 'Av. Amazonas',
                'numero' => '6200',
                'latitude' => '-19.9319944',
                'longitude' => '-43.9922098'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Contagem',
                'bairro' => 'Cachoeirinha',
                'logradouro' => 'Av. João César de Oliveira',
                'numero' => '664',
                'latitude' => '-19.380632',
                'longitude' => '-43.758146'
            ],
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Gloria',
                'logradouro' => 'R. Guararapes',
                'numero' => '139',
                'latitude' => '-19.9045284',
                'longitude' => '-44.0125371'
            ],

            [
                'uf' => 'MG',
                'cidade' => 'Ribeirão das Neves',
                'bairro' => 'Vereda',
                'logradouro' => 'Av. A',
                'numero' => '160',
                'latitude' => '-19.8292415',
                'longitude' => '-44.0859612'
            ],

            [
                'uf' => 'MG',
                'cidade' => 'Contagem',
                'bairro' => 'Inconfidentes',
                'logradouro' => 'Av. Cel. Jove Soares Nogueira',
                'numero' => '971',
                'latitude' => '-19.108768',
                'longitude' => '-43.302602'
            ],
            
            [
                'uf' => 'MG',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Cachoeirinha',
                'logradouro' => 'Rua Simão Tamm',
                'numero' => '429',
                'latitude' => '-19.8883315',
                'longitude' => '-43.9449262'
            ],
            
        ];

        $servicos = Servico::all();

        foreach($enderecos as $endereco)
        {
            $id_prestador = Prestador::factory()->create($endereco)->id;
            $servicos_prestador = [];
            for($j = 0;$j<3;$j++)
            {
                $random = $servicos->except($servicos_prestador)->random()->id;
                PrestadorServico::factory()->create([
                    'id_prestador' => $id_prestador,
                    'id_servico' => $random
                ]);
                $servicos_prestador[] = $random;
            }
        }
    }
}
