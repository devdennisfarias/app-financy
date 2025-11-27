@extends('layouts.app', ['activePage' => 'minha-producao', 'titlePage' => __('Minha Produção')])

@section('content')
    <div class="content">
        <div class="container-fluid">            
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Controle de Produção</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Vendedor</th>
                                        <th>Qtd de Pagos</th>
                                        <th>Líquido Pago</th>
                                        <th>Qtd de Digitados</th>
                                        <th>Líquido em Andamento</th>
                                        <th>Qtd de Cancelados</th>
                                        <th>Líquido Cancelado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>{{ $vendedor->name }}</td>
                                            <td>{{ $vendedor->qtdPagos($vendedor->id) }}</td>
                                            <td>{{ 'R$ ' . number_format($vendedor->totalLiqPago($vendedor->id), 2, ',', '.') }}</td>
                                            <td>{{ $vendedor->qtdDigitados($vendedor->id) }}</td>
                                            <td>{{ 'R$ ' . number_format($vendedor->totalEmAndamento($vendedor->id), 2, ',', '.') }}</td>
                                            <td>{{ $vendedor->qtdCancelado($vendedor->id) }}</td>
                                            <td>{{ 'R$ ' . number_format($vendedor->totalLiqCancelado($vendedor->id), 2, ',', '.') }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
