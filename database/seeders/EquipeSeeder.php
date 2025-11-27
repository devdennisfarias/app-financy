<?php

namespace Database\Seeders;

use App\Models\Equipe;
use Illuminate\Database\Seeder;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipe::create([
            'equipe' => 'Equipe 1',
            'loja_id' => 1,            
        ]);
    }
}
