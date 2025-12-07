<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Cliente;              // <-- AJUSTE AQUI
use App\Models\LancamentoFinanceiro;
use App\Models\ContaBancaria;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLancamentoFinanceiroRequest;
use App\Http\Requests\UpdateLancamentoFinanceiroRequest;

class LancamentoFinanceiroController extends Controller
{
	public function __construct()
	{
		// permissões do módulo financeiro
		$this->middleware('can:lancamentos.index')->only(['index', 'show', 'contasPagar', 'contasReceber']);
		$this->middleware('can:lancamentos.create')->only(['create', 'store']);
		$this->middleware('can:lancamentos.edit')->only(['edit', 'update']);
		$this->middleware('can:lancamentos.destroy')->only(['destroy']);
	}

	/**
	 * Listagem geral de lançamentos.
	 */
	public function index(Request $request)
	{
		$query = LancamentoFinanceiro::with('contaBancaria');

		if ($request->filled('tipo')) {
			$query->where('tipo', $request->tipo); // receita / despesa
		}

		if ($request->filled('natureza')) {
			$query->where('natureza', $request->natureza); // pagar / receber
		}

		if ($request->filled('status')) {
			$query->where('status', $request->status);
		}

		$lancamentos = $query->orderByDesc('data_vencimento')
			->orderByDesc('id')
			->paginate(20);

		return view('financeiro.lancamentos.index', compact('lancamentos'));
	}

	/**
	 * Armazena novo lançamento.
	 */
	public function store(StoreLancamentoFinanceiroRequest $request)
	{
		// Dados já validados pelo Form Request
		$dados = $request->validated();

		$dados['user_id'] = auth()->id();

		LancamentoFinanceiro::create($dados);

		return redirect()
			->route('lancamentos.index')
			->withSuccess('Lançamento financeiro criado com sucesso.');
	}

	/**
	 * Formulário de edição.
	 */
	public function edit($id)
	{
		$lancamento = LancamentoFinanceiro::findOrFail($id);
		$contas = ContaBancaria::orderBy('nome')->get();

		return view('financeiro.lancamentos.edit', compact('lancamento', 'contas'));
	}

	/**
	 * Atualiza lançamento.
	 */
	public function update(UpdateLancamentoFinanceiroRequest $request, $id)
	{
		$lancamento = LancamentoFinanceiro::findOrFail($id);

		// Dados já validados pelo Form Request
		$dados = $request->validated();

		$lancamento->update($dados);

		return redirect()
			->route('lancamentos.edit', $lancamento->id)
			->withSuccess('Lançamento financeiro atualizado com sucesso.');
	}

	/**
	 * Formulário de criação.
	 */
	public function create(Request $request)
	{
		$contas = ContaBancaria::orderBy('nome')->get();

		// natureza vem da URL (?natureza=receber) ou padrão = pagar
		$naturezaDefault = $request->get('natureza', 'pagar'); // pagar | receber

		// tipo padrão: se for receber = receita, se for pagar = despesa
		$tipoDefault = $naturezaDefault === 'receber' ? 'receita' : 'despesa';

		return view('financeiro.lancamentos.create', compact(
			'contas',
			'naturezaDefault',
			'tipoDefault'
		));
	}

	/**
	 * Remove lançamento.
	 */
	public function destroy($id)
	{
		$lancamento = LancamentoFinanceiro::findOrFail($id);
		$lancamento->delete();

		return redirect()
			->route('lancamentos.index')
			->withSuccess('Lançamento financeiro excluído com sucesso.');
	}

	/**
	 * Contas a pagar (natureza = pagar).
	 */
	public function contasPagar(Request $request)
	{
		$query = LancamentoFinanceiro::where('natureza', 'pagar')
			->with(['fornecedor', 'contaBancaria']);

		// Status (aberto/pago/atrasado/cancelado/todos)
		if ($request->filled('status') && $request->status !== 'todos') {
			$query->where('status', $request->status);
		}

		// Fornecedor
		if ($request->filled('fornecedor_id')) {
			$query->where('fornecedor_id', $request->fornecedor_id);
		}

		// Período de vencimento
		if ($request->filled('data_inicio')) {
			$query->whereDate('data_vencimento', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('data_vencimento', '<=', $request->data_fim);
		}

		$lancamentos = $query
			->orderBy('data_vencimento')
			->orderBy('id')
			->paginate(20);

		$fornecedores = Fornecedor::orderBy('nome')->get();

		$filtros = $request->only(['status', 'fornecedor_id', 'data_inicio', 'data_fim']);
		if (!isset($filtros['status'])) {
			$filtros['status'] = 'aberto';
		}

		return view('financeiro.contas_pagar', compact('lancamentos', 'fornecedores', 'filtros'));
	}

	public function contasReceber(Request $request)
	{
		$query = LancamentoFinanceiro::where('natureza', 'receber')
			->with(['cliente', 'contaBancaria']);

		// Status
		if ($request->filled('status') && $request->status !== 'todos') {
			$query->where('status', $request->status);
		}

		// Cliente
		if ($request->filled('cliente_id')) {
			$query->where('cliente_id', $request->cliente_id);
		}

		// Período de vencimento
		if ($request->filled('data_inicio')) {
			$query->whereDate('data_vencimento', '>=', $request->data_inicio);
		}

		if ($request->filled('data_fim')) {
			$query->whereDate('data_vencimento', '<=', $request->data_fim);
		}

		$lancamentos = $query
			->orderBy('data_vencimento')
			->orderBy('id')
			->paginate(20);

		$clientes = Cliente::orderBy('nome')->get();

		$filtros = $request->only(['status', 'cliente_id', 'data_inicio', 'data_fim']);
		if (!isset($filtros['status'])) {
			$filtros['status'] = 'aberto';
		}

		return view('financeiro.contas_receber', compact('lancamentos', 'clientes', 'filtros'));
	}

	public function receitas(Request $request)
	{
		$query = LancamentoFinanceiro::with(['contaBancaria', 'cliente'])
			->where('tipo', 'receita');

		if ($request->filled('natureza')) {
			$query->where('natureza', $request->natureza); // receber/pagar (se quiser)
		}

		if ($request->filled('status') && $request->status !== 'todos') {
			$query->where('status', $request->status);
		}

		$lancamentos = $query
			->orderByDesc('data_competencia')
			->paginate(20);

		return view('financeiro.lancamentos.receitas', [
			'lancamentos' => $lancamentos,
			'filtros' => $request->only(['natureza', 'status']),
		]);
	}

	public function despesas(Request $request)
	{
		$query = LancamentoFinanceiro::with(['contaBancaria', 'fornecedor'])
			->where('tipo', 'despesa');

		if ($request->filled('natureza')) {
			$query->where('natureza', $request->natureza); // geralmente pagar
		}

		if ($request->filled('status') && $request->status !== 'todos') {
			$query->where('status', $request->status);
		}

		$lancamentos = $query
			->orderByDesc('data_competencia')
			->paginate(20);

		return view('financeiro.lancamentos.despesas', [
			'lancamentos' => $lancamentos,
			'filtros' => $request->only(['natureza', 'status']),
		]);
	}

	public function movimentacao(Request $request)
	{
		$contas = ContaBancaria::orderBy('nome')->get();

		$contaId = $request->input('conta_bancaria_id');
		$dataInicio = $request->input('data_inicio');
		$dataFim = $request->input('data_fim');

		$query = LancamentoFinanceiro::with('contaBancaria')
			->where('status', 'pago');

		if ($contaId) {
			$query->where('conta_bancaria_id', $contaId);
		}

		if ($dataInicio) {
			$query->whereDate('data_pagamento', '>=', $dataInicio);
		}

		if ($dataFim) {
			$query->whereDate('data_pagamento', '<=', $dataFim);
		}

		$lancamentos = $query
			->orderBy('data_pagamento')
			->orderBy('id')
			->get();

		// calcula saldo parcial
		$saldoInicial = 0;
		if ($contaId) {
			$conta = ContaBancaria::find($contaId);
			$saldoInicial = $conta->saldo_inicial ?? 0;
		}

		$saldoAtual = $saldoInicial;

		$lancamentosComSaldo = $lancamentos->map(function ($lancamento) use (&$saldoAtual) {
			if ($lancamento->tipo === 'receita') {
				$saldoAtual += $lancamento->valor_pago ?? $lancamento->valor_previsto;
			} else {
				$saldoAtual -= $lancamento->valor_pago ?? $lancamento->valor_previsto;
			}

			$lancamento->saldo_pos_movimento = $saldoAtual;
			return $lancamento;
		});

		return view('financeiro.movimentacao', [
			'contas' => $contas,
			'lancamentos' => $lancamentosComSaldo,
			'saldoInicial' => $saldoInicial,
			'saldoFinal' => $saldoAtual,
			'filtros' => $request->only(['conta_bancaria_id', 'data_inicio', 'data_fim']),
		]);
	}

}
