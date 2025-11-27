@extends('layouts.app', ['activePage' => 'tabelas', 'titlePage' => __('Tabelas de Comissão')])

@section('content')
    <div class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Confirmação!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            
            <div class="row">
                <div class="col-12 text-left">
                    @can('tabelas.create')
                        <a href="{{ route('tabelas.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Tabelas de Comissão</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>COD</th>
                                            <th>Nome</th>
                                            <th>Prazo</th>
                                            <th>Coeficiente</th>
                                            <th>Taxa</th>
                                            <th>Vigência</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($tabelas as $tabela)
                                            <tr>
                                                <td> {{ $tabela->id }} </td>
                                                <td> {{ $tabela->cod }} </td>
                                                <td> {{ $tabela->nome }} </td>
                                                <td> {{ $tabela->prazo }} </td>
                                                <td> {{ $tabela->coeficiente }} </td>
                                                <td> {{ $tabela->taxa }} </td>
                                                <td> {{ $tabela->vigencia }} </td>
                                                <td class="td-actions text-right">
                                                    @can('tabelas.edit')
                                                        <a href="{{ route('tabelas.edit', $tabela->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan
                                                    @can('tabelas.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('tabelas.destroy', $tabela->id) }}"
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
    </div>
@endsection
