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

    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row d-flex justify-content-between">
            <div class="col-md-2">
                @can('users.create')
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn btn-success"><i
                           class="material-icons">add</i> Adicionar</a>
                @endcan
            </div>
            <div class="col-md-4">
                <label class="w-100">
                    <span class="bmd-form-group">
                        <input type="text" class="form-control"
                               placeholder="Procurar usuário" aria-controls="datatables" wire:model="search">                        
                    </span>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="col-md-12">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Lista de usuários</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Permissões</th>
                                        <th>Loja</th>
                                        <th>Equipe</th>
                                        <th>Regra de comissão</th>
                                        <th class="text-right">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $user->id }}</td>
                                            <td> {{ $user->name }} </td>
                                            <td> {{ $user->email }} </td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span style="background-color:#1565C0; color: #fff; text-transform: uppercase;" class="badge badge-default">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td> {{ $user->equipe->loja->loja ?? 'Nenhum loja cadastrada' }} </td>
                                            <td> {{ $user->equipe->equipe ?? 'Nenhum equipe cadastrada' }} </td>
                                            <td> {{ $user->regra->regra ?? 'Nenhum regra cadastrada' }} </td>
                                            <td class="td-actions text-right">
                                                @can('users.edit')
                                                    <a href="{{ route('users.edit', $user->id) }}">
                                                        <button type="button" rel="tooltip" class="btn btn-info">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                @if ($loggedId !== $user->id)
                                                    @can('users.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('users.destroy', $user) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" rel="tooltip" class="btn btn-danger">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card-body-->

                    <div class="card-footer">
                        {{ $users->links('vendor.pagination.simple-creative-tim') }}
                    </div>
                </div><!-- card-->
            </div><!-- col-md-12-->
        </div><!-- row-->
    </div><!-- container-fluid-->
</div><!-- content-->
