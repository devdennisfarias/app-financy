@extends('layouts.app', ['activePage' => 'lojas', 'titlePage' => __('Lista de Lojas')])

@section('content')
    <div class="content">


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('info') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-left">
                    @can('lojas.create')
                        <a href="{{ route('lojas.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title ">Lista de Lojas</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Loja</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($lojas as $loja)
                                            <tr>
                                                <td>{{ $loja->id }}</td>
                                                <td>{{ $loja->loja }}</td>
                                                <td class="td-actions text-right">

                                                    @can('lojas.edit')
                                                        <a href="{{ route('lojas.edit', $loja->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    @can('lojas.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('lojas.destroy', $loja->id) }}"
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
                        </div><!-- card-body-->
                    </div><!-- card-->
                </div><!-- col-md-12-->
            </div><!-- row-->
        </div><!-- container-fluid-->
    </div><!-- content-->
@endsection
