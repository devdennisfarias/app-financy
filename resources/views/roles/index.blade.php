@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Gerenciar Permissões')])


@section('content')
    <div class="content">

        @if (session('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('info') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('danger') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 text-left">
                    @can('roles.create')
                        <a href="{{ route('roles.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="col-md-12">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title">Lista de Permissões</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Permissão</th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td class="td-actions text-right">
                                                    @can('roles.edit')
                                                        <a href="{{ route('roles.edit', $role) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan
                                                    @can('roles.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('roles.destroy', $role) }}"
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

                        <div class="card-footer">
                            {{ $roles->links() }}
                        </div>
                    </div><!-- card-->
                </div><!-- col-md-12-->
            </div><!-- row-->
        </div><!-- container-fluid-->
    </div><!-- content-->
@endsection
