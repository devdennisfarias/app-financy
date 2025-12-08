@extends('layouts.app', [
    'activePage' => 'bancos',
    'titlePage' => __('Bancos / Instituições'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Bancos / Instituições">
                @can('bancos.create')
                    <a href="{{ route('bancos.create') }}" class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Novo Banco
                    </a>
                @endcan
            </x-page-header>

            {{-- Alertas de sessão --}}
            <x-session-alerts class="mb-3" />

            {{-- Filtros --}}
            <x-card title="Filtros">
                <form method="GET" action="{{ route('bancos.index') }}">
                    <div class="row align-items-end">

                        {{-- Tipo de instituição --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="tipo" class="ms-0">Tipo de Instituição</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($tiposInstituicao as $tipoKey => $tipoLabel)
                                        <option value="{{ $tipoKey }}"
                                            {{ ($tipoFiltro ?? '') == $tipoKey ? 'selected' : '' }}>
                                            {{ $tipoLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- UF --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="uf" class="ms-0">UF de Atuação</label>
                                <select name="uf" id="uf" class="form-control">
                                    <option value="">Todas</option>
                                    @foreach ($ufs as $sigla => $nomeUf)
                                        <option value="{{ $sigla }}"
                                            {{ ($ufFiltro ?? '') == $sigla ? 'selected' : '' }}>
                                            {{ $sigla }} - {{ $nomeUf }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Botões --}}
                        <div class="col-md-4 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">search</i> Filtrar
                            </button>
                            <a href="{{ route('bancos.index') }}" class="btn btn-default">
                                Limpar
                            </a>
                        </div>

                    </div>
                </form>
            </x-card>

            {{-- Lista de bancos --}}
            <x-card title="Lista de Bancos / Instituições">
                <x-table :striped="true">
                    <x-slot name="head">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Estados de Atuação</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </x-slot>

                    @forelse($instituicoes as $banco)
                        <tr>
                            <td>{{ $banco->id }}</td>
                            <td>{{ $banco->nome }}</td>
                            <td>{{ $banco->codigo }}</td>
                            <td>
                                @php
                                    $tipos = $tiposInstituicao ?? [];
                                    $tipoLabel = $tipos[$banco->tipo] ?? ucfirst($banco->tipo ?? '—');
                                @endphp
                                {{ $tipoLabel }}
                            </td>
                            <td>
                                @php
                                    $ufsBanco = $banco->ufs ?? collect();
                                @endphp

                                @if ($ufsBanco->isEmpty())
                                    {{-- Sem registro em banco_ufs = todos os estados --}}
                                    <span class="badge badge-info">Todos os estados</span>
                                @else
                                    @foreach ($ufsBanco as $ufRel)
                                        <span class="badge badge-secondary">
                                            {{ $ufRel->uf }}
                                        </span>
                                    @endforeach
                                @endif
                            </td>

                            <td class="td-actions text-right">
                                @can('bancos.edit')
                                    <a href="{{ route('bancos.edit', $banco->id) }}" class="btn btn-info btn-sm"
                                        title="Editar">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endcan

                                @can('bancos.destroy')
                                    <form action="{{ route('bancos.destroy', $banco->id) }}" method="POST"
                                        style="display:inline-block"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este banco?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Nenhum banco encontrado.</td>
                        </tr>
                    @endforelse
                </x-table>

                <x-slot name="footerSlot">
                    {{ $instituicoes->links() }}
                </x-slot>
            </x-card>

        </div>
    </div>
@endsection
