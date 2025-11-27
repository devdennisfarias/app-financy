<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// nome_da_permissao => [descrição, grupo]
		$permissions = [
			// Dashboard
			'dashboard.view' => [
				'desc' => 'Acessar o dashboard',
				'group' => 'Dashboard',
			],

			// Clientes
			'clientes.index' => [
				'desc' => 'Listar clientes',
				'group' => 'Clientes',
			],
			'clientes.create' => [
				'desc' => 'Criar clientes',
				'group' => 'Clientes',
			],
			'clientes.edit' => [
				'desc' => 'Editar clientes',
				'group' => 'Clientes',
			],
			'clientes.destroy' => [
				'desc' => 'Excluir clientes',
				'group' => 'Clientes',
			],

			// Propostas
			'propostas.index' => [
				'desc' => 'Listar propostas',
				'group' => 'Propostas',
			],
			'propostas.create' => [
				'desc' => 'Criar propostas',
				'group' => 'Propostas',
			],
			'propostas.edit' => [
				'desc' => 'Editar propostas',
				'group' => 'Propostas',
			],
			'propostas.destroy' => [
				'desc' => 'Excluir propostas',
				'group' => 'Propostas',
			],

			// Esteira / fluxo
			'esteira.index' => [
				'desc' => 'Visualizar esteira de propostas',
				'group' => 'Propostas',
			],

			// Propostas / produção por usuário
			'minhas-propostas.index' => [
				'desc' => 'Ver minhas propostas',
				'group' => 'Propostas',
			],
			'minha-producao.index' => [
				'desc' => 'Ver minha produção',
				'group' => 'Produção',
			],

			// Produção geral
			'producao.index' => [
				'desc' => 'Ver produção geral',
				'group' => 'Produção',
			],
			'producao.por-usuario' => [
				'desc' => 'Ver produção por usuário',
				'group' => 'Produção',
			],

			// Carteiras
			'carteiras.index' => [
				'desc' => 'Visualizar carteiras de clientes',
				'group' => 'Carteiras',
			],

			// Produtos
			'produtos.index' => [
				'desc' => 'Listar produtos',
				'group' => 'Produtos',
			],
			'produtos.create' => [
				'desc' => 'Criar produtos',
				'group' => 'Produtos',
			],
			'produtos.edit' => [
				'desc' => 'Editar produtos',
				'group' => 'Produtos',
			],
			'produtos.destroy' => [
				'desc' => 'Excluir produtos',
				'group' => 'Produtos',
			],

			// Tabelas / regras / metas
			'tabelas.index' => [
				'desc' => 'Listar tabelas de comissão',
				'group' => 'Comercial',
			],
			'tabelas.edit' => [
				'desc' => 'Editar tabelas de comissão',
				'group' => 'Comercial',
			],
			'regras.index' => [
				'desc' => 'Listar regras de comissão',
				'group' => 'Comercial',
			],
			'regras.edit' => [
				'desc' => 'Editar regras de comissão',
				'group' => 'Comercial',
			],
			'metas.index' => [
				'desc' => 'Listar metas',
				'group' => 'Comercial',
			],
			'metas.edit' => [
				'desc' => 'Editar metas',
				'group' => 'Comercial',
			],

			// Usuários
			'users.index' => [
				'desc' => 'Listar usuários',
				'group' => 'Administração',
			],
			'users.create' => [
				'desc' => 'Criar usuários',
				'group' => 'Administração',
			],
			'users.edit' => [
				'desc' => 'Editar usuários',
				'group' => 'Administração',
			],
			'users.destroy' => [
				'desc' => 'Excluir usuários',
				'group' => 'Administração',
			],

			// Perfis / Roles
			'roles.index' => [
				'desc' => 'Listar perfis de acesso',
				'group' => 'Administração',
			],
			'roles.create' => [
				'desc' => 'Criar perfis de acesso',
				'group' => 'Administração',
			],
			'roles.edit' => [
				'desc' => 'Editar perfis de acesso',
				'group' => 'Administração',
			],
			'roles.destroy' => [
				'desc' => 'Excluir perfis de acesso',
				'group' => 'Administração',
			],

			// Situações / Status
			'status.index' => [
				'desc' => 'Listar status de propostas',
				'group' => 'Configurações',
			],
			'status.create' => [
				'desc' => 'Criar status de propostas',
				'group' => 'Configurações',
			],
			'status.edit' => [
				'desc' => 'Editar status de propostas',
				'group' => 'Configurações',
			],
			'status.destroy' => [
				'desc' => 'Excluir status de propostas',
				'group' => 'Configurações',
			],
			// FINANCEIRO
			'financeiro.dashboard' => [
				'desc' => 'Acessar dashboard financeiro',
				'group' => 'Financeiro',
			],

			'bancos.index' => [
				'desc' => 'Listar bancos',
				'group' => 'Financeiro',
			],
			'bancos.create' => [
				'desc' => 'Criar bancos',
				'group' => 'Financeiro',
			],
			'bancos.edit' => [
				'desc' => 'Editar bancos',
				'group' => 'Financeiro',
			],
			'bancos.destroy' => [
				'desc' => 'Excluir bancos',
				'group' => 'Financeiro',
			],

			'contas-bancarias.index' => [
				'desc' => 'Listar contas bancárias',
				'group' => 'Financeiro',
			],
			'contas-bancarias.create' => [
				'desc' => 'Criar contas bancárias',
				'group' => 'Financeiro',
			],
			'contas-bancarias.edit' => [
				'desc' => 'Editar contas bancárias',
				'group' => 'Financeiro',
			],
			'contas-bancarias.destroy' => [
				'desc' => 'Excluir contas bancárias',
				'group' => 'Financeiro',
			],

			'lancamentos.index' => [
				'desc' => 'Listar lançamentos financeiros',
				'group' => 'Financeiro',
			],
			'lancamentos.create' => [
				'desc' => 'Criar lançamentos financeiros',
				'group' => 'Financeiro',
			],
			'lancamentos.edit' => [
				'desc' => 'Editar lançamentos financeiros',
				'group' => 'Financeiro',
			],
			'lancamentos.destroy' => [
				'desc' => 'Excluir lançamentos financeiros',
				'group' => 'Financeiro',
			],

			'financeiro.relatorios' => [
				'desc' => 'Acessar relatórios financeiros',
				'group' => 'Financeiro',
			],

		];

		foreach ($permissions as $name => $data) {
			Permission::updateOrCreate(
				['name' => $name, 'guard_name' => 'web'],
				[
					'description' => $data['desc'],
					'group' => $data['group'],
				]
			);
		}
	}


}
