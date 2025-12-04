<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Proposta;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Produto;
use App\Models\Status;
use App\Models\User;
use App\Models\Comissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
		// listagem controlada pelo Livewire
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

		$user = Auth::user();

		return view('propostas.create', compact(
			'produtos',
			'instituicoes',
			'user'
		));
	}

	public function edit($id)
	{
		$proposta = Proposta::with(['produto.instituicao'])->findOrFail($id);

		$produtos = Produto::with('instituicao')
			->orderBy('produto')
			->get();

		$user = Auth::user();

		return view('propostas.edit', compact(
			'proposta',
			'produtos',
			'user'
		));
	}

	public function store(Request $request)
	{
		// 1) Normaliza campos monetários (pt-BR -> padrão numérico)
		$this->normalizaCamposMonetarios($request, [
			'valor_bruto',
			'valor_liquido_liberado',
			'valor_parcela',
			'tx_juros',
		]);

		// 2) Validação
		$dados = $request->validate([
			'cpf' => 'required|string',
			'produto_id' => 'required|exists:produtos,id',
			'orgao' => 'nullable|string|max:191',
			'banco' => 'nullable|string|max:191',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
			'banco_id' => 'nullable|exists:bancos,id',
		]);

		// 3) usuário logado
		$dados['user_id'] = Auth::id();

		// 4) resolve cliente pelo CPF (obrigatório)
		$cpf = preg_replace('/\D/', '', $dados['cpf']);
		$cliente = Cliente::whereRaw('REPLACE(REPLACE(REPLACE(cpf, ".", ""), "-", ""), "/", "") = ?', [$cpf])->first();

		if (!$cliente) {
			return back()
				->withErrors(['cpf' => 'Cliente não encontrado. Cadastre o cliente antes de criar a proposta.'])
				->withInput();
		}

		$dados['cliente_id'] = $cliente->id;

		// 5) resolve banco a partir do produto se não vier do front
		$produto = Produto::with('instituicao')->find($dados['produto_id']);

		if ($produto && $produto->instituicao) {
			if (empty($dados['banco_id'])) {
				$dados['banco_id'] = $produto->instituicao->id;
			}

			if (empty($dados['banco'])) {
				$dados['banco'] = $produto->instituicao->nome;
			}
		}

		// não precisa gravar cpf em propostas
		unset($dados['cpf']);

		// status inicial: Cadastrada
		$defaultStatus = Status::where('status', 'Cadastrada')->first();

		if ($defaultStatus) {
			$dados['status_atual_id'] = $defaultStatus->id;
		}

		// (se tiver também coluna status_tipo_atual_id e quiser setar um tipo padrão, pode fazer aqui)

		// cria a proposta
		$proposta = Proposta::create($dados);


		$proposta = Proposta::create($dados);

		return redirect()
			->route('propostas.edit', $proposta->id)
			->with('success', 'Proposta criada com sucesso.');
	}


	public function show(Proposta $proposta)
	{
		//
	}

	public function update(Request $request, $id)
	{
		$proposta = Proposta::findOrFail($id);

		// normaliza antes de validar
		$this->normalizaCamposMonetarios($request, [
			'valor_bruto',
			'valor_liquido_liberado',
			'valor_parcela',
			'tx_juros',
		]);

		$dados = $request->validate([
			'produto_id' => 'required|exists:produtos,id',
			'orgao' => 'nullable|string|max:191',
			'banco' => 'nullable|string|max:191',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
			'banco_id' => 'nullable|exists:bancos,id',
		]);

		$produto = Produto::with('instituicao')->find($dados['produto_id']);

		if ($produto && $produto->instituicao) {
			if (empty($dados['banco_id'])) {
				$dados['banco_id'] = $produto->instituicao->id;
			}

			if (empty($dados['banco'])) {
				$dados['banco'] = $produto->instituicao->nome;
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

	protected function normalizaCamposMonetarios(Request $request, array $campos)
	{
		foreach ($campos as $campo) {
			$valorOriginal = $request->input($campo);

			if ($valorOriginal === null || $valorOriginal === '') {
				continue;
			}

			// Remove tudo que não for dígito, ponto ou vírgula
			$valor = preg_replace('/[^0-9\.,]/', '', $valorOriginal);

			// Remove separador de milhar (ponto) e troca vírgula por ponto
			// Ex: "1.234,56" -> "1234,56" -> "1234.56"
			$valor = str_replace('.', '', $valor);
			$valor = str_replace(',', '.', $valor);

			$request->merge([
				$campo => $valor,
			]);
		}
	}

}
