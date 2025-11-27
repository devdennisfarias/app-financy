<div class="content">

    <div class="content">



        <!-- Button trigger modal -->
        <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Launch demo modal
                                </button>-->

        <!-- Modal -->
        <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>-->



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
                                <!--               <div class="col-md-6">
                                                            <a href="{{ route('clientes.create') }}">
                                                              <button class="btn btn-primary btn-round btn-fab float-right">
                                                                <i class="material-icons">add</i>
                                                              </button>
                                                            </a>
                                                          </div> -->
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
                                                <td> {{ 'R$ ' . number_format($cliente->salario_1, 2, ',', '.') }} </td>
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
                                                        <div style="max-width: 1200px;" class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Cliente: <strong>{{ $cliente->nome }}</strong>
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div style="text-align:left" class="modal-body">


                                                                    <div class="row">
                                                                        <div class="col-md-12">

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">CPF*</label>
                                                                                        <span class="form-control">{{ $cliente->cpf }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <div class="input-group date" data-provide="datepicker">
                                                                                            <label>Nascimento:* &nbsp; </label>
                                                                                            <span class="form-control">{{ $cliente->data_nascimento ? date('d/m/Y', strtotime($cliente->data_nascimento)) : '' }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="togglebutton">
                                                                                        <input disabled="disabled" id="alfabetizado" name="alfabetizado" type="checkbox" value="1" {{ $cliente->alfabetizado == 1 ? 'checked' : '' }}>
                                                                                        <span class="toggle"></span>
                                                                                        <label>
                                                                                            Alfabetizado
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="togglebutton">
                                                                                        <input disabled="disabled" id="figura_publica" name="figura_publica" type="checkbox" value="1" {{ $cliente->figura_publica == 1 ? 'checked' : '' }}>
                                                                                        <span class="toggle"></span>
                                                                                        <label>
                                                                                            Figura Pública
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">RG</label>
                                                                                        <span class="form-control">{{ $cliente->rg }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <div class="input-group date" data-provide="datepicker">
                                                                                            <label>Expedição: &nbsp; </label>
                                                                                            <span class="form-control">{{ $cliente->data_exp ? date('d/m/Y', strtotime($cliente->data_exp)) : '' }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=" col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Orgão Emissor</label>
                                                                                        <span class="form-control">{{ $cliente->orgao_emissor }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Nome do Pai</label>
                                                                                        <span class="form-control">{{ $cliente->nome_pai }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Nome da Mãe*</label>
                                                                                        <span class="form-control">{{ $cliente->nome_mae }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Endereço</label>
                                                                                        <span class="form-control">{{ $cliente->endereco }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Número</label>
                                                                                        <span class="form-control">{{ $cliente->numero }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Complemento</label>
                                                                                        <span class="form-control">{{ $cliente->complemento }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Naturalidade</label>
                                                                                        <span class="form-control">{{ $cliente->naturalidade }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Nacionalidade</label>
                                                                                        <span class="form-control">{{ $cliente->nacionalidade }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Estado Civil</label>
                                                                                        <span class="form-control">{{ $cliente->estado_civil }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Orgão</label>
                                                                                        <span class="form-control">{{ $cliente->orgao_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Matrícula</label>
                                                                                        <span class="form-control">{{ $cliente->matricula_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Especie Beneficio</label>
                                                                                        <span class="form-control">{{ $cliente->especie_beneficio_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Salário</label>
                                                                                        <span id="salario_1" class="form-control">{{ $cliente->salario_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Banco</label>
                                                                                        <span class="form-control">{{ $cliente->banco_conta_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Agência</label>
                                                                                        <span class="form-control">{{ $cliente->agencia_conta_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Número da Conta</label>
                                                                                        <span class="form-control">{{ $cliente->conta_bancaria_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Orgão 2</label>
                                                                                        <span class="form-control">{{ $cliente->orgao_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Matrícula 2</label>
                                                                                        <span class="form-control">{{ $cliente->matricula_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Especie Beneficio 2</label>
                                                                                        <span class="form-control">{{ $cliente->especie_beneficio_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Salário 2</label>
                                                                                        <span id="salario_2" class="form-control">{{ $cliente->salario_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class=" row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Banco 2</label>
                                                                                        <span class="form-control">{{ $cliente->banco_conta_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Agência 2</label>
                                                                                        <span class="form-control">{{ $cliente->agencia_conta_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Número da Conta 2</label>
                                                                                        <span class="form-control">{{ $cliente->conta_bancaria_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Telefone 1*</label>
                                                                                        <span class="form-control">{{ $cliente->telefone_1 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Telefone 2</label>
                                                                                        <span class="form-control">{{ $cliente->telefone_2 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Telefone 3</label>
                                                                                        <span class="form-control">{{ $cliente->telefone_3 }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12 text-left">
                                                                                    <div class="form-group">
                                                                                        <label class="bmd-label-floating">Atualizado em: {{ date('d/m/y - H:m', strtotime($cliente->updated_at)) }}</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
