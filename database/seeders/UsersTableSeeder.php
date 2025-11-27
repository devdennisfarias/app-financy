<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Super Admin
		$superAdmin = User::updateOrCreate(
			['email' => 'superadmin@financycred.com.br'],
			[
				'name' => 'Super Admin',
				'email_verified_at' => now(),
				'password' => Hash::make('infoNegocio@2015#_'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$superAdmin->assignRole('Admin');

		// Admin
		$admin = User::updateOrCreate(
			['email' => 'adm@financycred.com.br'],
			[
				'name' => 'Administrador',
				'email_verified_at' => now(),
				'password' => Hash::make('Senha@2025@$'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$admin->assignRole('Admin');

		// Financeiro
		$financeiro = User::updateOrCreate(
			['email' => 'financeiro@financycred.com.br'],
			[
				'name' => 'Financeiro',
				'email_verified_at' => now(),
				'password' => Hash::make('Senha@2025@$'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$financeiro->assignRole('Financeiro');

		// Comercial
		$comercial = User::updateOrCreate(
			['email' => 'comercial@financycred.com.br'],
			[
				'name' => 'Comercial',
				'email_verified_at' => now(),
				'password' => Hash::make('Senha@2025@$'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$comercial->assignRole('Comercial');

		// Marketing
		$marketing = User::updateOrCreate(
			['email' => 'mkt@financycred.com.br'],
			[
				'name' => 'Marketing',
				'email_verified_at' => now(),
				'password' => Hash::make('Senha@2025@$'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$marketing->assignRole('Marketing');

		// Suporte
		$suporte = User::updateOrCreate(
			['email' => 'suporte@financycred.com.br'],
			[
				'name' => 'Suporte',
				'email_verified_at' => now(),
				'password' => Hash::make('Senha@2025@$'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
		$suporte->assignRole('Suporte');
	}

}
