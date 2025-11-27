@extends('layouts.app', [
    'activePage' => 'financeiro-lancamentos',
    'titlePage' => __('Lançamentos Financeiros')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Alerts --}}
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('danger'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('danger') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Filtros + botão novo --}}
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="{{ route('lancamentos.index') }}">
                    <div class="card">
                        <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">Lançamentos Financeiros</h4>
                                <p class="card-category">Receitas, despesas, contas a pagar e receber</p>
                            </div>
                            @can('lancamentos.create')
                                <a href="{{ route('lancamentos.create') }}" class="btn btn-success btn-sm">
                                    <i class="material-icons">add</i> Novo Lançamento
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select name="tipo" class="form-control">
                                            <option value="">Todos</option>
                                            <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                                            <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Natureza</label>
                                        <select name="natureza" class="form-control">
                                            <option value="">Todas</option>
                                            <option value="pagar" {{ request('natureza') == 'pagar' ? 'selected' : '' }}>Pagar</option>
                                            <option value="receber" {{ request('natureza') == 'receber' ? 'selected' : '' }}>Receber</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Todos</option>
                                            <option value="aberto" {{ request('status') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                                            <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                                            <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="material-icons">search</i> Filtrar
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
                    <div class="card-body">

                        @if($lancamentos->isEmpty())
                            <p>Nenhum lançamento encontrado.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo</th>
                                            <th>Natureza</th>
                                            <th>Descrição</th>
                                            <th>Conta</th>
                                            <th>Vencimento</th>
                                            <th>Valor Previsto</th>
                                            <th>Status</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lancamentos as $l)
                                            <tr>
                                                <td>{{ $l->id }}</td>
                                                <td>{{ ucfirst($l->tipo) }}</td>
                                                <td>{{ ucfirst($l->natureza) }}</td>
                                                <td>{{ $l->descricao }}</td>
                                                <td>{{ optional($l->contaBancaria)->nome }}</td>
                                                <td>{{ $l->data_vencimento ? \Carbon\Carbon::parse($l->data_vencimento)->format('d/m/Y') : '-' }}</td>
                                                <td>R$ {{ number_format($l->valor_previsto, 2, ',', '.') }}</td>
                                                <td>{{ ucfirst($l->status) }}</td>
                                                <td class="td-actions text-right">
                                                    @can('lancamentos.edit')
                                                        <a href="{{ route('lancamentos.edit', $l->id) }}" class="btn btn-primary btn-link btn-sm">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    @endcan
                                                    @can('lancamentos.destroy')
                                                        <form action="{{ route('lancamentos.destroy', $l->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir este lançamento?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-link btn-sm">
                                                                <i class="material-icons">delete</i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $lancamentos->links() }}

                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
