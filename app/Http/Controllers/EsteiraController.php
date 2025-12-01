<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Proposta;
use App\Models\StatusTipo;
use App\Models\User;
use Illuminate\Http\Request;

class EsteiraController extends Controller
{
	public function __construct()
	{
		// você pode usar 'producao.index' ou criar 'esteira.index' se quiser ser mais granular
		$this->middleware('can:producao.index')->only('index');
	}

	/**
	 * Esteira de Propostas (pipeline)
	 */
	public function index(Request $request)
	{
		$query = Proposta::query();

		// Usuários (para filtro)
		$usuarios = User::orderBy('name')->get();

		// Status tipos (para filtro de etapa da esteira)
		$statusTipos = StatusTipo::orderBy('id')->get();

		// Query base

		$produtos = Produto::orderBy('id')->get();


		// ===== FILTROS =====

		// Data de criação
		if ($request->filled('data_inicio')) {
			$query->whereDate('created_at', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('created_at', '<=', $request->data_fim);
		}

		// Usuário
		if ($request->filled('user_id')) {
			$query->where('user_id', $request->user_id);
		}

		if ($request->filled('produto')) {
			$query->where('produto_id', $request->produto);
		}


		// Órgão
		if ($request->filled('orgao')) {
			$query->where('orgao', 'like', '%' . $request->orgao . '%');
		}

		// Banco
		if ($request->filled('banco')) {
			$query->where('banco', 'like', '%' . $request->banco . '%');
		}

		// CPF do cliente
		if ($request->filled('cpf')) {
			$cpf = preg_replace('/\D/', '', $request->cpf); // só números
			$query->whereHas('cliente', function ($q) use ($cpf) {
				$q->where('cpf', 'like', '%' . $cpf . '%');
			});
		}

		// Nome do cliente
		if ($request->filled('nome')) {
			$nome = $request->nome;
			$query->whereHas('cliente', function ($q) use ($nome) {
				$q->where('nome', 'like', '%' . $nome . '%');
			});
		}

		// Status da esteira (status_tipo_atual_id)
		if ($request->filled('status_tipo_atual_id')) {
			$query->where('status_tipo_atual_id', $request->status_tipo_atual_id);
		}

		// ===== CARREGA PROPOSTAS (planilha) =====
		$propostas = $query
			->with(['cliente', 'produto', 'user'])
			->orderByDesc('created_at')
			->paginate(30);

		// ===== RESUMO (KPIs simples) =====
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			// ajusta condições de aprovado/pendente conforme sua regra
			'aprovadas' => (clone $baseQuery)->where('status_tipo_atual_id', 4)->count(),
			'pendentes' => (clone $baseQuery)->whereIn('status_tipo_atual_id', [1, 2, 3])->count(),
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		// Filtros para reaproveitar na view
		$filtros = $request->only([
			'data_inicio',
			'data_fim',
			'user_id',
			'produto',
			'orgao',
			'banco',
			'cpf',
			'nome',
			'status_tipo_atual_id',
		]);

		return view('esteira.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'statusTipos' => $statusTipos,
			'produtos' => $produtos,
			'filtros' => $filtros,
			'resumo' => $resumo,
			'activePage' => 'esteira',
		]);
	}

}
