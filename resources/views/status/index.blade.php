@extends('layouts.app', ['activePage' => 'status', 'titlePage' => __('Gerenciar Status')])

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
                {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="container-fluid">

            <div class="row">
                <div class="col-12 text-left">
                    @can('status.create')
                        <a href="{{ route('status.create') }}" class="btn btn-sm btn btn-success"><i
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
                                    <h4 class="card-title">Lista de Status</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Status</th>
                                            <th>Tipo Status</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($statuses as $status)
                                            <tr>
                                                <td>{{ $status->id }}</td>
                                                <td>{{ $status->status }}</td>
                                                <td>{{ $status->status_tipo->tipo_status }}</td>

                                                <td class="td-actions text-right">
                                                    @can('status.edit')
                                                        <a href="{{ route('status.edit', $status) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan
                                                    @can('status.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('status.destroy', $status) }}"
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

                        </div>
                    </div><!-- card-->
                </div><!-- col-md-12-->
            </div><!-- row-->
        </div><!-- container-fluid-->
    </div><!-- content-->
@endsection
