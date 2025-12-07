<div class="content">
    <div class="container-fluid">

        {{-- Cabeçalho + botão novo --}}
        <x-page-header title="Clientes">
            @can('clientes.create')
                <a href="{{ route('clientes.create') }}" class="btn btn-success btn-sm">
                    <i class="material-icons">add</i> Novo Cliente
                </a>
            @endcan
        </x-page-header>

        {{-- Alertas de sessão (success, error, etc.) --}}
        <x-session-alerts class="mb-3" />

        <div class="row">
            <div class="col-md-12">

                <x-card title="Lista de Clientes">
                    {{-- Filtros / Busca no header --}}
                    <x-slot name="actions">
                        <div class="input-group input-group-outline my-0" style="min-width: 260px;">
                            <label for="search" class="form-label">Buscar por nome</label>
                            <input type="text" id="search" class="form-control"
                                placeholder="Digite o nome do cliente" wire:model.debounce.500ms="search">
                        </div>
                    </x-slot>

                    @if ($clientes->isEmpty())
                        <p>Nenhum cliente encontrado.</p>
                    @else
                        <x-table :striped="true">
                            <x-slot name="head">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Telefone</th>
                                    <th>Cidade</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </x-slot>

                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nome }}</td>
                                    <td>{{ $cliente->cpf }}</td>
                                    <td>{{ $cliente->telefone ?? ($cliente->telefone_1 ?? '-') }}</td>
                                    <td>{{ $cliente->cidade ?? '-' }}</td>

                                    <td class="td-actions text-right">
                                        {{-- Visualizar (se tiver rota show ou modal depois) --}}
                                        {{-- <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-secondary btn-sm" title="Detalhes">
                                            <i class="material-icons">visibility</i>
                                        </a> --}}

                                        {{-- Editar --}}
                                        @can('clientes.edit')
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-info btn-sm"
                                                title="Editar">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        @endcan

                                        {{-- Apagar --}}
                                        @can('clientes.destroy')
                                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                                style="display:inline-block"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>

                        <x-slot name="footerSlot">
                            {{ $clientes->links('vendor.pagination.simple-creative-tim') }}
                        </x-slot>
                    @endif

                </x-card>

            </div>
        </div>

    </div>
</div>
