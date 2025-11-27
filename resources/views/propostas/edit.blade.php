@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Editar de Proposta')])

@section('content')
    <div class="content">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cadastro de Proposta</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <form name="cadastro_proposta" method="post"
                                          action="{{ route('propostas.update', $proposta->id) }}" class="form-horizontal"
                                          enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Número Nexus</label>
                                                    <input readonly="readonly" type="text" class="form-control" name="numero_nexus"
                                                           value="{{ $proposta->id }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">CPF Cliente</label>
                                                    <input readonly="readonly" id="cpf" type="text" class="form-control"
                                                           name="cpf" value="{{ $cliente->cpf }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vendedor</label>
                                                    <input readonly="readonly" type="text" class="form-control" name="vendedor"
                                                           value="{{ $proposta->vendedor->name }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão</label>
                                                    <input id="orgao" type="text" class="form-control"
                                                           name="orgao" value="{{ $proposta->orgao }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <select readonly="readonly" class="form-control" name="tabela_digitada">
                                                            <option value="{{ $proposta->tabela_digitada }}">{{ $proposta->tabela_digitada }}</option>                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vigência da Tabela</label>
                                                    <input type="text" class="form-control" name="vigencia_tabela"
                                                           value="{{ $proposta->vigencia_tabela }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco</label>
                                                    <input id="banco" type="text" class="form-control"
                                                           name="banco" value="{{ $proposta->banco }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Bruto</label>
                                                    <input id="valor_bruto" type="text" class="form-control"
                                                           name="valor_bruto" value="{{ $proposta->valor_bruto }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Líquido Liberado</label>
                                                    <input id="valor_liquido_liberado" type="text" class="form-control"
                                                           name="valor_liquido_liberado"
                                                           value="{{ $proposta->valor_liquido_liberado }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select readonly="readonly" id="inputState" class="form-control" name="produto">
                                                        <option value="{{ $proposta->produto->id }}">{{ $proposta->produto->produto }}</option>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tx de Júros</label>
                                                    <input id="tx_juros" type="text" class="form-control" name="tx_juros"
                                                           value="{{ $proposta->tx_juros }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor da Parcela</label>
                                                    <input id="valor_parcela" type="text" class="form-control"
                                                           name="valor_parcela" value="{{ $proposta->valor_parcela }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Qtd Parcelas</label>
                                                    <input type="number" class="form-control" name="qtd_parcelas"
                                                           value="{{ $proposta->qtd_parcelas }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício</label>
                                                    <input readonly="readonly" type="text" class="form-control" name="especie_beneficio_1"
                                                           value="{{ $proposta->cliente->especie_beneficio_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário</label>
                                                    <input id="salario_1" readonly="readonly" type="text" class="form-control"
                                                           name="salario_1" value="{{ $proposta->cliente->salario_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício 2</label>
                                                    <input readonly="readonly" type="text" class="form-control" name="especie_beneficio_2"
                                                           value="{{ $proposta->cliente->especie_beneficio_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário 2</label>
                                                    <input id="salario_2" readonly="readonly" type="text" class="form-control" name="salario_2"
                                                           value="{{ $proposta->cliente->salario_2 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="btn btn-success" for="file">
                                                        <i class="material-icons">books</i>
                                                        <span>Selecionar documentos</span>
                                                    </label>
                                                    <input id="file" style="display:none" type="file" name="documentos[]" multiple>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-fill btn-success">Atualizar</button>
                                                </div>
                                            </div>
                                        <!--</div>

                                        <div class="card-footer ">-->                                            
                                        </div>
                                    </form>
                                    
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Documentos</th>
                                                        <th class="text-right">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($proposta->documentos as $documento)
                                                        <tr>
                                                            <td>
                                                                @if ($documento->extencao != 'pdf')
                                                                    <img width="300"
                                                                         src="{{ asset('storage') }}/public/{{ $documento->path }}"
                                                                         alt="">
                                                                @else
                                                                    <a target="_blank" href="{{ asset('storage') }}/public/{{ $documento->path }}"><span>{{ $documento->path }}</span></a>
                                                                @endif

                                                            </td>
                                                            <td class="td-actions text-right">
                                                                <form class="d-inline"
                                                                      action="{{ route('proposta.deletar-doc', $documento->id) }}"
                                                                      method="POST"
                                                                      onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" rel="tooltip"
                                                                            class="btn btn-danger">
                                                                        <i class="material-icons">close</i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div><!-- table-responsive -->

                                </div>
                            </div>
                        </div>
                    </div> <!-- fim card -->
                </div><!-- fim col-12 -->
            </div><!-- fim row -->


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Atendimentos</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descrição</th>
                                                    <th>Status</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($atendimentos as $atendimento)
                                                    @if ($atendimento->proposta_id == $proposta->id)
                                                        <tr>
                                                            <td>{{ $atendimento->id }}</td>
                                                            <td>{{ $atendimento->descricao }}</td>
                                                            <td>{{ $atendimento->status->status }}</td>
                                                            <td>
                                                                <!-- Button trigger modal -->
                                                                <button type="button" rel="tooltip" class="btn btn-info btn-sm"
                                                                        data-toggle="modal" data-target="#id{{ $atendimento->id }}">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="id{{ $atendimento->id }}" tabindex="-1"
                                                                     role="dialog" aria-labelledby="exampleModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                                    <strong>{{ $atendimento->id }}</strong>
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <strong>Descrição:</strong><br>
                                                                                {{ $atendimento->descricao }}<br>
                                                                                <strong>Status:</strong>
                                                                                {{ $atendimento->status->status }}<br>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger"
                                                                                        data-dismiss="modal">Fechar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- fim card -->
                </div><!-- fim col-12 -->
            </div><!-- fim row -->


        </div><!-- fim container-fluid -->
    </div><!-- Fim content -->

@endsection

@section('post-script')
    <script>
        $(document).ready(function() {
            $("#cpf").blur(function() {
                data = $("#cpf").val();
                $.get("{{ route('propostas.consulta-cpf') }}", {
                    cpf: data
                }, function(data, status) {
                    if (data == false) {
                        $("#cliente-nao-encontrado").removeClass("d-none");
                    } else {
                        $("#cliente-nao-encontrado").addClass("d-none");
                        $('#orgao').val(data['orgao_1']);
                    }
                });
            });
        })
    </script>
@endsection
