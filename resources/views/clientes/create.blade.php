@extends('layouts.app', [
    'activePage' => 'clientes',
    'titlePage' => __('Cadastrar Cliente'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Cadastrar Cliente">
                <a href="{{ route('clientes.index') }}" class="btn btn-default btn-sm">
                    <i class="material-icons">arrow_back</i> Voltar
                </a>
            </x-page-header>

            {{-- Alertas --}}
            <x-session-alerts class="mb-3" />

            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD PRINCIPAL --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Dados do Cliente</h4>
                            <p class="card-category">Preencha os dados para cadastrar um novo cliente</p>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('clientes.store') }}" autocomplete="off">
                                @csrf

                                {{-- DADOS BÁSICOS --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="nome" class="ms-0">
                                                Nome <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="nome" id="nome" class="form-control"
                                                value="{{ old('nome') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="cpf" class="ms-0">
                                                CPF <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="cpf" id="cpf" class="form-control"
                                                value="{{ old('cpf') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="data_nascimento" class="ms-0">
                                                Data de Nascimento <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="data_nascimento" id="data_nascimento"
                                                class="form-control" value="{{ old('data_nascimento') }}" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- DOCUMENTOS / FILIAÇÃO --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="rg" class="ms-0">RG</label>
                                            <input type="text" name="rg" id="rg" class="form-control"
                                                value="{{ old('rg') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="orgao_emissor" class="ms-0">Órgão Emissor</label>
                                            <input type="text" name="orgao_emissor" id="orgao_emissor"
                                                class="form-control" value="{{ old('orgao_emissor') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="nome_mae" class="ms-0">
                                                Nome da Mãe <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="nome_mae" id="nome_mae" class="form-control"
                                                value="{{ old('nome_mae') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="nome_pai" class="ms-0">Nome do Pai</label>
                                            <input type="text" name="nome_pai" id="nome_pai" class="form-control"
                                                value="{{ old('nome_pai') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTATO --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="telefone_1" class="ms-0">
                                                Telefone 1 <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="telefone_1" id="telefone_1" class="form-control"
                                                value="{{ old('telefone_1') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="telefone_2" class="ms-0">Telefone 2</label>
                                            <input type="text" name="telefone_2" id="telefone_2" class="form-control"
                                                value="{{ old('telefone_2') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="telefone_3" class="ms-0">Telefone 3</label>
                                            <input type="text" name="telefone_3" id="telefone_3" class="form-control"
                                                value="{{ old('telefone_3') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="email" class="ms-0">E-mail</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- ENDEREÇO (COMPONENTE CEP + UF) --}}
                                <x-cep-autocomplete />

                                {{-- PERFIL / SITUAÇÃO --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="estado_civil" class="ms-0">Estado Civil</label>
                                            <input type="text" name="estado_civil" id="estado_civil"
                                                class="form-control" value="{{ old('estado_civil') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="nacionalidade" class="ms-0">
                                                Naturalidade / Nacionalidade
                                            </label>
                                            <input type="text" name="nacionalidade" id="nacionalidade"
                                                class="form-control" value="{{ old('nacionalidade') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- CONVÊNIO + ÓRGÃO PAGADOR (COMPONENTE) --}}
                                <x-convenio-orgao-select :convenios="$convenios" :orgaos="$orgaos" :selectedConvenio="null"
                                    :selectedOrgao="old('orgao_id')" />

                                {{-- FLAGS --}}
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-check mt-2">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="alfabetizado"
                                                    value="1" {{ old('alfabetizado') ? 'checked' : '' }}>
                                                Alfabetizado
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-check mt-2">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="figura_publica"
                                                    value="1" {{ old('figura_publica') ? 'checked' : '' }}>
                                                Figura Pública / PEP
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- BOTÃO SALVAR --}}
                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="material-icons">save</i> Salvar
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div> {{-- card-body --}}
                    </div> {{-- card --}}
                </div> {{-- col --}}
            </div> {{-- row --}}

        </div>
    </div>
@endsection
