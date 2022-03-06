<?php


namespace Tests\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LojaControllerTest extends TestCase
{
    public function test_index_se_dados_estao_no_formato_correto()
    {
        $this->json('get', 'api/lojas')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'nome',
                    'email'
                ]
            ]);
    }

    public function test_show_se_esta_retornando_no_formato_correto()
    {
        $this->json('get', 'api/lojas/2')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                [
                    'id',
                    'nome',
                    'email',
                    'produtos' => [
                        '*' => [
                            'id',
                            'loja_id',
                            'nome',
                            'valor',
                            'ativo'
                        ]
                    ]
                ]
            ]);
    }

    public function test_store_se_esta_cadastrando_loja_corretamente()
    {
        $loja = [
            'nome' => $this->faker->company(),
            'email' => $this->faker->email()
        ];

        $this->json('post', 'api/lojas', $loja)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                    "message",
                    "loja" => [
                        "nome",
                        "email",
                        "updated_at",
                        "created_at",
                        "id"]
                ]
            );
    }
}
