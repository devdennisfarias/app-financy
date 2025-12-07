<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcessosExternosSeeder extends Seeder
{
	public function run()
	{
		DB::table('acessos_externos')->insert([
			[
				'link' => 'https://correspondente.caixa.gov.br',
				'nome' => 'Caixa Econômica Federal',
				'observacao' => 'Portal correspondente',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://corban.bancobmg.com.br',
				'nome' => 'Banco BMG',
				'observacao' => 'Plataforma consignado',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://parceiros.sabemi.com.br',
				'nome' => 'Sabemi',
				'observacao' => 'Refim e convênios',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://interpromotora.com.br',
				'nome' => 'Banco Inter',
				'observacao' => 'Acesso web',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://corban.pan.com.br',
				'nome' => 'Banco PAN',
				'observacao' => 'Acesso consignado',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://corban.digimais.com.br',
				'nome' => 'Digimais',
				'observacao' => 'Correspondente bancário',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://c6.c6consig.com.br/WebAutorizador/Login/AC.UI.LOGIN.aspx',
				'nome' => 'C6 Consig',
				'observacao' => '',
				'usuario' => '88402290272_002825',
				'senha' => 'Financy1709@',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://simulador.incontatdigital.com.br/login',
				'nome' => 'BRB Incota',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://correspondente.bb.com.br',
				'nome' => 'Banco do Brasil',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://creditmanager.bancopaulista.com.br',
				'nome' => 'Banco Paulista',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://app.v8sistema.com/signin',
				'nome' => 'Banco V8',
				'observacao' => '',
				'usuario' => 'vamoma17@gmail.com',
				'senha' => 'Vane884@',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://www.parceirosantander.com.br',
				'nome' => 'Banco Santander',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://www2.bancomercantil.com.br',
				'nome' => 'Banco Mercantil',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'link' => 'https://app.finantobank.com.br',
				'nome' => 'Finanto',
				'observacao' => '',
				'usuario' => '?',
				'senha' => '?',
				'created_at' => now(),
				'updated_at' => now(),
			],
		]);
	}
}
