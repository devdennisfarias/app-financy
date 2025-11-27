@extends('layouts.app', ['activePage' => 'produtos', 'titlePage' => __('Produtos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12 text-left">
                    @can('produtos.create')
                        <a href="{{ route('produtos.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cadastro de Produtos</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Produto</th>
                                            <th>Descrição</th>
                                            <th>Tabelas</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($produtos as $produto)
                                            <tr>
                                                <td class="text-center">{{ $produto->id }}</td>
                                                <td> {{ $produto->produto }} </td>
                                                <td> {{ $produto->descricao }} </td>
                                                <td>
                                                    @if ($produto->tabelas)
                                                        @foreach ($produto->tabelas as $tabela)
                                                            <span style="background-color:#1565C0; color: #fff; text-transform: uppercase;" class="badge badge-default">
                                                                {{ $tabela->nome }}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="td-actions text-right">

                                                    @can('produtos.edit')
                                                        <a href="{{ route('produtos.edit', $produto->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    @can('produtos.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('produtos.destroy', $produto) }}"
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
                        <div class="card-footer">
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
