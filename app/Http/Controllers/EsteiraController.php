<?php

namespace App\Http\Controllers;

use App\Models\Proposta;
use App\Models\User;
use App\Models\Produto;
use App\Models\Status;
use Illuminate\Http\Request;

class EsteiraController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:esteira.index')->only(['index']);
	}

	/**
	 * Lista de propostas na esteira.
	 *
	 * Regra atual:
	 * - Mostra todas as propostas que NÃO estejam em status final
	 *   (Paga, Concluída, Cancelada).
	 * - Se esses status não existirem no banco, nenhuma exclusão é feita e
	 *   TODAS as propostas aparecem na esteira.
	 */
	public function index(Request $request)
	{
		// Filtros vindos da request
		$filtros = $request->only([
			'data_inicio',
			'data_fim',
			'user_id',
			'produto',
			'banco',
			'cpf',
			'nome',
			'status_atual_id',
		]);

		// Listas auxiliares para selects
		$usuarios = User::orderBy('name')->get();
		$produtos = Produto::orderBy('produto')->get();
		$statusAll = Status::orderBy('status')->get();

		// Status que consideramos "finais" (não aparecem na esteira)
		// Ajuste os nomes conforme sua realidade.
		$nomesStatusFinais = [
			'Paga',
			'PAGO',
			'Paga / Concluída',
			'Concluída',
			'Concluida',
			'Cancelada',
			'Cancelado',
		];

		$statusFinaisIds = Status::whereIn('status', $nomesStatusFinais)->pluck('id')->all();

		// Query base
		$query = Proposta::query()
			->with([
				'cliente',
				'produto',
				'banco',
				'status_atual',
				'user',
			]);

		// Regra da esteira:
		// - se encontrarmos algum status final, removemos da listagem
		if (!empty($statusFinaisIds)) {
			$query->whereNotIn('status_atual_id', $statusFinaisIds);
		}

		// FILTROS

		// Período
		if (!empty($filtros['data_inicio'])) {
			$query->whereDate('created_at', '>=', $filtros['data_inicio']);
		}

		if (!empty($filtros['data_fim'])) {
			$query->whereDate('created_at', '<=', $filtros['data_fim']);
		}

		// Usuário
		if (!empty($filtros['user_id'])) {
			$query->where('user_id', $filtros['user_id']);
		}

		// Produto
		if (!empty($filtros['produto'])) {
			$query->where('produto_id', $filtros['produto']);
		}

		// Banco (texto livre)
		if (!empty($filtros['banco'])) {
			$query->where('banco', 'like', '%' . $filtros['banco'] . '%');
		}

		// CPF
		if (!empty($filtros['cpf'])) {
			$cpf = preg_replace('/\D/', '', $filtros['cpf']);
			$query->whereHas('cliente', function ($q) use ($cpf) {
				$q->whereRaw('REPLACE(REPLACE(REPLACE(cpf, ".", ""), "-", ""), " ", "") = ?', [$cpf]);
			});
		}

		// Nome
		if (!empty($filtros['nome'])) {
			$nome = $filtros['nome'];
			$query->whereHas('cliente', function ($q) use ($nome) {
				$q->where('nome', 'like', '%' . $nome . '%');
			});
		}

		// Filtro por status específico (combo de status na tela)
		if (!empty($filtros['status_atual_id'])) {
			$query->where('status_atual_id', $filtros['status_atual_id']);
		}

		// Paginação
		$propostas = $query
			->orderByDesc('created_at')
			->paginate(20)
			->appends($filtros);

		// KPIs (em cima da mesma query da esteira)
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			'aprovadas' => 0, // podemos refinar depois com status específicos de aprovação
			'pendentes' => (clone $baseQuery)->count(),
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		return view('esteira.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'produtos' => $produtos,
			'statusAll' => $statusAll,
			'filtros' => $filtros,
			'resumo' => $resumo,
			'activePage' => 'esteira',
		]);
	}
}
