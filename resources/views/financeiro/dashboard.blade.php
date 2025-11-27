@extends('layouts.app', [
    'activePage' => 'financeiro-dashboard',
    'titlePage'  => __('Dashboard Financeiro')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- LINHA 1 – KPIs principais --}}
        <div class="row">

            {{-- Despesas do mês --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">trending_down</i>
                        </div>
                        <p class="card-category">Despesas no mês</p>
                        <h3 class="card-title">
                            R$ {{ number_format($despesasMes ?? 0, 2, ',', '.') }}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('financeiro.despesas') }}">Ver detalhes</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Receitas do mês --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">trending_up</i>
                        </div>
                        <p class="card-category">Receitas no mês</p>
                        <h3 class="card-title">
                            R$ {{ number_format($receitasMes ?? 0, 2, ',', '.') }}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('financeiro.receitas') }}">Ver detalhes</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contas a pagar em aberto --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt_long</i>
                        </div>
                        <p class="card-category">Contas a pagar (abertas)</p>
                        <h3 class="card-title">
                            R$ {{ number_format($contasPagarAbertas ?? 0, 2, ',', '.') }}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('financeiro.contas-pagar') }}">Ir para Contas a Pagar</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contas a receber em aberto --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_balance_wallet</i>
                        </div>
                        <p class="card-category">Contas a receber (abertas)</p>
                        <h3 class="card-title">
                            R$ {{ number_format($contasReceberAbertas ?? 0, 2, ',', '.') }}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('financeiro.contas-receber') }}">Ir para Contas a Receber</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- LINHA 2 – Saldos por conta bancária --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Saldos por Conta Bancária</h4>
                        <p class="card-category">Saldo inicial + movimentações pagas</p>
                    </div>
                    <div class="card-body">
                        @if(($contas ?? collect())->isEmpty())
                            <p>Nenhuma conta bancária cadastrada.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Banco</th>
                                            <th>Conta</th>
                                            <th>Agência</th>
                                            <th>Saldo Atual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contas as $conta)
                                            <tr>
                                                <td>{{ $conta->banco->nome ?? '-' }}</td>
                                                <td>{{ $conta->numero ?? '-' }}</td>
                                                <td>{{ $conta->agencia ?? '-' }}</td>
                                                <td>
                                                    R$ {{ number_format($conta->saldo_atual ?? 0, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('financeiro.movimentacao') }}">
                                Ver movimentação bancária
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LINHA 3 – Lembretes de Contas --}}
        <div class="row">

            {{-- Contas em atraso --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title">Contas em atraso</h4>
                        <p class="card-category">Lançamentos vencidos e ainda em aberto</p>
                    </div>
                    <div class="card-body">
                        @if(($contasAtrasadas ?? collect())->isEmpty())
                            <p>Sem contas em atraso no momento. 👌</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-danger">
                                        <tr>
                                            <th>Vencimento</th>
                                            <th>Descrição</th>
                                            <th>Fornecedor</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contasAtrasadas as $l)
                                            <tr>
                                                <td>{{ optional($l->data_vencimento)->format('d/m/Y') }}</td>
                                                <td>{{ $l->descricao }}</td>
                                                <td>{{ optional($l->fornecedor)->nome }}</td>
                                                <td>R$ {{ number_format($l->valor_previsto, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                <a href="{{ route('financeiro.contas-pagar', ['status' => 'aberto']) }}">
                                    Ver todas as contas em atraso
                                </a>
                            </small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contas vencendo em até 7 dias --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Contas vencendo em até 7 dias</h4>
                        <p class="card-category">Organize o fluxo de caixa com antecedência</p>
                    </div>
                    <div class="card-body">
                        @if(($contasVencendo ?? collect())->isEmpty())
                            <p>Nenhuma conta próxima do vencimento. ✅</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-warning">
                                        <tr>
                                            <th>Vencimento</th>
                                            <th>Descrição</th>
                                            <th>Fornecedor</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contasVencendo as $l)
                                            <tr>
                                                <td>{{ optional($l->data_vencimento)->format('d/m/Y') }}</td>
                                                <td>{{ $l->descricao }}</td>
                                                <td>{{ optional($l->fornecedor)->nome }}</td>
                                                <td>R$ {{ number_format($l->valor_previsto, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                <a href="{{ route('financeiro.contas-pagar', ['status' => 'aberto']) }}">
                                    Ver todas as contas a pagar
                                </a>
                            </small>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
