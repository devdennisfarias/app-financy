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
		$this->middleware('can:esteira.index')->only('index');
	}

	public function index(Request $request)
	{
		// Filtros vindos da tela
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

		// Garante que todas as chaves existam
		$filtros['data_inicio'] = $filtros['data_inicio'] ?? null;
		$filtros['data_fim'] = $filtros['data_fim'] ?? null;
		$filtros['user_id'] = $filtros['user_id'] ?? null;
		$filtros['produto'] = $filtros['produto'] ?? null;
		$filtros['banco'] = $filtros['banco'] ?? null;
		$filtros['cpf'] = $filtros['cpf'] ?? null;
		$filtros['nome'] = $filtros['nome'] ?? null;
		$filtros['status_atual_id'] = $filtros['status_atual_id'] ?? null;
		$filtros['convenio_id'] = $filtros['convenio_id'] ?? null;
		$filtros['orgao_id'] = $filtros['orgao_id'] ?? null;

		// Listas auxiliares para filtros
		$usuarios = User::orderBy('name')->get();
		$produtos = Produto::orderBy('produto')->get();
		$statusList = Status::orderBy('status')->get();
		$convenios = Convenio::orderBy('nome')->get();
		$orgaos = Orgao::with('convenio')->orderBy('nome')->get();

		// Query base da Esteira
		$query = Proposta::with([
			'cliente.orgao.convenio',
			'produto',
			'user',
			'status_atual',
		]);

		// Regras de negócio da ESTEIRA:
		// Aqui você decide "quem entra" na Esteira.
		// Exemplo: somente status "Cadastrada", "Em análise", etc.
		// Se quiser, pode comentar este whereIn e mostrar tudo.
		$query->whereHas('status_atual', function ($q) {
			$q->whereIn('slug', [
				'cadastrada',
				'em-analise',
				'em-processamento',
				'aguardando-documentacao',
			])->orWhereNull('slug'); // fallback se não tiver slug
		});

		// Filtro por data de criação
		if (!empty($filtros['data_inicio'])) {
			$query->whereDate('created_at', '>=', $filtros['data_inicio']);
		}

		if (!empty($filtros['data_fim'])) {
			$query->whereDate('created_at', '<=', $filtros['data_fim']);
		}

		// Filtro por usuário (vendedor)
		if (!empty($filtros['user_id'])) {
			$query->where('user_id', $filtros['user_id']);
		}

		// Filtro por produto
		if (!empty($filtros['produto'])) {
			$query->where('produto_id', $filtros['produto']);
		}

		// Filtro por banco (texto livre)
		if (!empty($filtros['banco'])) {
			$query->where('banco', 'like', '%' . $filtros['banco'] . '%');
		}

		// Filtro por CPF (cliente)
		if (!empty($filtros['cpf'])) {
			$cpf = preg_replace('/\D/', '', $filtros['cpf']); // só números
			$query->whereHas('cliente', function ($q) use ($cpf) {
				$q->whereRaw('REPLACE(REPLACE(REPLACE(cpf, ".", ""), "-", ""), " ", "") LIKE ?', ["%{$cpf}%"]);
			});
		}

		// Filtro por Nome (cliente)
		if (!empty($filtros['nome'])) {
			$nome = $filtros['nome'];
			$query->whereHas('cliente', function ($q) use ($nome) {
				$q->where('nome', 'like', "%{$nome}%");
			});
		}

		// Filtro por STATUS ATUAL (id)
		if (!empty($filtros['status_atual_id'])) {
			$query->where('status_atual_id', $filtros['status_atual_id']);
		}

		// Filtro por CONVÊNIO (via cliente -> orgao -> convenio)
		if (!empty($filtros['convenio_id'])) {
			$convenioId = $filtros['convenio_id'];
			$query->whereHas('cliente.orgao', function ($q) use ($convenioId) {
				$q->where('convenio_id', $convenioId);
			});
		}

		// Filtro por ÓRGÃO PAGADOR (cliente.orgao_id)
		if (!empty($filtros['orgao_id'])) {
			$orgaoId = $filtros['orgao_id'];
			$query->whereHas('cliente', function ($q) use ($orgaoId) {
				$q->where('orgao_id', $orgaoId);
			});
		}

		// Resultado paginado
		$propostas = $query
			->orderByDesc('created_at')
			->paginate(30);

		// KPIs simples
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			// aqui você pode ajustar ids ou slugs de aprovadas/pendentes
			'aprovadas' => (clone $baseQuery)->whereHas('status_atual', function ($q) {
				$q->where('slug', 'aprovada')->orWhere('status', 'like', '%Aprovada%');
			})->count(),
			'pendentes' => (clone $baseQuery)->whereHas('status_atual', function ($q) {
				$q->whereIn('slug', ['cadastrada', 'em-analise', 'em-processamento']);
			})->count(),
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		return view('esteira.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'produtos' => $produtos,
			'statusList' => $statusList,
			'convenios' => $convenios,
			'orgaos' => $orgaos,
			'filtros' => $filtros,
			'resumo' => $resumo,
			'activePage' => 'esteira',
		]);
	}
}
