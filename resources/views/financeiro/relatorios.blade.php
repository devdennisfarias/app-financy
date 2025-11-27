@extends('layouts.app', [
    'activePage' => 'financeiro-relatorios',
    'titlePage' => __('Relatórios Financeiros')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Relatórios Financeiros</h4>
                        <p class="card-category">Em breve você poderá filtrar por período, tipo e status.</p>
                    </div>
                    <div class="card-body">
                        <p>No momento, utilize os filtros da tela de lançamentos para análises rápidas.</p>
                        <p>Podemos evoluir aqui depois para:</p>
                        <ul>
                            <li>Relatório de despesas por período</li>
                            <li>Relatório de receitas por período</li>
                            <li>Fluxo de caixa consolidado</li>
                            <li>Exportação para Excel/PDF</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
