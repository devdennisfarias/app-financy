@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Cadastro de Propostas')])

@section('content')
    <div class="content">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Ocorreu um Erro!</strong>
                <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div id="cliente-nao-encontrado" class="d-none">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Cliente não cadastrado</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Button trigger modal -->
            <button id="modalButton" type="button" rel="tooltip" class="btn btn-success"
                    data-toggle="modal" data-target="#cadastrar_cliente">
                Cadastrar cliente
                <i class="material-icons">add</i>
            </button>

        </div>

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
                            <h4 class="card-title ">Cadastro de Propostas</h4>
                        </div>
                        <form name="cadastro_proposta" method="post" action="{{ route('propostas.store') }}"
                              class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">CPF Cliente</label>
                                                    <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vendedor</label>
                                                    <input value="{{ $user->name }}" readonly="readonly" type="text" class="form-control" name="vendedor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão</label>
                                                    <input id="orgao" type="text" class="form-control"
                                                           name="orgao" value="{{ old('orgao') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                                    
                                                    <select class="form-control" name="tabela_digitada" value="{{ old('tabela_digitada') }}">
                                                        <option value="">Selecione uma Tabela</option>
                                                        @foreach ($tabelas as $tabela)
                                                            <option value="{{ $tabela->nome }}">{{ $tabela->nome }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vigência da Tabela</label>
                                                    <input type="text" class="form-control" name="vigencia_tabela" value="{{ old('vigencia_tabela') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco</label>
                                                    <input id="banco" type="text" class="form-control"
                                                           name="banco" value="{{ old('banco') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Bruto</label>
                                                    <input id="valor_bruto" type="text" class="form-control"
                                                           name="valor_bruto" value="{{ old('valor_bruto') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Líquido Liberado</label>
                                                    <input id="valor_liquido_liberado" type="text" class="form-control"
                                                           name="valor_liquido_liberado" value="{{ old('valor_liquido_liberado') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select id="inputState" class="form-control" name="produto">
                                                        <option value="">Selecione um Produto</option>
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}">{{ $produto->produto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tx de Júros</label>
                                                    <input id="tx_juros" type="text" class="form-control" name="tx_juros" value="{{ old('tx_juros') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor da Parcela</label>
                                                    <input id="valor_parcela" type="text" class="form-control"
                                                           name="valor_parcela" value="{{ old('valor_parcela') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Qtd Parcelas</label>
                                                    <input type="number" class="form-control" name="qtd_parcelas" value="{{ old('qtd_parcelas') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício</label>
                                                    <input id="especie_beneficio_1" readonly="readonly" type="text" class="form-control" name="especie_beneficio_1"
                                                           value="{{ old('especie_beneficio_1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário</label>
                                                    <input id="salario_1" readonly="readonly" type="text" class="form-control"
                                                           name="salario_1" value="{{ old('salario_1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício 2</label>
                                                    <input id="especie_beneficio_2" readonly="readonly" type="text" class="form-control" name="especie_beneficio_2"
                                                           value="{{ old('especie_beneficio_2') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário 2</label>
                                                    <input id="salario_2" readonly="readonly" type="text" class="form-control" name="salario_2"
                                                           value="{{ old('salario_2') }}">
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
                                                    <button type="button" onclick="window.location='{{ route('propostas.index') }}'" class="btn btn-fill btn-danger">Cancelar</button>
                                                    <button type="submit" class="btn btn-fill btn-success">Cadastrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="card-footer">
                                                    
                                                </div>-->
                        </form>
                    </div> <!-- fim card -->
                </div><!-- fim col-12 -->
            </div><!-- fim row -->
        </div><!-- fim container-fluid -->
    </div><!-- Fim content -->

    <!-- Modal  CADASTRO CLIENTE -->
    <div class="modal fade" id="cadastrar_cliente" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div style="max-width: 1200px;" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <strong></strong>
                    </h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="text-align:left" class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="form_clientes" method="post" action="{{ route('clientes.store') }}"
                                      class="form-horizontal">
                                    @csrf
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title ">Formulário de Cadastro</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Nome*</label>
                                                            <input id="nome" type="text" class="form-control" name="nome"
                                                                   value="{{ old('nome') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">CPF*</label>
                                                            <input id="cpfModal" type="text" class="form-control" name="cpf"
                                                                   value="{{ old('cpf') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <label>Nascimento:* &nbsp; </label>
                                                                <input id="data_nascimento" type="date"
                                                                       class="form-control datepicker" name="data_nascimento"
                                                                       value="{{ old('data_nascimento') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="togglebutton">
                                                            <input id="alfabetizado" name="alfabetizado" type="checkbox" value="1"
                                                                   checked>
                                                            <span class="toggle"></span>
                                                            <label>
                                                                Alfabetizado
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="togglebutton">
                                                            <input id="figura_publica" name="figura_publica" type="checkbox"
                                                                   value="1">
                                                            <span class="toggle"></span>
                                                            <label>
                                                                Figura Pública
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">RG</label>
                                                            <input id="rg" type="text" class="form-control" name="rg"
                                                                   value="{{ old('rg') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <label>Expedição: &nbsp; </label>
                                                                <input id="data_exp" type="date" class="form-control"
                                                                       name="data_exp" value="{{ old('data_exp') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Orgão Emissor</label>
                                                            <input id="orgao_emissor" type="text" class="form-control"
                                                                   name="orgao_emissor" value="{{ old('orgao_emissor') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Nome do Pai</label>
                                                            <input id="nome_pai" type="text" class="form-control" name="nome_pai"
                                                                   value="{{ old('nome_pai') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Nome da Mãe*</label>
                                                            <input id="nome_mae" type="text" class="form-control" name="nome_mae"
                                                                   value="{{ old('nome_mae') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Endereço</label>
                                                            <input id="endereco" type="text" class="form-control" name="endereco"
                                                                   value="{{ old('endereco') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Número</label>
                                                            <input id="numero" type="text" class="form-control" name="numero"
                                                                   value="{{ old('numero') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Complemento</label>
                                                            <input id="complemento" type="text" class="form-control"
                                                                   name="complemento" value="{{ old('complemento') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Naturalidade</label>
                                                            <input id="naturalidade" type="text" class="form-control"
                                                                   name="naturalidade" value="{{ old('naturalidade') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Nacionalidade</label>
                                                            <input id="nacionalidade" type="text" class="form-control"
                                                                   name="nacionalidade" value="{{ old('nacionalidade') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Estado Civil</label>
                                                            <input id="estado_civil" type="text" class="form-control"
                                                                   name="estado_civil" value="{{ old('estado_civil') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Orgão</label>
                                                            <input id="orgao_1" type="text" class="form-control" name="orgao_1"
                                                                   value="{{ old('orgao_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Matrícula</label>
                                                            <input id="matricula_1" type="text" class="form-control"
                                                                   name="matricula_1" value="{{ old('matricula_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Especie Beneficio</label>
                                                            <input id="especie_beneficio_1" type="text" class="form-control"
                                                                   name="especie_beneficio_1"
                                                                   value="{{ old('especie_beneficio_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Salário</label>
                                                            <input id="salario_1Modal" type="text" class="form-control"
                                                                   name="salario_1" value="{{ old('salario_1') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Banco</label>
                                                            <input id="banco_conta_1" type="text" class="form-control"
                                                                   name="banco_conta_1" value="{{ old('banco_conta_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Agência</label>
                                                            <input id="agencia_conta_1" type="text" class="form-control"
                                                                   name="agencia_conta_1" value="{{ old('agencia_conta_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Número da Conta</label>
                                                            <input id="conta_bancaria_1" type="text" class="form-control"
                                                                   name="conta_bancaria_1" value="{{ old('conta_bancaria_1') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Orgão 2</label>
                                                            <input id="orgao_2" type="text" class="form-control" name="orgao_2"
                                                                   value="{{ old('orgao_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Matrícula 2</label>
                                                            <input id="matricula_2" type="text" class="form-control"
                                                                   name="matricula_2" value="{{ old('matricula_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Especie Beneficio 2</label>
                                                            <input id="especie_beneficio_2" type="text" class="form-control"
                                                                   name="especie_beneficio_2"
                                                                   value="{{ old('especie_beneficio_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Salário 2</label>
                                                            <input id="salario_2Modal" type="text" class="form-control"
                                                                   name="salario_2" value="{{ old('salario_2') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Banco 2</label>
                                                            <input id="banco_conta_2" type="text" class="form-control"
                                                                   name="banco_conta_2" value="{{ old('banco_conta_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Agência 2</label>
                                                            <input id="agencia_conta_2" type="text" class="form-control"
                                                                   name="agencia_conta_2" value="{{ old('agencia_conta_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Número da Conta 2</label>
                                                            <input id="conta_bancaria_2" type="text" class="form-control"
                                                                   name="conta_bancaria_2" value="{{ old('conta_bancaria_2') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Telefone 1*</label>
                                                            <input id="telefone_1Modal" type="text" class="form-control"
                                                                   name="telefone_1" value="{{ old('telefone_1') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Telefone 2</label>
                                                            <input id="telefone_2Modal" type="text" class="form-control"
                                                                   name="telefone_2" value="{{ old('telefone_2') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Telefone 3</label>
                                                            <input id="telefone_3Modal" type="text" class="form-control"
                                                                   name="telefone_3" value="{{ old('telefone_3') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <div class="form-group">
                                                            <input style="display: none" value="proposta" name="proposta">
                                                            <button type="button" onclick="window.location='{{ route('propostas.create') }}'" class="btn btn-fill btn-danger">Cancelar</button>
                                                            <button type="submit" class="btn btn-fill btn-success">Cadastrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--fim card-body-->

                                    <!--<div class="card-footer">

                                                    </div>-->

                                </form>
                            </div>
                            <!--fim card-->
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
                        $('#cpfModal').val($("#cpf").val());
                    } else {
                        $("#cliente-nao-encontrado").addClass("d-none");
                        $('#orgao').val(data['orgao_1']);
                        $('#salario_1').val(data['salario_1']);
                        $('#especie_beneficio_1').val(data['especie_beneficio_1']);
                        $('#salario_2').val(data['salario_2']);
                        $('#especie_beneficio_2').val(data['especie_beneficio_2']);
                    }
                });
            });
        })
    </script>
@endsection
