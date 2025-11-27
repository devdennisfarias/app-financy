@extends('layouts.app', [
    'activePage' => 'financeiro-contas-receber',
    'titlePage'  => __('Contas a Receber')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('financeiro.contas-receber') }}">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Contas a Receber</h4>
                    <p class="card-category">Filtre por status, cliente e período</p>
                </div>

                <div class="card-body">
                    <div class="row align-items-end">

                        {{-- Status --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Status</label>
                                @php
                                    $statusSelecionado = $filtros['status'] ?? 'aberto';
                                @endphp
                                <select name="status" class="form-control">
                                    <option value="todos"    {{ $statusSelecionado === 'todos' ? 'selected' : '' }}>Todos</option>
                                    <option value="aberto"   {{ $statusSelecionado === 'aberto' ? 'selected' : '' }}>Em aberto</option>
                                    <option value="pago"     {{ $statusSelecionado === 'pago' ? 'selected' : '' }}>Recebido</option>
                                    <option value="atrasado" {{ $statusSelecionado === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                    <option value="cancelado"{{ $statusSelecionado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                        </div>

                        {{-- Cliente --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cliente</label>
                                @php
                                    $clienteSelecionado = $filtros['cliente_id'] ?? null;
                                @endphp
                                <select name="cliente_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ (string)$clienteSelecionado === (string)$cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Vencimento a partir de --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Vencimento a partir de</label>
                                <input type="date"
                                       name="data_inicio"
                                       class="form-control"
                                       value="{{ $filtros['data_inicio'] ?? '' }}">
                            </div>
                        </div>

                        {{-- Vencimento até --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Até</label>
                                <input type="date"
                                       name="data_fim"
                                       class="form-control"
                                       value="{{ $filtros['data_fim'] ?? '' }}">
                            </div>
                        </div>

                        {{-- Botões --}}
                        <div class="col-md-3 d-flex justify-content-start">
                            <div class="form-group mb-0 mr-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="material-icons">search</i> Filtrar
                                </button>
                            </div>

                            <div class="form-group mb-0">
                                <a href="{{ route('financeiro.contas-receber') }}" class="btn btn-default btn-sm">
                                    Limpar filtros
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer: botão nova conta a receber --}}
                <div class="card-footer">
                    <a href="{{ route('lancamentos.create', ['natureza' => 'receber']) }}"
                       class="btn btn-success btn-sm">
                        <i class="material-icons">add</i> Nova conta a receber
                    </a>
                </div>
            </div>
        </form>

        {{-- LISTA DE CONTAS A RECEBER --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header card-header-success">
                        <h4 class="card-title">Resultados</h4>
                        <p class="card-category">
                            Natureza: <strong>Receber</strong>
                            @if(!empty($statusSelecionado) && $statusSelecionado !== 'todos')
                                | Status: <strong>{{ ucfirst($statusSelecionado) }}</strong>
                            @endif
                        </p>
                    </div>

                    <div class="card-body">
                        @if($lancamentos->isEmpty())
                            <p>Nenhuma conta encontrada com os filtros atuais.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-success">
                                        <tr>
                                            <th>Vencimento</th>
                                            <th>Descrição</th>
                                            <th>Cliente</th>
                                            <th>Conta Bancária</th>
                                            <th class="text-right">Valor</th>
                                            <th>Status</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lancamentos as $l)
                                            @php
                                                $classeStatus = match ($l->status) {
                                                    'pago'      => 'badge-success',
                                                    'aberto'    => 'badge-warning',
                                                    'atrasado'  => 'badge-danger',
                                                    'cancelado' => 'badge-secondary',
                                                    default     => 'badge-light',
                                                };
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $l->data_vencimento ? \Carbon\Carbon::parse($l->data_vencimento)->format('d/m/Y') : '-' }}
                                                </td>
                                                <td>{{ $l->descricao }}</td>
                                                <td>{{ optional($l->cliente)->nome ?? '-' }}</td>
                                                <td>{{ optional($l->contaBancaria)->nome ?? '-' }}</td>
                                                <td class="text-right">
                                                    R$ {{ number_format($l->valor_previsto ?? 0, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ $classeStatus }}">
                                                        {{ ucfirst($l->status) }}
                                                    </span>
                                                </td>
                                                <td class="td-actions text-right">
                                                    @can('lancamentos.edit')
                                                        <a href="{{ route('lancamentos.edit', $l->id) }}"
                                                           class="btn btn-primary btn-link btn-sm"
                                                           title="Editar">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    @endcan

                                                    @can('lancamentos.destroy')
                                                        <form action="{{ route('lancamentos.destroy', $l->id) }}"
                                                              method="POST"
                                                              style="display:inline-block;"
                                                              onsubmit="return confirm('Deseja realmente excluir este lançamento?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-link btn-sm"
                                                                    title="Excluir">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $lancamentos->appends($filtros ?? [])->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
