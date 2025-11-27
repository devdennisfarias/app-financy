@extends('layouts.app', ['activePage' => 'metas', 'titlePage' => __('Metas')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @can('metas.create')
                    <a href="{{ route('metas.create') }}" class="btn btn-sm btn btn-success"><i
                           class="material-icons">add</i> Adicionar</a>
                @endcan
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Metas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Produto</th>
                                        <th>Quantidade de Vendas</th>
                                        <th class="text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($metas as $meta)
                                        <tr>
                                            <td class="text-center">{{ $meta->id }}</td>
                                            <td> {{ $meta->nome }} </td>
                                            <td> {{ $meta->descricao }} </td>
                                            <td> {{ $meta->produto->produto }} </td>
                                            <td> {{ $meta->qtd_vendas }} </td>
                                            <td class="td-actions text-right">
                                                @can('metas.edit')
                                                    <a href="{{ route('metas.edit', $meta->id) }}">
                                                        <button type="button" rel="tooltip" class="btn btn-info">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                @can('metas.destroy')
                                                    <form class="d-inline"
                                                          action="{{ route('metas.destroy', $meta) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" rel="tooltip" class="btn btn-danger">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
