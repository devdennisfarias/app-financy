@extends('layouts.app', [
    'activePage' => 'financeiro-bancos',
    'titlePage' => __('Bancos')
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
                            <h4 class="card-title">Bancos</h4>
                            <p class="card-category">Cadastro de bancos utilizados pela FinancyCred</p>
                        </div>
                        @can('bancos.create')
                            <a href="{{ route('bancos.create') }}" class="btn btn-success btn-sm">
                                <i class="material-icons">add</i> Novo Banco
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        @if($bancos->isEmpty())
                            <p>Nenhum banco cadastrado ainda.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Código</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bancos as $banco)
                                            <tr>
                                                <td>{{ $banco->id }}</td>
                                                <td>{{ $banco->nome }}</td>
                                                <td>{{ $banco->codigo }}</td>
                                                <td class="td-actions text-right">
                                                    @can('bancos.edit')
                                                        <a rel="tooltip" class="btn btn-primary btn-link btn-sm" href="{{ route('bancos.edit', $banco->id) }}">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    @endcan
                                                    @can('bancos.destroy')
                                                        <form action="{{ route('bancos.destroy', $banco->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir este banco?');">
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

                            {{ $bancos->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
