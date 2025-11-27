@extends('layouts.app', ['activePage' => 'equipes', 'titlePage' => __('Lista de Equipes')])

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
                    @can('equipes.create')
                        <a href="{{ route('equipes.create') }}" class="btn btn-sm btn btn-success"><i
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
                                    <h4 class="card-title ">Lista de Equipes</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Equipe</th>
                                            <th>Loja</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($equipes as $equipe)
                                            <tr>
                                                <td>{{ $equipe->id }}</td>
                                                <td>{{ $equipe->equipe }}</td>
                                                <td>{{ $equipe->loja->loja }}</td>
                                                <td class="td-actions text-right">

                                                    @can('equipes.edit')
                                                        <a href="{{ route('equipes.edit', $equipe->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-success">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    @can('equipes.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('equipes.destroy', $equipe->id) }}"
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
