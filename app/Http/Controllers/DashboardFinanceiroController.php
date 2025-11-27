<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContaBancaria;
use App\Models\LancamentoFinanceiro;
use Carbon\Carbon;

class DashboardFinanceiroController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:financeiro.dashboard')->only('index');
		$this->middleware('can:financeiro.relatorios')->only('relatorios');
	}

	public function index()
	{
		$hoje = Carbon::today();
		$inicioMes = Carbon::now()->startOfMonth();
		$em7dias = Carbon::today()->addDays(7);

		// Totais mês
		$despesasMes = LancamentoFinanceiro::despesas()
			->whereBetween('data_competencia', [$inicioMes, $hoje])
			->sum('valor_previsto');

		$receitasMes = LancamentoFinanceiro::receitas()
			->whereBetween('data_competencia', [$inicioMes, $hoje])
			->sum('valor_previsto');

		// Contas em aberto
		$contasPagarAbertas = LancamentoFinanceiro::where('natureza', 'pagar')
			->where('status', 'aberto')
			->sum('valor_previsto');

		$contasReceberAbertas = LancamentoFinanceiro::where('natureza', 'receber')
			->where('status', 'aberto')
			->sum('valor_previsto');

		// Saldos por conta bancária (simplificado: saldo_inicial + receitas - despesas pagas)
		$contas = ContaBancaria::with([
			'lancamentos' => function ($q) {
				$q->where('status', 'pago');
			}
		])->get();

		// contas a pagar em atraso
		$contasAtrasadas = LancamentoFinanceiro::where('natureza', 'pagar')
			->where('status', 'aberto')
			->whereDate('data_vencimento', '<', $hoje)
			->orderBy('data_vencimento')
			->take(10)
			->get();

		// contas a vencer nos próximos 7 dias
		$contasVencendo = LancamentoFinanceiro::where('natureza', 'pagar')
			->where('status', 'aberto')
			->whereBetween('data_vencimento', [$hoje, $em7dias])
			->orderBy('data_vencimento')
			->take(10)
			->get();

		$contasComSaldo = $contas->map(function ($conta) {
			$receitas = $conta->lancamentos->where('tipo', 'receita')->sum('valor_pago');
			$despesas = $conta->lancamentos->where('tipo', 'despesa')->sum('valor_pago');

			$conta->saldo_atual = $conta->saldo_inicial + $receitas - $despesas;
			return $conta;
		});

		return view('financeiro.dashboard', [
			'despesasMes' => $despesasMes,
			'receitasMes' => $receitasMes,
			'contasPagarAbertas' => $contasPagarAbertas,
			'contasReceberAbertas' => $contasReceberAbertas,
			'contas' => $contasComSaldo,
			'contasAtrasadas' => $contasAtrasadas,
			'contasVencendo' => $contasVencendo,
		]);
	}

	public function relatorios()
	{
		// aqui depois podemos montar filtros por período e tipo
		return view('financeiro.relatorios');
	}
}
