@extends('layouts.app', [
    'activePage' => 'contas-bancarias',
    'titlePage' => __('Contas Bancárias')
])

@section('content')
<div class="content">
    <div class="container-fluid">

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

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Contas Bancárias</h4>
                            <p class="card-category">Contas utilizadas para movimentação financeira</p>
                        </div>
                        @can('contas-bancarias.create')
                            <a href="{{ route('contas-bancarias.create') }}" class="btn btn-success btn-sm">
                                <i class="material-icons">add</i> Nova Conta
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">

                        @if($contas->isEmpty())
                            <p>Nenhuma conta bancária cadastrada ainda.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Banco</th>
                                            <th>Agência</th>
                                            <th>Conta</th>
                                            <th>Tipo</th>
                                            <th>Saldo Inicial</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contas as $conta)
                                            <tr>
                                                <td>{{ $conta->id }}</td>
                                                <td>{{ $conta->nome }}</td>
                                                <td>{{ optional($conta->banco)->nome }}</td>
                                                <td>{{ $conta->agencia }}</td>
                                                <td>{{ $conta->conta }}</td>
                                                <td>{{ $conta->tipo_conta }}</td>
                                                <td>R$ {{ number_format($conta->saldo_inicial, 2, ',', '.') }}</td>
                                                <td class="td-actions text-right">
                                                    @can('contas-bancarias.edit')
                                                        <a rel="tooltip" class="btn btn-primary btn-link btn-sm" href="{{ route('contas-bancarias.edit', $conta->id) }}">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    @endcan
                                                    @can('contas-bancarias.destroy')
                                                        <form action="{{ route('contas-bancarias.destroy', $conta->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir esta conta bancária?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" rel="tooltip" class="btn btn-danger btn-link btn-sm">
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

                            {{ $contas->links() }}
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
