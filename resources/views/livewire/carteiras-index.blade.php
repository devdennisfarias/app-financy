<div class="content">

    <div class="content">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">

            <div class="row d-flex justify-content-between">
                <div class="col-md-2">
                    @can('clientes.create')
                        <a href="{{ route('clientes.create') }}" class="btn btn-sm btn btn-success"><i
                               class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
                <div class="col-md-4">
                    <label class="w-100">
                        <span class="bmd-form-group">
                            <input type="text" class="form-control"
                                   placeholder="Procurar cliente" aria-controls="datatables" wire:model="search">                        
                        </span>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title ">Lista de Clientes</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Orgão</th>
                                            <th>Matrícula</th>
                                            <th>Salário</th>
                                            <th>Atualizado em</th>
                                            <th>Vendedor atual</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($clientes as $cliente)
                                            <tr>
                                                <td class="text-center">{{ $cliente->id }}</td>
                                                <td>{{ $cliente->nome }}</td>
                                                <td>{{ $cliente->cpf }}</td>
                                                <td>{{ $cliente->orgao_1 }}</td>
                                                <td>{{ $cliente->matricula_1 }}</td>
                                                <td>{{ $cliente->salario_1 }}</td>
                                                <td>{{ date('d/m/y - H:m', strtotime($cliente->updated_at)) }}</td>
                                                @if (!empty($cliente->vendedor->name))
                                                    <td>{{ $cliente->vendedor->name }}</td>
                                                @else
                                                    <td></td>
                                                @endif

                                                <td class="td-actions text-right">

                                                    <!-- Button trigger modal -->
                                                    <button type="button" rel="tooltip" class="btn btn-success"
                                                            data-toggle="modal" data-target="#id{{ $cliente->id }}">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="id{{ $cliente->id }}" tabindex="-1"
                                                         role="dialog" aria-labelledby="exampleModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><strong>{{ $cliente->nome }}</strong></h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <strong>Nome: </strong>{{ $cliente->nome }}<br>
                                                                    <strong>CPF: </strong>{{ $cliente->cpf }}<br>
                                                                    <strong>RG: </strong>{{ $cliente->rg }}<br>
                                                                    <strong>Telefone: </strong>{{ $cliente->telefone_1 }}<br>
                                                                    <strong>Telefone 2: </strong>{{ $cliente->telefone_2 }}<br>
                                                                    <strong>Telefone 3: </strong>{{ $cliente->telefone_3 }}<br>
                                                                    <strong>Data Nascimento: </strong>{{ $cliente->data_nascimento }}<br>
                                                                    <strong>Orgão: </strong>{{ $cliente->orgao_1 }}<br>
                                                                    <strong>Salário: </strong>{{ $cliente->salario_1 }}<br>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Fechar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @can('clientes.edit')
                                                        <a href="{{ route('clientes.edit', $cliente->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    <a target="_blank" href="{{ route('cliente.pdf', $cliente->id) }}">
                                                        <button type="button" rel="tooltip" class="btn btn-warning">
                                                            <i class="material-icons">print</i>
                                                        </button>
                                                    </a>

                                                    @can('clientes.destroy')
                                                        <form class="d-inline"
                                                              action="{{ route('clientes.destroy', $cliente->id) }}"
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
                            {{ $clientes->links('vendor.pagination.simple-creative-tim') }}
                        </div>
                    </div><!-- card-->
                </div><!-- col-md-12-->
            </div><!-- row-->
        </div><!-- container-fluid-->
    </div><!-- content-->

</div>
