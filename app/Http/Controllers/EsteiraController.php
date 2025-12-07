<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Proposta;
use App\Models\Status;
use App\Models\User;
use App\Models\Produto;
use Illuminate\Http\Request;

class EsteiraController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:propostas.index')->only(['index']);
	}

	public function index(Request $request)
	{
		$usuarios = User::orderBy('name')->get();
		$produtos = Produto::orderBy('produto')->get();
		$convenios = Convenio::where('ativo', true)->orderBy('nome')->get();
		$statusList = Status::orderBy('status')->get();

		$query = Proposta::with(['cliente.convenio', 'produto', 'user', 'status_atual'])
			->whereHas('status_atual', function ($q) {
				$q->whereNotIn('status', [
					'Pago',
					'Cancelado',
					'Concluído',
					'Concluída',
				]);
			})
			->orderByDesc('created_at');

		// Filtros já existentes...
		if ($request->filled('data_inicio')) {
			$query->whereDate('created_at', '>=', $request->input('data_inicio'));
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('created_at', '<=', $request->input('data_fim'));
		}

		if ($request->filled('user_id')) {
			$query->where('user_id', $request->input('user_id'));
		}

		if ($request->filled('produto')) {
			$query->where('produto_id', $request->input('produto'));
		}

		if ($request->filled('banco')) {
			$query->where('banco', 'like', '%' . $request->input('banco') . '%');
		}

		if ($request->filled('cpf')) {
			$cpf = preg_replace('/\D/', '', $request->input('cpf'));
			$query->whereHas('cliente', function ($q) use ($cpf) {
				$q->where('cpf', 'like', '%' . $cpf . '%');
			});
		}

		if ($request->filled('nome')) {
			$nome = $request->input('nome');
			$query->whereHas('cliente', function ($q) use ($nome) {
				$q->where('nome', 'like', '%' . $nome . '%');
			});
		}

		// 🔹 Filtro por STATUS
		if ($request->filled('status_atual_id')) {
			$query->where('status_atual_id', $request->input('status_atual_id'));
		}

		// 🔹 Filtro por CONVÊNIO
		if ($request->filled('convenio_id')) {
			$convenioId = $request->input('convenio_id');
			$query->whereHas('cliente', function ($q) use ($convenioId) {
				$q->where('convenio_id', $convenioId);
			});
		}

		$propostas = $query->paginate(30);

		// KPIs (mantém a mesma lógica)
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			'aprovadas' => (clone $baseQuery)->whereHas('status_atual', function ($q) {
				$q->where('status', 'like', 'Aprov%');
			})->count(),
			'pendentes' => 0,
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		$resumo['pendentes'] = $resumo['total'] - $resumo['aprovadas'];

		$filtros = $request->only([
			'data_inicio',
			'data_fim',
			'user_id',
			'produto',
			'banco',
			'cpf',
			'nome',
			'convenio_id',
			'status_atual_id',
		]);

		return view('esteira.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'produtos' => $produtos,
			'convenios' => $convenios,
			'statusList' => $statusList,
			'resumo' => $resumo,
			'filtros' => $filtros,
			'activePage' => 'esteira',
		]);
	}
}
