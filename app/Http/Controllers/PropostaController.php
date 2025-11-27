<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Proposta;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Produto;
use App\Models\RegraProduto;
use App\Models\Tabela;
use App\Models\User;
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

		$propostas = $query
			->with(['cliente', 'produto', 'user'])
			->latest()
			->paginate(20);

		$usuarios = User::orderBy('name')->get();

		// --- KPIs ---
		$baseQuery = clone $query;

		$resumo = [
			'total' => (clone $baseQuery)->count(),
			// ajuste os IDs de status conforme sua tabela de status_atual_id
			'aprovadas' => (clone $baseQuery)->where('status_atual_id', 3)->count(),
			'pendentes' => (clone $baseQuery)->whereIn('status_atual_id', [1, 2])->count(),
			'valor_total' => (clone $baseQuery)->sum('valor_liquido_liberado'),
		];

		return view('producao.index', [
			'propostas' => $propostas,
			'usuarios' => $usuarios,
			'filtros' => $request->only(['data_inicio', 'data_fim', 'user_id']),
			'resumo' => $resumo,
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

		if ($user->regra_id == null) {
			return redirect()
				->route('propostas.create')
				->with('danger', 'Você não tem regra de comissão cadastrada, por isso não pode enviar essa proposta!')
				->withInput();
		}


		$validator = Validator::make($dados, [
			'produto' => ['required'],
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
			$proposta->user_id = $loggedId;

			$proposta->status_atual_id = 1;
			$proposta->status_tipo_atual_id = 1;

			// SETANDO PRODUTO E VALOR DA COMISSÃO DO VENDEDOR NA HORA DO CADASTRO DA PROPOSTA
			$proposta->produto_id = $dados['produto'];
			$user = User::find($loggedId);
			$regra_produto = RegraProduto::where('produto_id', '=', $proposta->produto_id)->where('regra_id', '=', $user->regra_id)->first();
			$proposta->porcentagem_comissao_vendedor = $regra_produto->comissao;

			$proposta->tabela_digitada = $dados['tabela_digitada'];

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


}
