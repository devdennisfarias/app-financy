@extends('layouts.app', [
    'activePage' => 'convenios',
    'titlePage' => __('Convênios'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Convênios">
                @can('convenios.create')
                    <a href="{{ route('convenios.create') }}" class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Novo Convênio
                    </a>
                @endcan
            </x-page-header>

            <x-session-alerts class="mb-3" />

            {{-- Filtros --}}
            <x-card title="Filtros">
                <form method="GET" action="{{ route('convenios.index') }}">
                    <div class="row align-items-end">

                        <div class="col-md-5">
                            <div class="input-group input-group-static mb-3">
                                <label for="q" class="ms-0">Buscar (nome ou slug)</label>
                                <input type="text" name="q" id="q" class="form-control"
                                    value="{{ $filtros['q'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label for="ativo" class="ms-0">Ativo?</label>
                                <select name="ativo" id="ativo" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1" {{ ($filtros['ativo'] ?? '') === '1' ? 'selected' : '' }}>Sim
                                    </option>
                                    <option value="0" {{ ($filtros['ativo'] ?? '') === '0' ? 'selected' : '' }}>Não
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">search</i> Filtrar
                            </button>
                            <a href="{{ route('convenios.index') }}" class="btn btn-default">
                                Limpar
                            </a>
                        </div>

                    </div>
                </form>
            </x-card>

            {{-- Lista --}}
            <x-card title="Lista de Convênios">
                <x-table :striped="true">
                    <x-slot name="head">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Ativo</th>
                            <th>Atualizado em</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </x-slot>

                    @forelse ($convenios as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->nome }}</td>
                            <td>{{ $c->slug }}</td>
                            <td>
                                @if ($c->ativo)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-secondary">Inativo</span>
                                @endif
                            </td>
                            <td>{{ $c->updated_at ? $c->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="td-actions text-right">
                                @can('convenios.edit')
                                    <a href="{{ route('convenios.edit', $c->id) }}" class="btn btn-info btn-sm" title="Editar">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endcan

                                @can('convenios.destroy')
                                    <form action="{{ route('convenios.destroy', $c->id) }}" method="POST"
                                        style="display:inline-block"
                                        onsubmit="return confirm('Deseja realmente excluir este convênio?');">
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
                            <td colspan="6">Nenhum convênio encontrado.</td>
                        </tr>
                    @endforelse
                </x-table>

                <x-slot name="footerSlot">
                    {{ $convenios->appends($filtros ?? [])->links() }}
                </x-slot>
            </x-card>
        </div>
    </div>
@endsection
