@extends('layouts.app', [
    'activePage' => 'bancos',
    'titlePage' => __('Instituições'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Card de filtros + listagem --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Instituições (Bancos / Promotoras / Fintechs)</h4>
                            <p class="card-category">
                                Gerencie as instituições financeiras e seus estados de atuação
                            </p>
                        </div>

                        <div class="card-body">

                            {{-- Filtros --}}
                            <form method="GET" action="{{ route('bancos.index') }}" class="mb-3">
                                <div class="row">

                                    {{-- Filtro por tipo --}}
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label for="tipo">Tipo da instituição</label>
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value="">Todos</option>
                                                @foreach ($tiposInstituicao as $valor => $label)
                                                    <option value="{{ $valor }}"
                                                        {{ $tipoFiltro === $valor ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Filtro por UF --}}
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label for="uf" >Estado de atuação</label>
                                            <select name="uf" id="uf" class="form-control">
                                                <option value="">Todos</option>
                                                @foreach ($ufs as $sigla => $nome)
                                                    <option value="{{ $sigla }}"
                                                        {{ $ufFiltro === $sigla ? 'selected' : '' }}>
                                                        {{ $sigla }} - {{ $nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Botões de filtro --}}
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            Filtrar
                                        </button>
                                        <a href="{{ route('bancos.index') }}" class="btn btn-default">
                                            Limpar
                                        </a>
                                    </div>

                                </div>
                            </form>

                            {{-- Botão novo --}}
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('bancos.create') }}" class="btn btn-primary">
                                        Nova Instituição
                                    </a>
                                </div>
                            </div>

                            {{-- Tabela de instituições --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Código</th>
                                            <th>Estados de atuação</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($instituicoes as $inst)
                                            <tr>
                                                <td>{{ $inst->nome }}</td>
                                                <td>
                                                    {{ $tiposInstituicao[$inst->tipo] ?? ucfirst($inst->tipo) }}
                                                </td>
                                                <td>{{ $inst->codigo ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $ufsInst = $inst->ufs->pluck('uf')->toArray();
                                                    @endphp

                                                    @if (empty($ufsInst))
                                                        <span class="badge badge-info">Todos os estados</span>
                                                    @else
                                                        {{ implode(', ', $ufsInst) }}
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('bancos.edit', $inst->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        Editar
                                                    </a>
                                                    {{-- Se tiver exclusão:
                                                <form action="{{ route('bancos.destroy', $inst->id) }}"
                                                      method="POST"
                                                      style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Confirma a exclusão?')">
                                                        Excluir
                                                    </button>
                                                </form>
                                                --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    Nenhuma instituição encontrada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Paginação --}}
                            <div class="row">
                                <div class="col-md-12">
                                    {{ $instituicoes->links() }}
                                </div>
                            </div>

                        </div>{{-- card-body --}}
                    </div>{{-- card --}}
                </div>
            </div>

        </div>
    </div>
@endsection
