<?php

namespace App\Http\Controllers;

use App\Models\Proposta;
use App\Models\User;
use App\Models\Produto;
use App\Models\Status;
use App\Models\Convenio;
use App\Models\Orgao;
use Illuminate\Http\Request;

class EsteiraController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:propostas.index')->only(['index']);
	}

	public function index(Request $request)
	{
		// -----------------------------------
		// LISTAS PARA FILTROS
		// -----------------------------------
		$usuarios = User::orderBy('name')->get();
		$produtos = Produto::orderBy('produto')->get();
		$statusList = Status::orderBy('status')->get();

		// Estas listas já ficam prontas para quando você ativar totalmente no cliente
		$convenios = class_exists(Convenio::class)
			? Convenio::orderBy('nome')->get()
			: collect();

		$orgaos = class_exists(Orgao::class)
			? Orgao::orderBy('nome')->get()
			: collect();

		// -----------------------------------
		// BASE DA ESTEIRA
		// Regra:
		// - ENTRA: tudo que NÃO for finalizado
		// - SAI: Pago, Cancelado, Concluído
		// -----------------------------------
		$query = Proposta::with([
			'cliente.orgao.convenio',
			'produto',
			'user',
			'status_atual'
		])
			->whereHas('status_atual', function ($q) {
				$q->whereNotIn('status', [
					'Pago',
					'Cancelado',
					'Concluído',
					'Concluida',
				]);
			})
			->orderByDesc('created_at');

		// -----------------------------------
		// FILTROS
		// -----------------------------------

		if ($request->filled('data_inicio')) {
			$query->whereDate('created_at', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('created_at', '<=', $request->data_fim);
		}

		if ($request->filled('user_id')) {
			$query->where('user_id', $request->user_id);
		}

		if ($request->filled('produto')) {
			$query->where('produto_id', $request->produto);
		}

		if ($request->filled('banco')) {
			$query->where('banco', 'like', '%' . $request->banco . '%');
		}

		if ($request->filled('cpf')) {
			$cpf = preg_replace('/\D/', '', $request->cpf);

			$query->whereHas('cliente', function ($q) use ($cpf) {
				$q->where('cpf', 'like', '%' . $cpf . '%');
			});
		}

		if ($request->filled('nome')) {
			$nome = $request->nome;

			$query->whereHas('cliente', function ($q) use ($nome) {
				$q->where('nome', 'like', '%' . $nome . '%');
			});
		}

		// 🔹 Filtro por STATUS
		if ($request->filled('status_atual_id')) {
			$query->where('status_atual_id', $request->status_atual_id);
		}

		// 🔹 Filtro por CONVÊNIO (quando ativar total no cliente)
		if ($request->filled('convenio_id')) {
			$convenioId = $request->convenio_id;

			$query->whereHas('cliente.orgao.convenio', function ($q) use ($convenioId) {
				$q->where('id', $convenioId);
			});
		}

		// 🔹 Filtro por ÓRGÃO (quando ativar total no cliente)
		if ($request->filled('orgao_id')) {
			$orgaoId = $request->orgao_id;

			$query->whereHas('cliente.orgao', function ($q) use ($orgaoId) {
				$q->where('id', $orgaoId);
			});
		}

		// -----------------------------------
		// RESULTADO FINAL
		// -----------------------------------
		$propostas = $query->paginate(30);

		// -----------------------------------
		// KPIs
		// -----------------------------------
		$baseQuery = clone $query;

		$aprovadas = (clone $baseQuery)->whereHas('status_atual', function ($q) {
			$q->where('status', 'like', 'Aprov%');
		})->count();

		$total = (clone $baseQuery)->count();

		$resumo = [
			'total' => $total,
			'aprovadas' => $aprovadas,
			'pendentes' => $total - $aprovadas,
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		// -----------------------------------
		// FILTROS ATUAIS (PARA PAGINAÇÃO)
		// -----------------------------------
		$filtros = $request->only([
			'data_inicio',
			'data_fim',
			'user_id',
			'produto',
			'banco',
			'cpf',
			'nome',
			'status_atual_id',
			'convenio_id',
			'orgao_id',
		]);

		// -----------------------------------
		// RETORNO
		// -----------------------------------
		return view('esteira.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'produtos' => $produtos,
			'statusList' => $statusList,
			'convenios' => $convenios,
			'orgaos' => $orgaos,
			'resumo' => $resumo,
			'filtros' => $filtros,
			'activePage' => 'esteira',
		]);
	}
}
