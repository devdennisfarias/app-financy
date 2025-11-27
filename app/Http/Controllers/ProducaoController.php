<?php

namespace App\Http\Controllers;

use App\Models\Proposta;
use App\Models\User;
use Illuminate\Http\Request;

class ProducaoController extends Controller
{
	public function __construct()
	{
		// mesma permissão para as duas telas de produção
		$this->middleware('can:producao.index')->only(['index', 'porUsuario']);
	}

	/**
	 * Produção Geral da FinancyCred
	 * Lista todas as propostas com filtros opcionais.
	 */
	public function index(Request $request)
	{
		$query = Proposta::query();

		// filtros opcionais
		if ($request->filled('data_inicio')) {
			$query->whereDate('created_at', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('created_at', '<=', $request->data_fim);
		}

		if ($request->filled('user_id')) {
			$query->where('user_id', $request->user_id);
		}

		// carrega relações se existirem nos models (ajuste se o nome for diferente)
		$propostas = $query
			->with(['cliente', 'produto', 'user'])
			->latest()
			->paginate(20);

		// lista de usuários para filtro (pode filtrar por "vendedores" depois)
		$usuarios = User::orderBy('name')->get();

		// --- KPIs (produção geral) ---
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			// tipo 4 = Finalizado / Contrato Pago / Comissão Paga
			'aprovadas' => (clone $baseQuery)->where('status_tipo_atual_id', 4)->count(),
			// tipos 1,2,3 = Cadastrada / Em Andamento / Pendenciada / Aguardando Averbação / Integração com Robô
			'pendentes' => (clone $baseQuery)->whereIn('status_tipo_atual_id', [1, 2, 3])->count(),
			// só soma valor das concluídas
			'valor_total' => (clone $baseQuery)->where('status_tipo_atual_id', 4)->sum('valor_liquido_liberado'),
		];

		return view('producao.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'filtros' => $request->only(['data_inicio', 'data_fim', 'user_id']),
			'resumo' => $resumo,
			'activePage' => 'producao-geral',
		]);
	}


	/**
	 * Produção por Usuário
	 * Admin escolhe um usuário/vendedor e vê apenas a produção dele.
	 */
	public function porUsuario(Request $request)
	{
		$usuarios = User::orderBy('name')->get();

		$userId = $request->input('user_id', auth()->id());

		$usuarioSelecionado = $usuarios->firstWhere('id', $userId) ?? $usuarios->first();

		$query = Proposta::where('user_id', $usuarioSelecionado->id);

		if ($request->filled('data_inicio')) {
			$query->whereDate('created_at', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('created_at', '<=', $request->data_fim);
		}

		$propostas = $query
			->with(['cliente', 'produto'])
			->latest()
			->paginate(20);

		// --- KPIs ---
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			'aprovadas' => (clone $baseQuery)->where('status_tipo_atual_id', 4)->count(),
			'pendentes' => (clone $baseQuery)->whereIn('status_tipo_atual_id', [1, 2, 3])->count(),
			'valor_total' => (clone $baseQuery)->where('status_tipo_atual_id', 4)->sum('valor_liquido_liberado'),
		];


		return view('producao.usuario', [
			'usuarios' => $usuarios,
			'usuarioSelecionado' => $usuarioSelecionado,
			'propostas' => $propostas,
			'filtros' => $request->only(['data_inicio', 'data_fim']),
			'resumo' => $resumo,
			'activePage' => 'producao-usuario',
		]);
	}

}
