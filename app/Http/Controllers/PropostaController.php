<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Convenio;
use App\Models\Orgao;
use App\Models\Proposta;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Produto;
use App\Models\User;
use App\Models\Comissao;
use App\Models\Status;
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

		$convenios = Convenio::orderBy('nome')->get();

		$user = Auth::user();

		return view('propostas.create', compact(
			'produtos',
			'instituicoes',
			'user',
			'convenios'
		));
	}

	public function edit($id)
	{
		$proposta = Proposta::with([
			'produto.instituicao',
			'cliente',
			'vendedor',
			'status_atual',
		])->findOrFail($id);

		$produtos = Produto::with('instituicao')
			->orderBy('produto')
			->get();

		$user = Auth::user();
		$statusList = Status::orderBy('status')->get();
		$convenios = Convenio::orderBy('nome')->get();

		$convenioSelecionadoId = null;
		$orgaoSelecionadoId = null;
		$orgaosDoConvenio = collect();

		if (!empty($proposta->orgao)) {
			$orgaoModel = Orgao::where('nome', $proposta->orgao)->first();

			if ($orgaoModel) {
				$orgaoSelecionadoId = $orgaoModel->id;
				$convenioSelecionadoId = $orgaoModel->convenio_id;

				$orgaosDoConvenio = Orgao::where('convenio_id', $convenioSelecionadoId)
					->orderBy('nome')
					->get();
			}
		}

		return view('propostas.edit', compact(
			'proposta',
			'produtos',
			'user',
			'statusList',
			'convenios',
			'convenioSelecionadoId',
			'orgaoSelecionadoId',
			'orgaosDoConvenio'
		));
	}

	public function store(Request $request)
	{
		$this->normalizarCamposNumericos($request);

		$dados = $request->validate([
			'cpf' => 'required|string',
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			'banco' => 'nullable|string',
			'orgao' => 'nullable|string',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
			'status_atual_id' => 'nullable|exists:status,id',
		]);

		$cliente = Cliente::where('cpf', $dados['cpf'])->first();

		if (!$cliente) {
			return back()
				->withInput()
				->withErrors(['cpf' => 'Cliente não encontrado. Cadastre o cliente antes de criar a proposta.']);
		}

		if (empty($dados['banco_id']) && !empty($dados['produto_id'])) {
			$produto = Produto::with('instituicao')->find($dados['produto_id']);

			if ($produto && $produto->instituicao) {
				$dados['banco_id'] = $produto->instituicao->id;
				if (empty($dados['banco'])) {
					$dados['banco'] = $produto->instituicao->nome;
				}
			}
		}

		$dados['cliente_id'] = $cliente->id;
		$dados['user_id'] = Auth::id();

		if (empty($dados['status_atual_id'])) {
			$defaultStatus = Status::whereRaw('LOWER(status) = ?', ['cadastrada'])->first();

			if ($defaultStatus) {
				$dados['status_atual_id'] = $defaultStatus->id;
			}
		}

		unset($dados['cpf']);

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

		$this->normalizarCamposNumericos($request);

		$dados = $request->validate([
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			'banco' => 'nullable|string',
			'orgao' => 'nullable|string',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
			'status_atual_id' => 'nullable|exists:status,id',
		]);

		if (empty($dados['banco_id']) && !empty($dados['produto_id'])) {
			$produto = Produto::with('instituicao')->find($dados['produto_id']);

			if ($produto && $produto->instituicao) {
				$dados['banco_id'] = $produto->instituicao->id;
				if (empty($dados['banco'])) {
					$dados['banco'] = $produto->instituicao->nome;
				}
			}
		}

		$proposta->update($dados);

		$from = $request->input('from') ?? $request->input('redirect_to');

		if ($from === 'esteira') {
			return redirect()
				->route('esteira.index')
				->with('success', 'Proposta atualizada com sucesso.');
		}

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
		$cpf = preg_replace('/\D/', '', $request->cpf);

		$cliente = Cliente::with('orgao.convenio')
			->whereRaw('REPLACE(REPLACE(REPLACE(cpf, ".", ""), "-", ""), " ", "") = ?', [$cpf])
			->first();

		if (!$cliente) {
			return response()->json(['exists' => false]);
		}

		return response()->json([
			'exists' => true,
			'cliente' => [
				'id' => $cliente->id,
				'nome' => $cliente->nome,
				'cpf' => $cliente->cpf,
				'orgao_id' => $cliente->orgao_id,
				'convenio_id' => optional($cliente->orgao)->convenio_id,
			],
		]);
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

		return null;
	}

	protected function normalizarCamposNumericos(Request $request): void
	{
		$campos = [
			'valor_bruto',
			'valor_liquido_liberado',
			'tx_juros',
			'valor_parcela',
		];

		$normalizados = [];

		foreach ($campos as $campo) {
			if ($request->filled($campo)) {
				$normalizados[$campo] = $this->brToDecimal($request->input($campo));
			}
		}

		if (!empty($normalizados)) {
			$request->merge($normalizados);
		}
	}

	protected function brToDecimal(?string $valor): ?string
	{
		if ($valor === null) {
			return null;
		}

		$valor = trim($valor);
		if ($valor === '') {
			return null;
		}

		$valor = str_replace(['R$', '%', ' '], '', $valor);
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);

		return $valor;
	}
}
