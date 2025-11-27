@extends('layouts.app', ['activePage' => 'clientes', 'titlePage' => __('Cadastro de Clientes')])

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



        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
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
                                                    <input id="cpf" type="text" class="form-control" name="cpf"
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
                                                    <input id="salario_1" type="text" class="form-control"
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
                                                    <input id="salario_2" type="text" class="form-control"
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
                                                    <input id="telefone_1" type="text" class="form-control"
                                                           name="telefone_1" value="{{ old('telefone_1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Telefone 2</label>
                                                    <input id="telefone_2" type="text" class="form-control"
                                                           name="telefone_2" value="{{ old('telefone_2') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Telefone 3</label>
                                                    <input id="telefone_3" type="text" class="form-control"
                                                           name="telefone_3" value="{{ old('telefone_3') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <button type="button" onclick="window.location='{{ route('clientes.index') }}'" class="btn btn-fill btn-danger">Cancelar</button>
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
        <!--container-fluid-->
    </div>
    <!--content-->

@endsection

@section('post-script')
@endsection
