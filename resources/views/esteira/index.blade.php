@extends('layouts.app', ['activePage' => 'esteira', 'titlePage' => __('Esteira de Produção')])

@section('content')
    <div class="content">

        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong></strong> {{ session('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title text-center">Acompanhamento de Propostas Digitadas</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('esteira.index') }}" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Número Nexus</label>
                                        <input type="text" class="form-control" name="numero_nexus">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="inputState" class="form-control" name="vendedor">
                                            <option value="">Vendedores</option>
                                            @foreach ($vendedores as $vendedor)
                                                <option value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">CPF</label>
                                        <input id="cpf" type="text" class="form-control" name="cpf">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="label">Data Inicial</label>
                                        <input type="date" class="form-control" name="data_inicial">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="label">Data Final</label>
                                        <input type="date" class="form-control" name="data_final">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="inputState" class="form-control" name="status_tipo_id">
                                            <option value="">Tipo Status</option>
                                            @foreach ($status_tipos as $status_tipo)
                                                <option value="{{ $status_tipo->id }}">{{ $status_tipo->tipo_status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-fill btn-info">
                                        <i class="material-icons">search</i>
                                        Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- card-body-->
                    <!--<div class="card-footer">

                                        </div>-->
                </div><!-- card-->

            </div><!-- row-->

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabela-resultados" class="table">
                                <thead>
                                    <tr>
                                        <th>Nº Nexus</th>
                                        <th>Vendedor</th>
                                        <th>Banco</th>
                                        <th>Orgão</th>
                                        <th>Tabela</th>
                                        <th>Vigência</th>
                                        <th>Bruto</th>
                                        <th>Líquido</th>
                                        <th>TX Juros</th>
                                        <th>Parcela</th>
                                        <th>Prazo</th>
                                        <th>Status</th>
                                        <th class="text-right">Ações</th>
                                    </tr>
                                </thead>

                                <tbody id="esteira-all">
                                    @foreach ($propostas as $proposta)
                                        <tr>
                                            <td> {{ $proposta->id }} </td>
                                            <td> {{ $proposta->vendedor->name }} </td>
                                            <td> {{ $proposta->banco }} </td>
                                            <td> {{ $proposta->orgao }} </td>
                                            <td> {{ $proposta->tabela_digitada }} </td>
                                            <td> {{ $proposta->vigencia_tabela }} </td>
                                            <td> {{ 'R$ ' . number_format($proposta->valor_bruto, 2, ',', '.') }} </td>
                                            <td> {{ 'R$ ' . number_format($proposta->valor_liquido_liberado, 2, ',', '.') }} </td>
                                            <td> {{ $proposta->tx_juros }} </td>
                                            <td> {{ 'R$ ' . number_format($proposta->valor_parcela, 2, ',', '.') }} </td>
                                            <td> {{ $proposta->qtd_parcelas }} </td>
                                            <td> {{ $proposta->status_atual->status }} </td>

                                            <td class="td-actions text-right">
                                                <!-- Button trigger modal -->
                                                <button type="button" rel="tooltip" class="btn btn-success"
                                                        data-toggle="modal" data-target="#id{{ $proposta->id }}">
                                                    <i class="material-icons">remove_red_eye</i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="id{{ $proposta->id }}" tabindex="-1"
                                                     role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div style="max-width: 1200px;" class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Numero Nexus: <strong>{{ $proposta->id }}</strong>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div style="text-align:left" class="modal-body">

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">CPF Cliente</label>
                                                                            <span class="form-control">{{ $proposta->cliente->cpf }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Vendedor</label>
                                                                            <span class="form-control">{{ $proposta->vendedor->name }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Orgão</label>
                                                                            <span class="form-control">{{ $proposta->orgao }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Tabela Digitada</label>
                                                                            <span class="form-control">{{ $proposta->tabela_digitada }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Vigência da Tabela</label>
                                                                            <span class="form-control">{{ $proposta->vigencia_tabela }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Banco</label>
                                                                            <span class="form-control">{{ $proposta->banco }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Valor Bruto</label>
                                                                            <span id="valor_bruto" class="form-control">{{ number_format($proposta->valor_bruto, 2, ',', '.') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Valor Líquido Liberado</label>
                                                                            <span id="valor_liquido_liberado" class="form-control">{{ number_format($proposta->valor_liquido_liberado, 2, ',', '.') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Produto</label>
                                                                            <span class="form-control">{{ $proposta->produto->produto }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Tx de Júros</label>
                                                                            <span id="tx_juros" class="form-control">{{ number_format($proposta->tx_juros, 1, ',', '.') . ' %' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Valor da Parcela</label>
                                                                            <span class="form-control">{{ number_format($proposta->valor_parcela, 2, ',', '.') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Qtd Parcelas</label>
                                                                            <span class="form-control">{{ $proposta->qtd_parcelas }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Espécie Benefício</label>
                                                                            <span class="form-control">{{ $proposta->cliente->especie_beneficio_1 }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Salário</label>
                                                                            <span id="salario_1" class="form-control">{{ number_format($proposta->cliente->salario_1, 2, ',', '.') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Espécie Benefício 2</label>
                                                                            <span class="form-control">{{ $proposta->cliente->especie_beneficio_2 }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating">Salário 2</label>
                                                                            <span id="salario_2" class="form-control">{{ number_format($proposta->cliente->salario_2, 2, ',', '.') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Fechar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('esteira.edit')
                                                    <a href="{{ route('esteira.edit', $proposta->id) }}">
                                                        <button type="button" rel="tooltip" class="btn btn-info">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                <a target="_blank" href="{{ route('proposta.pdf', $proposta->id) }}">
                                                    <button type="button" rel="tooltip" class="btn btn-warning">
                                                        <i class="material-icons">print</i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div>
                    <div class="card-footer">
                        {{ $propostas->links() }}
                    </div>
                </div>
            </div>
        </div><!-- container-fluid-->
    </div><!-- content-->
@endsection
@section('post-script')
@endsection
