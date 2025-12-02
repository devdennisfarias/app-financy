@extends('layouts.app', [
    'activePage' => 'bancos',
    'titlePage' => isset($banco) ? __('Editar Instituição') : __('Cadastro de Instituição'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">
                                {{ isset($banco) ? 'Editar Instituição' : 'Cadastrar Instituição' }}
                            </h4>
                            <p class="card-category">
                                Informe os dados da instituição (Banco, Promotora, Fintech, etc.) e seus estados de atuação
                            </p>
                        </div>

                        <div class="card-body">
                            {{-- Erros de validação --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @php
                                $editMode = isset($banco);

                                // UFs selecionadas (prioridade: old() -> variáveis da view -> banco)
                                $ufsSelecionadas = old(
                                    'ufs',
                                    $ufsSelecionadas ??
                                        ($editMode && method_exists($banco, 'ufs')
                                            ? $banco->ufs->pluck('uf')->toArray()
                                            : []),
                                );

                                // tipos disponíveis
                                $tiposInstituicao = [
                                    'banco' => 'Banco',
                                    'promotora' => 'Promotora',
                                    'fintech' => 'Fintech',
                                    'corresp' => 'Correspondente',
                                    'outro' => 'Outro',
                                ];
                            @endphp

                            <form method="POST"
                                action="{{ isset($banco) ? route('bancos.update', $banco->id) : route('bancos.store') }}">

                                @csrf
                                @if ($editMode)
                                    @method('PUT')
                                @endif

                                {{-- Linha 1: Nome + Código --}}
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating" for="nome">
                                                Nome da Instituição
                                            </label>
                                            <input type="text" name="nome" id="nome"
                                                value="{{ old('nome', $editMode ? $banco->nome : '') }}"
                                                class="form-control">
                                            @error('nome')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating" for="codigo">
                                                Código (opc.)
                                            </label>
                                            <input type="text" name="codigo" id="codigo"
                                                value="{{ old('codigo', $editMode ? $banco->codigo : '') }}"
                                                class="form-control">
                                            @error('codigo')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                {{-- Linha 2: Estados de atuação (multiselect) --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ufs">
                                                Estados de atuação
                                            </label>
                                            <select name="ufs[]" id="ufs" class="form-control" multiple>
                                                @foreach ($ufs as $sigla => $nome)
                                                    <option value="{{ $sigla }}"
                                                        {{ collect($ufsSelecionadas)->contains($sigla) ? 'selected' : '' }}>
                                                        {{ $sigla }} - {{ $nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ufs')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                            @error('ufs.*')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Segure <strong>CTRL (Windows)</strong> ou <strong>Command (Mac)</strong>
                                                para selecionar vários estados.
                                            </small>
                                        </div>
                                    </div>

                                    {{-- Tipo da instituição --}}
                                    <div class="col-md-6">
                                        <div class="input-group input-group-dynamic">
                                            <label for="tipo" class="form-label">
                                                Tipo da Instituição
                                            </label>
                                            <select name="tipo" id="tipo" class="form-control">
                                                @foreach ($tiposInstituicao as $valor => $label)
                                                    <option value="{{ $valor }}"
                                                        {{ old('tipo', $editMode ? $banco->tipo ?? 'banco' : 'banco') == $valor ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipo')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Botões --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('bancos.index') }}" class="btn btn-secondary pull-right ml-2">
                                            Voltar
                                        </a>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            {{ $editMode ? 'Atualizar' : 'Salvar' }}
                                        </button>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
