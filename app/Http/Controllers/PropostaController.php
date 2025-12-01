<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Proposta;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Produto;
use App\Models\Tabela;
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
		$loggedId = Auth::id();
		$user = User::find($loggedId);
		$produtos = Produto::all();
		$tabelas = Tabela::all();
		return view('propostas.create', [
			'user' => $user,
			'produtos' => $produtos,
			'tabelas' => $tabelas
		]);
	}


	public function store(Request $request)
	{
		$loggedId = Auth::id();
		$proposta = new Proposta;
		$dados = $request->all();
		$user = User::find($loggedId);

		$validator = Validator::make($dados, [
			'produto' => ['required'],
			// se quiser, pode já validar aqui:
			// 'porcentagem_comissao_vendedor' => ['nullable', 'numeric'],
		]);

		if ($validator->fails()) {
			return redirect()->route('propostas.create')
				->withErrors($validator)
				->withInput();
		}

		$verificaCpf = Cliente::where("cpf", "=", $request->cpf)->first();

		if (!empty($verificaCpf)) {

			$proposta->cliente_id = $verificaCpf['id'];

			$proposta->orgao = $dados['orgao'];
			$proposta->tabela_digitada = $dados['tabela_digitada'];
			$proposta->vigencia_tabela = $dados['vigencia_tabela'];
			$proposta->banco = $dados['banco']; // texto/legado

			// PRODUTO
			$proposta->produto_id = $dados['produto'];

			$produto = Produto::with('banco')->find($proposta->produto_id);

			// BANCO_ID (se existir a coluna na tabela propostas)
			if ($produto && isset($proposta->banco_id)) {
				$proposta->banco_id = $produto->banco_id;
			}

			// PROMOTORA (opcional)
			if (!empty($dados['promotora_id'] ?? null)) {
				$proposta->promotora_id = $dados['promotora_id'];
			}

			// TRATAMENTO DOS VALORES
			$dados['valor_bruto'] = str_replace(".", "", $dados['valor_bruto']);
			$dados['valor_bruto'] = str_replace(",", ".", $dados['valor_bruto']);
			if ($dados['valor_bruto'] == "") {
				$dados['valor_bruto'] = null;
			}
			$proposta->valor_bruto = $dados['valor_bruto'];

			$dados['valor_liquido_liberado'] = str_replace(".", "", $dados['valor_liquido_liberado']);
			$dados['valor_liquido_liberado'] = str_replace(",", ".", $dados['valor_liquido_liberado']);
			if ($dados['valor_liquido_liberado'] == "") {
				$dados['valor_liquido_liberado'] = null;
			}
			$proposta->valor_liquido_liberado = $dados['valor_liquido_liberado'];

			$dados['tx_juros'] = str_replace("%", "", $dados['tx_juros']);
			$dados['tx_juros'] = str_replace(",", ".", $dados['tx_juros']);
			if ($dados['tx_juros'] == "") {
				$dados['tx_juros'] = null;
			}
			$proposta->tx_juros = $dados['tx_juros'];

			$dados['valor_parcela'] = str_replace(".", "", $dados['valor_parcela']);
			$dados['valor_parcela'] = str_replace(",", ".", $dados['valor_parcela']);
			if ($dados['valor_parcela'] == "") {
				$dados['valor_parcela'] = null;
			}
			$proposta->valor_parcela = $dados['valor_parcela'];

			$proposta->qtd_parcelas = $dados['qtd_parcelas'];
			$proposta->user_id = $loggedId;

			$proposta->status_atual_id = 1;
			$proposta->status_tipo_atual_id = 1;

			// ===============================
			// COMISSÃO DO VENDEDOR
			// ===============================

			// 1) Tenta pegar do formulário (manual)
			$percentManual = $dados['porcentagem_comissao_vendedor'] ?? null;

			if ($percentManual !== null && $percentManual !== '') {
				// normalizar vírgula/ponto
				$percentManual = str_replace('%', '', $percentManual);
				$percentManual = str_replace(',', '.', $percentManual);
				$proposta->porcentagem_comissao_vendedor = $percentManual;
			} else {
				// 2) Se não veio manual, tenta resolver automático
				$percentAuto = $this->resolveComissaoVendedor($produto, $proposta->promotora_id ?? null);
				$proposta->porcentagem_comissao_vendedor = $percentAuto; // pode ser null, e tudo bem
			}

			$proposta->save();

			// MUDA CLIENTE DE CARTEIRA CASO FOR VENDEDOR DIFERENTE
			if ($verificaCpf->vendedor->id !== $loggedId) {
				$verificaCpf->user_id = $loggedId;
				$verificaCpf->save();
			}

			//// TRATAMENTO DOS DOCUMENTOS ENVIADOS
			if ($request['documentos']) {
				for ($i = 0; $i < count($request->allFiles()['documentos']); $i++) {

					$file = $request->allFiles()['documentos'][$i];

					$documento = new Documento();
					$documento->proposta_id = $proposta->id;
					$documento->path = $file->store('propostas/' . $proposta->id);
					$documento->extencao = $file->extension();
					$documento->save();
					unset($documento);
				}
			}

			return redirect()
				->route('propostas.edit', compact('proposta'))
				->withSuccess('Proposta cadastrada.');

		}

		return redirect()
			->route('propostas.create')
			->withDanger('Cliente não cadastrado')
			->withInput();
	}


	public function show(Proposta $proposta)
	{
		//
	}


	public function edit($id)
	{
		$proposta = Proposta::find($id);
		$cliente = $proposta->cliente->find($proposta->cliente_id);
		//dd($cliente);
		$atendimentos = Atendimento::all();

		if ($proposta) {
			return view('propostas.edit', [
				'cliente' => $cliente,
				'proposta' => $proposta,
				'atendimentos' => $atendimentos
			]);
		}

		return redirect()->route('propostas.index');
	}


	public function update(Request $request, $id)
	{

		$proposta = Proposta::find($id);
		$dados = $request->all();

		/*$validator = Validator::make($dados,[

		]); */

		$verificaCpf = Cliente::where("cpf", "=", $request->cpf)->first();
		//dd($verificaCpf->id);

		if (!empty($verificaCpf)) {

			$proposta->cliente_id = $verificaCpf->id;


			$proposta->orgao = $dados['orgao'];
			$proposta->tabela_digitada = $dados['tabela_digitada'];
			$proposta->vigencia_tabela = $dados['vigencia_tabela'];
			$proposta->banco = $dados['banco'];

			$dados['valor_bruto'] = str_replace(".", "", $dados['valor_bruto']); // Tira a ponto
			$dados['valor_bruto'] = str_replace(",", ".", $dados['valor_bruto']); // Tira a vírgula
			if ($dados['valor_bruto'] == "") {
				$dados['valor_bruto'] = null;
			}
			$proposta->valor_bruto = $dados['valor_bruto'];

			$dados['valor_liquido_liberado'] = str_replace(".", "", $dados['valor_liquido_liberado']); // Tira a ponto
			$dados['valor_liquido_liberado'] = str_replace(",", ".", $dados['valor_liquido_liberado']); // Tira a vírgula
			if ($dados['valor_liquido_liberado'] == "") {
				$dados['valor_liquido_liberado'] = null;
			}
			$proposta->valor_liquido_liberado = $dados['valor_liquido_liberado'];

			$dados['tx_juros'] = str_replace("%", "", $dados['tx_juros']); // Tira o %
			$dados['tx_juros'] = str_replace(",", ".", $dados['tx_juros']); // Tira a vírgula
			if ($dados['tx_juros'] == "") {
				$dados['tx_juros'] = null;
			}
			$proposta->tx_juros = $dados['tx_juros'];

			$dados['valor_parcela'] = str_replace(".", "", $dados['valor_parcela']); // Tira a ponto
			$dados['valor_parcela'] = str_replace(",", ".", $dados['valor_parcela']); // Tira a vírgula
			if ($dados['valor_parcela'] == "") {
				$dados['valor_parcela'] = null;
			}
			$proposta->valor_parcela = $dados['valor_parcela'];

			$proposta->qtd_parcelas = $dados['qtd_parcelas'];

			$proposta->save();

			//// TRATAMENTO DOS DOCUMENTOS ENVIADOS
			if ($request->documentos) {
				for ($i = 0; $i < count($request->allFiles()['documentos']); $i++) {

					$file = $request->allFiles()['documentos'][$i];

					$documento = new Documento();
					$documento->proposta_id = $proposta->id;
					$documento->path = $file->store('propostas/' . $proposta->id);
					$documento->extencao = $file->extension();
					//dd($documento->extencao);
					$documento->save();
					unset($documento);
				}
			}


			return redirect()
				->route('propostas.edit', compact('proposta'))
				->withSuccess('Proposta atualizada.');

		} else {
			return redirect()
				->back()
				->withDanger('Cliente não cadastrado')
				->withInput();
		}

		return redirect()->back()->withDanger();

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
