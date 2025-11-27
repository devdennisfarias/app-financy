<?php

namespace Database\Seeders;

use App\Models\Proposta;
use Illuminate\Database\Seeder;

class PropostasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proposta::factory()->count(50)->create();
    }
}
