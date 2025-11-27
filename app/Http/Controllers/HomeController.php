<?php

namespace App\Http\Controllers;
use App\Models\Proposta;
use App\Models\Cliente;
use Carbon\Carbon;

class HomeController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('can:home')->only('index');
	}

	public function index()
	{
		$hoje = Carbon::today();
		$agora = Carbon::now();
		$inicioMes = $agora->copy()->startOfMonth();

		// Totais gerais
		$totalClientes = Cliente::count();
		$totalPropostas = Proposta::count();

		// status_tipo_atual_id:
		// 1 = Cadastrada
		// 2 = Em Andamento
		// 3 = Integração / Pendenciada / Aguardando
		// 4 = Finalizado / Contrato Pago / Comissão Paga
		// 5 = Cancelado

		// Pendentes = tipos 1,2,3
		$totalPendentes = Proposta::whereIn('status_tipo_atual_id', [1, 2, 3])->count();

		// Concluídas = tipo 4
		$totalAprovadas = Proposta::where('status_tipo_atual_id', 4)->count();

		// Valor total concluído
		$valorTotalAprovado = Proposta::where('status_tipo_atual_id', 4)
			->sum('valor_liquido_liberado');

		$ticketMedio = $totalAprovadas > 0
			? $valorTotalAprovado / $totalAprovadas
			: 0;

		// Hoje
		$propostasHoje = Proposta::whereDate('created_at', $hoje)->count();

		$valorHoje = Proposta::where('status_tipo_atual_id', 4)
			->whereDate('created_at', $hoje)
			->sum('valor_liquido_liberado');

		// Mês atual
		$propostasMes = Proposta::whereBetween('created_at', [$inicioMes, $agora])->count();

		$valorMes = Proposta::where('status_tipo_atual_id', 4)
			->whereBetween('created_at', [$inicioMes, $agora])
			->sum('valor_liquido_liberado');

		// Últimas propostas
		$ultimasPropostas = Proposta::with(['cliente', 'produto', 'user', 'statusAtual'])
			->latest()
			->limit(10)
			->get();

		// ALERTAS – propostas pendentes há mais de 3 dias (tipos 1,2,3)
		$alertasPendentes = Proposta::whereIn('status_tipo_atual_id', [1, 2, 3])
			->where('created_at', '<', Carbon::now()->subDays(3))
			->with(['cliente', 'user', 'statusAtual'])
			->orderBy('created_at')
			->limit(5)
			->get();

		$totalAlertas = $alertasPendentes->count();

		// GRÁFICO – mês atual: quantidade e valor concluído por dia
		$dadosGrafico = Proposta::selectRaw('
            DATE(created_at) as dia,
            COUNT(*) as total_propostas,
            SUM(CASE WHEN status_tipo_atual_id = 4 THEN valor_liquido_liberado ELSE 0 END) as total_valor
        ')
			->whereBetween('created_at', [$inicioMes, $agora])
			->groupBy('dia')
			->orderBy('dia')
			->get();

		$chartLabels = $dadosGrafico->map(function ($item) {
			return Carbon::parse($item->dia)->format('d/m');
		})->toArray();

		$chartPropostasCount = $dadosGrafico->pluck('total_propostas')->toArray();
		$chartValores = $dadosGrafico->pluck('total_valor')->toArray();

		return view('home', [
			'totalClientes' => $totalClientes,
			'totalPropostas' => $totalPropostas,
			'totalAprovadas' => $totalAprovadas,
			'totalPendentes' => $totalPendentes,
			'valorTotalAprovado' => $valorTotalAprovado,
			'ticketMedio' => $ticketMedio,
			'propostasHoje' => $propostasHoje,
			'valorHoje' => $valorHoje,
			'propostasMes' => $propostasMes,
			'valorMes' => $valorMes,
			'ultimasPropostas' => $ultimasPropostas,
			'alertasPendentes' => $alertasPendentes,
			'totalAlertas' => $totalAlertas,
			'chartLabels' => $chartLabels,
			'chartPropostasCount' => $chartPropostasCount,
			'chartValores' => $chartValores,
			'activePage' => 'home',
		]);
	}

}
