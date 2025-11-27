<?php

namespace Database\Seeders;

use App\Models\Tabela;
use Illuminate\Database\Seeder;

class TabelaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tabela::create([
            'cod' => '10',
            'nome' => 'Tabela Normal',
            'prazo' => 'prazoteste',
            'coeficiente' => 'coeficienteteste',
            'taxa' => 'taxateste',
            'vigencia' => 'vigenciateste',     
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Tabela::create([
            'cod' => '20',
            'nome' => 'Tabela abaixo de 1k',
            'prazo' => 'prazoteste',
            'coeficiente' => 'coeficienteteste',
            'taxa' => 'taxateste',
            'vigencia' => 'vigenciateste',     
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Tabela::create([
            'cod' => '30',
            'nome' => 'Tabela flex 1',
            'prazo' => 'prazoteste',
            'coeficiente' => 'coeficienteteste',
            'taxa' => 'taxateste',
            'vigencia' => 'vigenciateste',     
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Tabela::create([
            'cod' => '40',
            'nome' => 'Tabela flex 2',
            'prazo' => 'prazoteste',
            'coeficiente' => 'coeficienteteste',
            'taxa' => 'taxateste',
            'vigencia' => 'vigenciateste',     
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
