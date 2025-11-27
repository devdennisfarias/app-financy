<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		// Busca todas as permissões
		$allPermissions = Permission::all();

		// Helper pra buscar coleção de permissões por nome
		$getPerms = function (array $names) use ($allPermissions) {
			return $allPermissions->whereIn('name', $names);
		};

		// ===== Admin – tudo liberado =====
		$adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
		$adminRole->syncPermissions($allPermissions);

		// ===== Comercial =====
		$comercialPermissions = $getPerms([
			'dashboard.view',
			'clientes.index',
			'clientes.create',
			'clientes.edit',
			'propostas.index',
			'propostas.create',
			'propostas.edit',
			'minhas-propostas.index',
			'minha-producao.index',
			'esteira.index',
		]);
		$comercialRole = Role::firstOrCreate(['name' => 'Comercial', 'guard_name' => 'web']);
		$comercialRole->syncPermissions($comercialPermissions);

		// ===== Financeiro =====
		$financeiroPermissions = $getPerms([
			'financeiro.dashboard',
			'bancos.index',
			'bancos.create',
			'bancos.edit',
			'contas-bancarias.index',
			'contas-bancarias.create',
			'contas-bancarias.edit',
			'lancamentos.index',
			'lancamentos.create',
			'lancamentos.edit',
			'financeiro.relatorios',
			'dashboard.view',
			'producao.index',
			'producao.por-usuario',
			'propostas.index',
			'minhas-propostas.index',
			'carteiras.index',
			'tabelas.index',
			'tabelas.edit',
			'regras.index',
			'regras.edit',
			'metas.index',
			'metas.edit',
		]);
		$financeiroRole = Role::firstOrCreate(['name' => 'Financeiro', 'guard_name' => 'web']);
		$financeiroRole->syncPermissions($financeiroPermissions);

		// ===== Marketing =====
		$marketingPermissions = $getPerms([
			'dashboard.view',
			'clientes.index',
			'propostas.index',
			'minhas-propostas.index',
		]);
		$marketingRole = Role::firstOrCreate(['name' => 'Marketing', 'guard_name' => 'web']);
		$marketingRole->syncPermissions($marketingPermissions);

		// ===== Suporte =====
		$suportePermissions = $getPerms([
			'dashboard.view',
			'users.index',
			'users.create',
			'users.edit',
			'roles.index',
			'roles.create',
			'roles.edit',
			'status.index',
			'status.edit',
			'produtos.index',
		]);
		$suporteRole = Role::firstOrCreate(['name' => 'Suporte', 'guard_name' => 'web']);
		$suporteRole->syncPermissions($suportePermissions);
	}

}
