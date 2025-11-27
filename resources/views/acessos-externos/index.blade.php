@extends('layouts.app', [
    'activePage' => $activePage ?? 'acessos-externos',
    'titlePage'  => __('Acessos Externos')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Cabeçalho + botão novo --}}
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Acessos Externos</h3>

                @can('acessos-externos.create')
                    <a href="{{ route('acessos-externos.create') }}" class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Novo Acesso
                    </a>
                @endcan
            </div>
        </div>

        {{-- Alertas --}}
        @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="{{ route('acessos-externos.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row align-items-end">
                                {{-- Banco / Sistema --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="banco">Banco / Sistema</label>
                                        <select name="banco" id="banco" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach($bancos as $nomeBanco => $nomeBancoExibicao)
                                                <option value="{{ $nomeBanco }}"
                                                    {{ ($filtros['banco'] ?? '') == $nomeBanco ? 'selected' : '' }}>
                                                    {{ $nomeBancoExibicao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Busca texto --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="q">Buscar</label>
                                        <input type="text"
                                               name="q"
                                               id="q"
                                               class="form-control"
                                               placeholder="Nome, link ou usuário..."
                                               value="{{ $filtros['q'] ?? '' }}">
                                    </div>
                                </div>

                                {{-- Botão filtrar --}}
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="material-icons">search</i>
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabela --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Lista de Acessos</h4>
                        <p class="card-category">Bancos, plataformas e sistemas externos</p>
                    </div>
                    <div class="card-body">

                        @if($acessos->isEmpty())
                            <p>Nenhum acesso cadastrado.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Banco / Sistema</th>
                                            <th>Link</th>
                                            <th>Usuário / Login</th>
                                            <th>Senha</th>
                                            <th>Observação</th>
                                            <th>Atualizado em</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
																		<tbody>
																		@foreach($acessos as $acesso)

																		<tr>
																				<td>{{ $acesso->nome }}</td>

																				<td>
																						@if($acesso->link)
																								<a href="{{ $acesso->link }}" target="_blank">
																										{{ \Illuminate\Support\Str::limit($acesso->link, 30) }}
																								</a>
																						@endif
																				</td>

																				<td>{{ \Illuminate\Support\Str::limit($acesso->usuario, 25) }}</td>

																				<td>{{ $acesso->senha }}</td>

																				<td>{{ \Illuminate\Support\Str::limit($acesso->observacao, 35) }}</td>

																				<td>{{ $acesso->updated_at->format('d/m/Y H:i') }}</td>

																				<td class="text-right">
																						<a href="{{ route('acessos-externos.edit', $acesso->id) }}" class="btn btn-sm btn-primary">Editar</a>
																				</td>
																		</tr>

																		@endforeach
																		</tbody>

                                </table>
                            </div>

                            {{-- Paginação --}}
                            <div class="mt-3">
                                {{ $acessos->appends($filtros ?? [])->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
