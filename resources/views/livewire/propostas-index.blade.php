<div class="content">
    <div class="container-fluid">

        {{-- Cabeçalho + botão nova proposta --}}
        <x-page-header title="Propostas">
            @can('propostas.create')
                <a href="{{ route('propostas.create') }}" class="btn btn-success btn-sm">
                    <i class="material-icons">add</i> Nova Proposta
                </a>
            @endcan
        </x-page-header>

        {{-- Alertas de sessão --}}
        <x-session-alerts class="mb-3" />

        {{-- Lista de propostas --}}
        <div class="row">
            <div class="col-md-12">

                <x-card title="Lista de Propostas">
                    {{-- Busca rápida no header do card --}}
                    <x-slot name="actions">
                        <div class="d-flex justify-content-end align-items-center" style="gap: 12px;">
                            <div class="input-group input-group-outline my-0" style="min-width: 260px;">
                                <label for="search" class="form-label">Buscar (ID, cliente, CPF...)</label>
                                <input
                                    type="text"
                                    id="search"
                                    class="form-control"
                                    placeholder="Digite para filtrar"
                                    wire:model.debounce.500ms="search"
                                >
                            </div>
                        </div>
                    </x-slot>

                    @if ($propostas->isEmpty())
                        <p>Nenhuma proposta encontrada.</p>
                    @else

                        <x-table :striped="true">
                            <x-slot name="head">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>CPF</th>
                                    <th>Produto</th>
                                    <th>Banco</th>
                                    <th class="text-right">Valor Líquido</th>
                                    <th>Status</th>
                                    <th>Criada em</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </x-slot>

                            @foreach ($propostas as $proposta)
                                <tr>
                                    <td>{{ $proposta->id }}</td>

                                    <td>{{ optional($proposta->cliente)->nome ?? '-' }}</td>

                                    <td>{{ optional($proposta->cliente)->cpf ?? '-' }}</td>

                                    <td>{{ optional($proposta->produto)->produto ?? '-' }}</td>

                                    <td>
                                        @php
                                            $nomeBanco = optional($proposta->banco)->nome
                                                ?? $proposta->banco
                                                ?? '-';
                                        @endphp
                                        {{ \Illuminate\Support\Str::limit($nomeBanco, 20) }}
                                    </td>

                                    <td class="text-right">
                                        @if (!is_null($proposta->valor_liquido_liberado))
                                            R$
                                            {{ number_format($proposta->valor_liquido_liberado, 2, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        {{ optional($proposta->status_atual)->status ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $proposta->created_at ? $proposta->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td class="td-actions text-right">
                                        @can('propostas.edit')
                                            <a href="{{ route('propostas.edit', $proposta->id) }}"
                                               class="btn btn-info btn-sm" title="Editar">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        @endcan

                                        @can('propostas.destroy')
                                            <form action="{{ route('propostas.destroy', $proposta->id) }}"
                                                  method="POST"
                                                  style="display:inline-block"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta proposta?');">
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
                            {{ $propostas->links('vendor.pagination.simple-creative-tim') }}
                        </x-slot>

                    @endif

                </x-card>

            </div>
        </div>

    </div>
</div>
