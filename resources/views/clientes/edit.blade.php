@extends('layouts.app', [
    'activePage' => 'clientes',
    'titlePage' => __('Editar Cliente'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <x-page-header title="Editar Cliente">
                <a href="{{ route('clientes.index') }}" class="btn btn-default btn-sm">
                    <i class="material-icons">list</i> Lista de Clientes
                </a>
            </x-page-header>

            <x-session-alerts class="mb-3" />

            <x-card>

                <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- DADOS PESSOAIS --}}
                    <h4 class="mb-3">Dados Pessoais</h4>
                    <div class="row">

                        {{-- Nome --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Nome</label>
                                <input type="text" name="nome" class="form-control"
                                    value="{{ old('nome', $cliente->nome) }}" required>
                            </div>
                        </div>

                        {{-- CPF --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">CPF</label>
                                <input type="text" name="cpf" class="form-control"
                                    value="{{ old('cpf', $cliente->cpf) }}" required>
                            </div>
                        </div>

                        {{-- Data de Nascimento --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Data de Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control"
                                    value="{{ old('data_nascimento', $cliente->data_nascimento ? $cliente->data_nascimento->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- RG --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">RG</label>
                                <input type="text" name="rg" class="form-control"
                                    value="{{ old('rg', $cliente->rg) }}">
                            </div>
                        </div>

                        {{-- Data Expedição --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Data Expedição</label>
                                <input type="date" name="data_exp" class="form-control"
                                    value="{{ old('data_exp', $cliente->data_exp ? $cliente->data_exp->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        {{-- Órgão Emissor --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Órgão Emissor</label>
                                <input type="text" name="orgao_emissor" class="form-control"
                                    value="{{ old('orgao_emissor', $cliente->orgao_emissor) }}">
                            </div>
                        </div>

                        {{-- Estado Civil --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Estado Civil</label>
                                <input type="text" name="estado_civil" class="form-control"
                                    value="{{ old('estado_civil', $cliente->estado_civil) }}">
                            </div>
                        </div>
                    </div>

                    {{-- CONTATO --}}
                    <h4 class="mt-4 mb-3">Contato</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Telefone 1</label>
                                <input type="text" name="telefone_1" class="form-control"
                                    value="{{ old('telefone_1', $cliente->telefone_1) }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Telefone 2</label>
                                <input type="text" name="telefone_2" class="form-control"
                                    value="{{ old('telefone_2', $cliente->telefone_2) }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Telefone 3</label>
                                <input type="text" name="telefone_3" class="form-control"
                                    value="{{ old('telefone_3', $cliente->telefone_3) }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">E-mail</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $cliente->email) }}">
                            </div>
                        </div>
                    </div>

                    {{-- ENDEREÇO --}}
                    <h4 class="mt-4 mb-3">Endereço</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control"
                                    value="{{ old('cep', $cliente->cep) }}">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Endereço</label>
                                <input type="text" name="endereco" id="endereco" class="form-control"
                                    value="{{ old('endereco', $cliente->endereco) }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Número</label>
                                <input type="text" name="numero" class="form-control"
                                    value="{{ old('numero', $cliente->numero) }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Complemento</label>
                                <input type="text" name="complemento" class="form-control"
                                    value="{{ old('complemento', $cliente->complemento) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control"
                                    value="{{ old('bairro', $cliente->bairro) }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control"
                                    value="{{ old('cidade', $cliente->cidade) }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Estado</label>
                                <input type="text" name="estado" id="estado" class="form-control"
                                    value="{{ old('estado', $cliente->estado) }}">
                            </div>
                        </div>
                    </div>

                    {{-- BOTÃO --}}
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="material-icons">save</i> Salvar
                            </button>
                        </div>
                    </div>

                </form>

            </x-card>

        </div>
    </div>
@endsection
