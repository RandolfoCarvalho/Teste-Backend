<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
/**
 * Para rodar instale o php, composer etc
 * Abre o terminal control + j e da um php artisan serve
 * Basta acessar seu local com o link da rota que esta definida em routes/api/get
**/
class LocalController extends Controller
{
    public function searchLocal($ceps)
    {
        $cepsArray = explode(',', $ceps);
        $cepData = [];
        foreach ($cepsArray as $cep) {
            $client = new Client();
            $response = $client->get("https://viacep.com.br/ws/{$cep}/json/");

            // Se a gente receber um 200 é por que deu certo
            if (!$response->getStatusCode() == 200) {
                $cepData[] = ['error' => 'Erro na consulta, não deu bom' . $cep];
                return $cepData;
            }
            $cepData[] = json_decode($response->getBody(), true);
        }
        //Aqui eu inverti o json para ser exibido como pede no exercicio
        $cepDataReversed = array_reverse($cepData);
        return $cepDataReversed;
    }
}