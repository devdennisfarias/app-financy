@extends('layouts.app', [
    'activePage' => $activePage ?? 'home',
    'titlePage' => __('Dashboard FinancyCred')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- LINHA 1 – KPIs principais (cards clicáveis) --}}
        <div class="row">

            {{-- Clientes --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('clientes.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Clientes</p>
                            <h3 class="card-title">{{ $totalClientes }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Ver todos os clientes
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Propostas (todas) --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('propostas.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Propostas</p>
                            <h3 class="card-title">{{ $totalPropostas }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Ver todas as propostas
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Produção (concluídas) --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('producao.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category text-success">Concluídas</p>
                            <h3 class="card-title">{{ $totalAprovadas }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Ver produção geral
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Pendentes --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('producao.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category text-warning">Pendentes</p>
                            <h3 class="card-title">{{ $totalPendentes }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Aguardando análise/retorno
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        {{-- LINHA 2 – Valores e ticket (também clicáveis para produção) --}}
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('producao.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Valor Total Concluído</p>
                            <h3 class="card-title">
                                R$ {{ number_format($valorTotalAprovado, 2, ',', '.') }}
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Soma de todas as propostas concluídas
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('producao.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Ticket Médio</p>
                            <h3 class="card-title">
                                R$ {{ number_format($ticketMedio, 2, ',', '.') }}
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Média por proposta concluída
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-12">
                <a href="{{ route('producao.index') }}" style="text-decoration:none;">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Este mês</p>
                            <h4 class="card-title">
                                {{ $propostasMes }} propostas<br>
                                <small>
                                    Concluído: R$ {{ number_format($valorMes, 2, ',', '.') }}
                                </small>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                Produção do mês atual
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        {{-- LINHA 3 – Hoje + Alertas --}}
        <div class="row">

            {{-- Bloco Hoje --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Hoje</h4>
                        <p class="card-category">Resumo do dia</p>
                    </div>
                    <div class="card-body">
                        <p><strong>Propostas cadastradas:</strong> {{ $propostasHoje }}</p>
                        <p><strong>Valor concluído hoje:</strong><br>
                            R$ {{ number_format($valorHoje, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bloco Alertas --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">
                            Alertas ({{ $totalAlertas }})
                        </h4>
                        <p class="card-category">
                            Propostas pendentes há mais de 3 dias
                        </p>
                    </div>
                    <div class="card-body">
                        @if($alertasPendentes->isEmpty())
                            <p>Não há alertas no momento. 👌</p>
                        @else
                            @php
                                $statusColors = [
                                    1 => 'secondary', // Cadastrada
                                    2 => 'warning',   // Em andamento
                                    3 => 'info',      // Integração / Outros em fluxo
                                    4 => 'success',   // Finalizadas / Pagas
                                    5 => 'danger',    // Canceladas
                                ];
                            @endphp
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Usuário</th>
                                            <th>Status</th>
                                            <th>Desde</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($alertasPendentes as $p)
                                            <tr>
                                                <td>{{ $p->id }}</td>
                                                <td>{{ optional($p->cliente)->nome }}</td>
                                                <td>{{ optional($p->user)->name }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $statusColors[$p->status_tipo_atual_id] ?? 'secondary' }}">
                                                        {{ optional($p->statusAtual)->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- LINHA 4 – Gráfico do mês atual --}}
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Mês Atual – Propostas e Valores por Dia</h4>
                        <p class="card-category">Quantidade de propostas e valor concluído diariamente</p>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoMesAtual"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- LINHA 5 – Últimas Propostas --}}
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Últimas Propostas</h4>
                        <p class="card-category">Últimos registros lançados no sistema</p>
                    </div>
                    <div class="card-body">
                        @php
                            $statusColors = [
                                1 => 'secondary', // Cadastrada
                                2 => 'warning',   // Em andamento
                                3 => 'info',      // Integração
                                4 => 'success',   // Finalizadas / Pagas
                                5 => 'danger',    // Canceladas
                            ];
                        @endphp
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Produto</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                        <th>Usuário</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimasPropostas as $p)
                                        <tr>
                                            <td>{{ $p->id }}</td>
                                            <td>{{ optional($p->cliente)->nome }}</td>
                                            <td>{{ optional($p->produto)->nome }}</td>
                                            <td>
                                                <span class="badge badge-{{ $statusColors[$p->status_tipo_atual_id] ?? 'secondary' }}">
                                                    {{ optional($p->statusAtual)->status }}
                                                </span>
                                            </td>
                                            <td>R$ {{ number_format($p->valor_liquido_liberado ?? 0, 2, ',', '.') }}</td>
                                            <td>{{ optional($p->user)->name }}</td>
                                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Nenhuma proposta encontrada.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('js')
    {{-- Chart.js via CDN (pode mover para layout se quiser) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($chartLabels);
        const dataPropostas = @json($chartPropostasCount);
        const dataValores = @json($chartValores);

        const ctx = document.getElementById('graficoMesAtual').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'bar',
                        label: 'Qtd Propostas',
                        data: dataPropostas,
                        yAxisID: 'y',
                    },
                    {
                        type: 'line',
                        label: 'Valor Concluído (R$)',
                        data: dataValores,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Qtd'
                        }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                        title: {
                            display: true,
                            text: 'Valor (R$)'
                        }
                    }
                }
            }
        });
    </script>
@endsection
