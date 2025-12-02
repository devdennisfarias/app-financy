<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Banco;
use App\Models\Proposta;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Produto;
use App\Models\User;
use App\Models\Comissao;
use App\Models\Promotora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PropostaController extends Controller
{

	public function __construct()
	{
		$this->middleware('can:propostas.index')->only(['index', 'porUsuario']);
		$this->middleware('can:propostas.create')->only(['create', 'store']);
		$this->middleware('can:propostas.edit')->only(['edit', 'update']);
		$this->middleware('can:propostas.destroy')->only(['destroy']);
	}

	public function index(Request $request)
	{
		// A listagem de "Todas as Propostas" será controlada pelo componente Livewire
		// @livewire('propostas-index'), então aqui só retornamos a view.

		return view('propostas.index', [
			'activePage' => 'propostas',
			'titlePage' => 'Lista de propostas',
		]);
	}

	public function create()
	{
		$produtos = Produto::with('instituicao')
			->orderBy('produto')
			->get();

		$instituicoes = Banco::orderBy('nome')->get();

		// ... se você já manda outras coisas (clientes, users, etc.), mantém

		return view('propostas.create', compact(
			'produtos',
			'instituicoes',
			// ... outros dados
		));
	}


	public function store(Request $request)
	{
		$dados = $request->validate([
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			// ... resto dos campos da proposta (cliente, valor, etc.)
		]);

		// Se banco/instituição não vier do form, tenta usar a do produto
		if (empty($dados['banco_id']) && !empty($dados['produto_id'])) {
			$produto = Produto::with('instituicao')->find($dados['produto_id']);

			if ($produto && $produto->instituicao) {
				$dados['banco_id'] = $produto->instituicao->id;
			}
		}

		$proposta = Proposta::create($dados);

		// ... qualquer lógica adicional que você já tenha

		return redirect()
			->route('propostas.edit', $proposta->id)
			->with('success', 'Proposta criada com sucesso.');
	}



	public function show(Proposta $proposta)
	{
		//
	}


	public function edit($id)
	{
		$proposta = Proposta::with(['produto.instituicao', 'instituicao'])
			->findOrFail($id);

		$produtos = Produto::with('instituicao')
			->orderBy('produto')
			->get();

		$instituicoes = Banco::orderBy('nome')->get();

		return view('propostas.edit', compact(
			'proposta',
			'produtos',
			'instituicoes',
			// ... outros dados
		));
	}



	public function update(Request $request, $id)
	{
		$proposta = Proposta::findOrFail($id);

		$dados = $request->validate([
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			// ... demais campos
		]);

		if (empty($dados['banco_id']) && !empty($dados['produto_id'])) {
			$produto = Produto::with('instituicao')->find($dados['produto_id']);

			if ($produto && $produto->instituicao) {
				$dados['banco_id'] = $produto->instituicao->id;
			}
		}

		$proposta->update($dados);

		return redirect()
			->route('propostas.edit', $proposta->id)
			->with('success', 'Proposta atualizada com sucesso.');
	}




	public function destroy($id)
	{
		$proposta = Proposta::find($id);
		$proposta->delete();

		return redirect()->route('propostas.index')->withSuccess('Proposta exluida.');
	}

	public function consultaCpf(Request $request)
	{
		$cpf = $request->cpf;
		$cliente = Cliente::where("cpf", $cpf)->first();

		if (!$cliente) {
			$cliente = false;
		}
		return $cliente;
	}

	public function deletarDoc($id)
	{
		$documento = Documento::find($id);
		$documento->delete();

		return redirect()->back();
	}

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
			'aprovadas' => (clone $baseQuery)->where('status_atual_id', 3)->count(),
			'pendentes' => (clone $baseQuery)->whereIn('status_atual_id', [1, 2])->count(),
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		return view('propostas.usuario', [
			'usuarios' => $usuarios,
			'usuarioSelecionado' => $usuarioSelecionado,
			'propostas' => $propostas,
			'filtros' => $request->only(['data_inicio', 'data_fim']),
			'resumo' => $resumo,
			'activePage' => 'propostas-usuario',
		]);
	}

	protected function resolveComissaoVendedor(?Produto $produto, ?int $promotoraId): ?float
	{
		if (!$produto) {
			return null;
		}

		$hoje = now()->toDateString();

		// 1) Tentar comissão específica da promotora + produto
		if ($promotoraId) {
			$comissaoPromo = Comissao::where('produto_id', $produto->id)
				->where('promotora_id', $promotoraId)
				->where('tipo_comissao', 'vendedor')
				->where('ativo', true)
				->where(function ($q) use ($hoje) {
					$q->whereNull('vigencia_inicio')->orWhere('vigencia_inicio', '<=', $hoje);
				})
				->where(function ($q) use ($hoje) {
					$q->whereNull('vigencia_fim')->orWhere('vigencia_fim', '>=', $hoje);
				})
				->orderByDesc('id')
				->first();

			if ($comissaoPromo && $comissaoPromo->percentual !== null) {
				return (float) $comissaoPromo->percentual;
			}
		}

		// 2) Tentar comissão por banco + produto
		if ($produto->banco_id) {
			$comissaoBanco = Comissao::where('produto_id', $produto->id)
				->where('banco_id', $produto->banco_id)
				->where('tipo_comissao', 'vendedor')
				->where('ativo', true)
				->where(function ($q) use ($hoje) {
					$q->whereNull('vigencia_inicio')->orWhere('vigencia_inicio', '<=', $hoje);
				})
				->where(function ($q) use ($hoje) {
					$q->whereNull('vigencia_fim')->orWhere('vigencia_fim', '>=', $hoje);
				})
				->orderByDesc('id')
				->first();

			if ($comissaoBanco && $comissaoBanco->percentual !== null) {
				return (float) $comissaoBanco->percentual;
			}
		}

		// 3) Não encontrou configuração -> retorna null
		return null;
	}

}
