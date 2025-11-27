@extends('layouts.app', ['activePage' => 'clientes', 'titlePage' => __('Editar de Clientes')])

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
                        <form id="form_clientes" method="post" action="{{ route('clientes.update', $cliente->id) }}" class="form-horizontal">
                            @method('PUT')
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
                                                    <input id="nome" type="text" class="form-control" name="nome" value="{{ $cliente->nome }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">CPF*</label>
                                                    <input id="cpf" type="text" class="form-control" name="cpf" value="{{ $cliente->cpf }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group date" data-provide="datepicker">
                                                        <label>Nascimento:* &nbsp; </label>
                                                        <input id="data_nascimento" type="date" class="form-control datepicker" name="data_nascimento" value="{{ $cliente->data_nascimento }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="togglebutton">
                                                    <input id="alfabetizado" name="alfabetizado" type="checkbox" value="1" {{ $cliente->alfabetizado == 1 ? 'checked' : '' }}>
                                                    <span class="toggle"></span>
                                                    <label>
                                                        Alfabetizado
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="togglebutton">
                                                    <input id="figura_publica" name="figura_publica" type="checkbox" value="1" {{ $cliente->figura_publica == 1 ? 'checked' : '' }}>
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
                                                    <input id="rg" type="text" class="form-control" name="rg" value="{{ $cliente->rg }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group date" data-provide="datepicker">
                                                        <label>Expedição: &nbsp; </label>
                                                        <input id="data_exp" type="date" class="form-control" name="data_exp" value="{{ $cliente->data_exp }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão Emissor</label>
                                                    <input id="orgao_emissor" type="text" class="form-control" name="orgao_emissor" value="{{ $cliente->orgao_emissor }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nome do Pai</label>
                                                    <input id="nome_pai" type="text" class="form-control" name="nome_pai" value="{{ $cliente->nome_pai }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nome da Mãe*</label>
                                                    <input id="nome_mae" type="text" class="form-control" name="nome_mae" value="{{ $cliente->nome_mae }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Endereço</label>
                                                    <input id="endereco" type="text" class="form-control" name="endereco" value="{{ $cliente->endereco }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Número</label>
                                                    <input id="numero" type="text" class="form-control" name="numero" value="{{ $cliente->numero }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Complemento</label>
                                                    <input id="complemento" type="text" class="form-control" name="complemento" value="{{ $cliente->complemento }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Naturalidade</label>
                                                    <input id="naturalidade" type="text" class="form-control" name="naturalidade" value="{{ $cliente->naturalidade }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nacionalidade</label>
                                                    <input id="nacionalidade" type="text" class="form-control" name="nacionalidade" value="{{ $cliente->nacionalidade }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Estado Civil</label>
                                                    <input id="estado_civil" type="text" class="form-control" name="estado_civil" value="{{ $cliente->estado_civil }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão</label>
                                                    <input id="orgao_1" type="text" class="form-control" name="orgao_1" value="{{ $cliente->orgao_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Matrícula</label>
                                                    <input id="matricula_1" type="text" class="form-control" name="matricula_1" value="{{ $cliente->matricula_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Especie Beneficio</label>
                                                    <input id="especie_beneficio_1" type="text" class="form-control" name="especie_beneficio_1" value="{{ $cliente->especie_beneficio_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário</label>
                                                    <input id="salario_1" type="text" class="form-control" name="salario_1" value="{{ $cliente->salario_1 }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco</label>
                                                    <input id="banco_conta_1" type="text" class="form-control" name="banco_conta_1" value="{{ $cliente->banco_conta_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Agência</label>
                                                    <input id="agencia_conta_1" type="text" class="form-control" name="agencia_conta_1" value="{{ $cliente->agencia_conta_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Número da Conta</label>
                                                    <input id="conta_bancaria_1" type="text" class="form-control" name="conta_bancaria_1" value="{{ $cliente->conta_bancaria_1 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão 2</label>
                                                    <input id="orgao_2" type="text" class="form-control" name="orgao_2" value="{{ $cliente->orgao_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Matrícula 2</label>
                                                    <input id="matricula_2" type="text" class="form-control" name="matricula_2" value="{{ $cliente->matricula_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Especie Beneficio 2</label>
                                                    <input id="especie_beneficio_2" type="text" class="form-control" name="especie_beneficio_2" value="{{ $cliente->especie_beneficio_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário 2</label>
                                                    <input id="salario_2" type="text" class="form-control" name="salario_2" value="{{ $cliente->salario_2 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco 2</label>
                                                    <input id="banco_conta_2" type="text" class="form-control" name="banco_conta_2" value="{{ $cliente->banco_conta_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Agência 2</label>
                                                    <input id="agencia_conta_2" type="text" class="form-control" name="agencia_conta_2" value="{{ $cliente->agencia_conta_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Número da Conta 2</label>
                                                    <input id="conta_bancaria_2" type="text" class="form-control" name="conta_bancaria_2" value="{{ $cliente->conta_bancaria_2 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Telefone 1*</label>
                                                    <input id="telefone_1" type="text" class="form-control" name="telefone_1" value="{{ $cliente->telefone_1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Telefone 2</label>
                                                    <input id="telefone_2" type="text" class="form-control" name="telefone_2" value="{{ $cliente->telefone_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Telefone 3</label>
                                                    <input id="telefone_3" type="text" class="form-control" name="telefone_3" value="{{ $cliente->telefone_3 }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-fill btn-success">Atualizar</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Atualizado em: {{ date('d/m/y - H:m', strtotime($cliente->updated_at)) }}</label>
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
