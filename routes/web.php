<?php

use App\Http\Controllers\AcessoExternoController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaBancariaController;
use App\Http\Controllers\DashboardFinanceiroController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\LancamentoFinanceiroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EsteiraController;
use App\Http\Controllers\PropostaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProducaoController;
use App\Http\Controllers\TabelaController;
use App\Http\Controllers\RegraController;
use App\Http\Controllers\MetaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
	return view('auth.login');
});
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});


Route::group(['middleware' => 'auth'], function () {

	/* INICIO ROTAS DE USUÁRIOS */
	Route::resource('users', UserController::class)->names('users');
	Route::get('perfil/edit', ['as' => 'perfil.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('perfil/update', ['as' => 'perfil.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('perfil/password', ['as' => 'perfil.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('lista-vendedores/{id}', [UserController::class, 'getVendedores']);
	/* FIM ROTAS DE USUÁRIOS */

	/* INICIO ROTAS DE CLIENTES */
	Route::resource('clientes', ClienteController::class)->names('clientes');
	/* FIM ROTAS DE CLIENTES */

	/* INICIO ROTAS DE PRODUTOS */
	Route::resource('produtos', ProdutoController::class)->names('produtos');
	/* FIM ROTAS DE PRODUTOS */

	/* INICIO ROTAS DE PRODUÇÃO */
	Route::resource('producao', ProducaoController::class)->names('producao');

	// Produção por usuário (novo módulo)
	Route::get('producao-usuario', [ProducaoController::class, 'porUsuario'])->name('producao.usuario');
	/* FIM ROTAS DE PRODUÇÃO */

	/* INICIO ROTAS DE ESTEIRA */
	Route::resource('esteira', EsteiraController::class)->names('esteira');
	/* FIM ROTAS DE ESTEIRA */

	/* INICIO ROTAS DE ATENDIMENTO */
	Route::get('atendimentos/{id}', [AtendimentoController::class, 'show'])->name('atendimentos.index');
	Route::post('atendimentos/{id}/atender', [AtendimentoController::class, 'store'])->name('atendimentos.store');
	/* FIM ROTAS DE ATENDIMENTO */

	/* INICIO ROTAS DE PROPOSTAS */
	Route::resource('propostas', PropostaController::class)->names('propostas');
	Route::get('consulta-cpf', [PropostaController::class, 'consultaCpf'])->name('propostas.consulta-cpf');
	Route::delete('proposta-doc/{id}/deletar', [PropostaController::class, 'deletarDoc'])->name('proposta.deletar-doc');
	/* FIM ROTAS DE PROPOSTAS */

	/* INICIO ROTAS DE CARTEIRAS */
	Route::resource('carteiras', CarteiraController::class)->names('carteiras');
	/* FIM ROTAS DE CARTEIRAS */

	/* INICIO ROTAS DE  PROPOSTAS POR USUARIOS*/
	Route::get('propostas-usuario', [PropostaController::class, 'porUsuario'])->name('propostas.usuario');

	/* FIM ROTAS DE PROPOSTAS */

	/* INICIO ROTAS DE TABELA COMISSÕES */
	Route::resource('tabelas', TabelaController::class)->names('tabelas');
	/* FIM ROTAS DE TABELA COMISSÕES */

	/* INICIO ROTAS DE REGRA COMISSÕES */
	Route::resource('regras', RegraController::class)->names('regras');
	/* FIM ROTAS DE REGRA COMISSÕES */

	/* INICIO ROTAS DE PDF'S */
	Route::get('pdf/{id}/cliente', [PdfController::class, 'geraPdfCliente'])->name('cliente.pdf');
	Route::get('pdf/{id}/proposta', [PdfController::class, 'geraPdfProposta'])->name('proposta.pdf');
	/* FIM ROTAS DE PDF'S */

	/* INICIO ROTAS DE ROLES */
	Route::resource('roles', RoleController::class)->names('roles');
	/* FIM ROTAS DE ROLES */

	/* INICIO ROTAS DE STATUS */
	Route::resource('status', StatusController::class)->names('status');
	/* FIM ROTAS DE STATUS */

	// DASHBOARD FINANCEIRO
	Route::get('financeiro', [DashboardFinanceiroController::class, 'index'])->name('financeiro.dashboard')->middleware('can:financeiro.dashboard');

	// BANCOS
	Route::resource('bancos', BancoController::class)->middleware('can:bancos.index');

	// CONTAS BANCÁRIAS
	Route::resource('contas-bancarias', ContaBancariaController::class)->middleware('can:contas-bancarias.index');

	// LANÇAMENTOS (CRUD)
	Route::resource('lancamentos', LancamentoFinanceiroController::class)->middleware('can:lancamentos.index');

	// CONTAS A PAGAR / RECEBER
	Route::get('financeiro/contas-a-pagar', [LancamentoFinanceiroController::class, 'contasPagar'])->name('financeiro.contas-pagar')->middleware('can:lancamentos.index');

	Route::get('financeiro/contas-a-receber', [LancamentoFinanceiroController::class, 'contasReceber'])->name('financeiro.contas-receber')->middleware('can:lancamentos.index');

	Route::get('financeiro/relatorios', [DashboardFinanceiroController::class, 'relatorios'])->name('financeiro.relatorios')->middleware('can:financeiro.relatorios');

	Route::resource('fornecedores', FornecedorController::class);

	Route::get('financeiro/receitas', [LancamentoFinanceiroController::class, 'receitas'])->name('financeiro.receitas');

	Route::get('financeiro/despesas', [LancamentoFinanceiroController::class, 'despesas'])->name('financeiro.despesas');

	Route::get('financeiro/movimentacao-bancaria', [LancamentoFinanceiroController::class, 'movimentacao'])->name('financeiro.movimentacao')->middleware('can:lancamentos.index');

	// ACESSOS EXTERNOS
	Route::resource('acessos-externos', AcessoExternoController::class)->except(['show']);


});


