@extends('layouts.app', [
    'activePage' => 'orgaos',
    'titlePage' => __('Órgãos Pagadores'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Órgãos Pagadores">
                @can('orgaos.create')
                    <a href="{{ route('orgaos.create') }}" class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Novo Órgão
                    </a>
                @endcan
            </x-page-header>

            <x-session-alerts class="mb-3" />

            {{-- Filtros --}}
            <x-card title="Filtros">
                <form method="GET" action="{{ route('orgaos.index') }}">
                    <div class="row align-items-end">

                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="q" class="ms-0">Buscar (nome)</label>
                                <input type="text" name="q" id="q" class="form-control"
                                    value="{{ $filtros['q'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="convenio_id" class="ms-0">Convênio</label>
                                <select name="convenio_id" id="convenio_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($convenios as $conv)
                                        <option value="{{ $conv->id }}"
                                            {{ ($filtros['convenio_id'] ?? '') == $conv->id ? 'selected' : '' }}>
                                            {{ $conv->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
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

                        <div class="col-md-2 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">search</i> Filtrar
                            </button>
                            <a href="{{ route('orgaos.index') }}" class="btn btn-default">
                                Limpar
                            </a>
                        </div>

                    </div>
                </form>
            </x-card>

            {{-- Lista --}}
            <x-card title="Lista de Órgãos Pagadores">
                <x-table :striped="true">
                    <x-slot name="head">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Convênio</th>
                            <th>Ativo</th>
                            <th>Atualizado em</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </x-slot>

                    @forelse ($orgaos as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->nome }}</td>
                            <td>{{ optional($o->convenio)->nome }}</td>
                            <td>
                                @if ($o->ativo)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-secondary">Inativo</span>
                                @endif
                            </td>
                            <td>{{ $o->updated_at ? $o->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="td-actions text-right">
                                @can('orgaos.edit')
                                    <a href="{{ route('orgaos.edit', $o->id) }}" class="btn btn-info btn-sm" title="Editar">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endcan

                                @can('orgaos.destroy')
                                    <form action="{{ route('orgaos.destroy', $o->id) }}" method="POST"
                                        style="display:inline-block"
                                        onsubmit="return confirm('Deseja realmente excluir este órgão pagador?');">
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
                            <td colspan="6">Nenhum órgão pagador encontrado.</td>
                        </tr>
                    @endforelse
                </x-table>

                <x-slot name="footerSlot">
                    {{ $orgaos->appends($filtros ?? [])->links() }}
                </x-slot>
            </x-card>

        </div>
    </div>
@endsection
