@extends('layouts.app', [
    'activePage' => $activePage ?? 'acessos-externos',
    'titlePage' => __('Acessos Externos'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho + botão novo --}}
            <x-page-header title="Acessos Externos">
                @can('acessos-externos.create')
                    <a href="{{ route('acessos-externos.create') }}" class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Novo Acesso
                    </a>
                @endcan
            </x-page-header>

            {{-- Alertas de sessão (success, error, warning, info) --}}
            <x-session-alerts class="mb-3" />

            {{-- Filtros --}}
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('acessos-externos.index') }}">

                        <x-card bodyClass="pb-2 pt-2">
                            <div class="row align-items-end">

                                {{-- Busca texto --}}
                                <div class="col-md-10">
                                    <div class="input-group input-group-outline my-3 w-100">
                                        <label for="q" class="form-label">Buscar (nome, link ou usuário)</label>
                                        <input type="text" name="q" id="q" class="form-control"
                                            value="{{ $filtros['q'] ?? '' }}">
                                    </div>
                                </div>

                                {{-- Botão filtrar --}}
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block mt-3">
                                        <i class="material-icons">search</i>
                                        Filtrar
                                    </button>
                                </div>

                            </div>
                        </x-card>

                    </form>
                </div>
            </div>

            {{-- Tabela --}}
            <div class="row">
                <div class="col-md-12">
                    <x-card title="Lista de Acessos">
                        <x-slot name="header">
                            <p class="card-category">
                                Bancos, plataformas e sistemas externos
                            </p>
                        </x-slot>

                        @if ($acessos->isEmpty())
                            <p>Nenhum acesso cadastrado.</p>
                        @else
                            <x-table :striped="true">
                                <x-slot name="head">
                                    <tr>
                                        <th>Banco / Sistema</th>
                                        <th>Link</th>
                                        <th>Usuário / Login</th>
                                        <th>Senha</th>
                                        <th>Observação</th>
                                        <th>Atualizado em</th>
                                        <th class="text-right">Ações</th>
                                    </tr>
                                </x-slot>

                                @foreach ($acessos as $acesso)
                                    <tr>
                                        <td>{{ $acesso->nome }}</td>

                                        <td>
                                            @if ($acesso->link)
                                                <a href="{{ $acesso->link }}" target="_blank">
                                                    {{ \Illuminate\Support\Str::limit($acesso->link, 30) }}
                                                </a>
                                            @endif
                                        </td>

                                        <td>{{ \Illuminate\Support\Str::limit($acesso->usuario, 25) }}</td>

                                        <td>{{ $acesso->senha }}</td>

                                        <td>{{ \Illuminate\Support\Str::limit($acesso->observacao, 35) }}</td>

                                        <td>{{ $acesso->updated_at->format('d/m/Y H:i') }}</td>

                                        <td class="td-actions text-right">
                                            {{-- Editar --}}
                                            <a href="{{ route('acessos-externos.edit', $acesso->id) }}"
                                                class="btn btn-info btn-sm" title="Editar">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            {{-- Apagar --}}
                                            <form action="{{ route('acessos-externos.destroy', $acesso->id) }}"
                                                method="POST" style="display:inline-block"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este acesso?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-table>

                            {{-- Paginação --}}
                            <x-slot name="footerSlot">
                                {{ $acessos->appends($filtros ?? [])->links() }}
                            </x-slot>
                        @endif

                    </x-card>
                </div>
            </div>

        </div>
    </div>
@endsection
