@extends('layouts.app', ['activePage' => 'regras', 'titlePage' => __('Regras de Comissão')])

@section('content')
    <div class="content">
        <div class="container-fluid">            
            <div class="row">
                <div class="col-12 text-left">
                    @can('regras.create')
                        <a href="{{ route('regras.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cadastro de Regras</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-left">ID</th>
                                            <th>Regra</th>
                                            <th>Descrição</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($regras as $regra)
                                            <tr>
                                                <td class="text-left">{{ $regra->id }}</td>
                                                <td> {{ $regra->regra }} </td>
                                                <td> {{ $regra->descricao }} </td>                                                
                                                <td class="td-actions text-right">
                                                    @can('regras.edit')
                                                        <a href="{{ route('regras.edit', $regra->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan
                                                    @can('regras.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('regras.destroy', $regra) }}"
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
