<?php

use App\Http\Controllers\{
	ClienteController,
	PerfilController,
	ProfileController,
	UserController,
	HomeController,
	ProdutoController,
	ProducaoController,
	PropostaController,
	ComissaoController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('auth.login');
});

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

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
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'perfil.editar', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'perfil.atualizar', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'perfil.senha', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('clientes', [ClienteController::class, 'index']);
Route::get('editar-clientes',  [ClienteController::class, 'edit'])->name('editar.clientes');

Route::resource('produtos', [ProdutoController::class, 'index']);

Route::resource('controle-de-producao', ProducaoController::class);
Route::get('controle-de-producao', [ProducaoController::class, 'index'])->name('producao');
Route::get('esteira', [ProducaoController::class, 'esteira'])->name('esteira.producao');

Route::resource('propostas', PropostaController::class);
Route::get('propostas', [PropostaController::class, 'index'])->name('propostas');

Route::resource('carteira', [ClienteController::class, 'carteira']);
Route::get('carteira', [ClienteController::class, 'carteira'])->name('carteira.clientes');


Route::get('editar-perfil',  [PerfilController::class, 'edit'])->name('editar.perfil');
Route::get('update-perfil',  [PerfilController::class, 'update'])->name('atualizar.perfil');

Route::resource('comissoes', ComissaoController::class);
Route::get('metas',  [ComissaoController::class, 'metas'])->name('comissoes.metas');
Route::get('regras-de-comissao',  [ComissaoController::class, 'regras'])->name('comissoes.regras');
Route::get('tabela-de-comissao',  [ComissaoController::class, 'tabelas'])->name('comissoes.tabelas');
