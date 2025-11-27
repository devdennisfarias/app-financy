<?php

namespace Database\Seeders;

use App\Models\Atendimento;
use Illuminate\Database\Seeder;

class AtendimentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Atendimento::factory()->count(5)->create();
    }
}
