<?php
namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(): void
	{
		$this->call([
			PermissionTableSeeder::class,
			RolesTableSeeder::class,
			UsersTableSeeder::class,

			StatusTiposTableSeeder::class,
			StatusTableSeeder::class,

			BancosTableSeeder::class,
			ProdutoTableSeeder::class,
			TabelaTableSeeder::class,
		]);
	}


}
