<?php

namespace Database\Seeders;

use App\Models\Loja;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        ///padrão
        DB::table('lojas')->insert([
            'nome' => 'MegaLu',
            'email' => 'email@email.com'
        ]);

        DB::table('produtos')->insert([
            'nome' => 'Placa de Vídeo',
            'loja_id' => Loja::all()->first()->id,
            'valor' => 5000,
            'ativo' => true
        ]);

        //faker
        Loja::factory(10)
            ->has(Produto::factory()->count(30)
        )->create();
    }
}
