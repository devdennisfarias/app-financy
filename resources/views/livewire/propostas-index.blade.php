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

            {{-- TOPO: botão adicionar + busca livre --}}
            <div class="row d-flex justify-content-between">
                <div class="col-md-2">
                    @can('propostas.create')
                        <a href="{{ route('propostas.create') }}" class="btn btn-sm btn btn-success">
                            <i class="material-icons">add</i> Adicionar
                        </a>
                    @endcan
                </div>
                <div class="col-md-4">
                    <label class="w-100">
                        <span class="bmd-form-group">
                            <input type="text" class="form-control" placeholder="Procurar proposta"
                                aria-controls="datatables" wire:model="search">
                        </span>
                    </label>
                </div>
            </div>

            @php
                // MESMA LÓGICA QUE JÁ USAMOS EM OUTROS LUGARES:
                // garante que existam coleções mesmo se o componente não passar nada.

                if (!isset($produtos)) {
                    $produtos = \App\Models\Produto::orderBy('produto')->get();
                }

                if (!isset($bancos)) {
                    $bancos = \App\Models\Banco::orderBy('nome')->get();
                }

                if (!isset($statuses)) {
                    $statuses = \App\Models\Status::orderBy('status')->get();
                }
            @endphp

            {{-- FILTROS DA ESTEIRA / LISTA DE PROPOSTAS --}}
            <div class="row mb-3">
                {{-- CPF --}}
                <div class="col-md-3">
                    <label>CPF Cliente</label>
                    <input type="text" class="form-control" placeholder="Digite o CPF"
                        wire:model.debounce.500ms="cpf">
                </div>

                {{-- Produto --}}
                <div class="col-md-3">
                    <label>Produto</label>
                    <select class="form-control" wire:model="produtoId">
                        <option value="">Todos</option>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->produto }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Banco / Instituição --}}
                <div class="col-md-3">
                    <label>Banco / Instituição</label>
                    <select class="form-control" wire:model="bancoId">
                        <option value="">Todos</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco->id }}">{{ $banco->nome }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-control" wire:model="statusId">
                        <option value="">Todos</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- LISTA --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title ">Lista de propostas</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nº FinancyCred</th>
                                            <th>Vendedor</th>
                                            <th>Cliente</th>
                                            <th>Banco</th>
                                            <th>Orgão</th>
                                            <th>Tabela</th>
                                            <th>Vigência</th>
                                            <th>Bruto</th>
                                            <th>Líquido</th>
                                            <th>TX Juros</th>
                                            <th>Parcela</th>
                                            <th>Prazo</th>
                                            <th>Status</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($propostas as $proposta)
                                            <tr>
                                                <td class="text-center">{{ $proposta->id }}</td>
                                                <td>{{ optional($proposta->vendedor)->name ?? '-' }}</td>
                                                <td>{{ optional($proposta->cliente)->nome ?? '-' }}</td>
                                                <td>{{ $proposta->banco }}</td>
                                                <td>{{ $proposta->orgao }}</td>
                                                <td>{{ $proposta->tabela_digitada }}</td>
                                                <td>{{ $proposta->vigencia_tabela }}</td>
                                                <td>{{ 'R$ ' . number_format($proposta->valor_bruto ?? 0, 2, ',', '.') }}
                                                </td>
                                                <td>{{ 'R$ ' . number_format($proposta->valor_liquido_liberado ?? 0, 2, ',', '.') }}
                                                </td>
                                                <td>{{ number_format($proposta->tx_juros ?? 0, 1, ',', '.') . ' %' }}
                                                </td>
                                                <td>{{ 'R$ ' . number_format($proposta->valor_parcela ?? 0, 2, ',', '.') }}
                                                </td>
                                                <td>{{ $proposta->qtd_parcelas }}</td>
                                                <td>{{ optional($proposta->status_atual)->status ?? '-' }}</td>

                                                <td class="td-actions text-right">
                                                    {{-- Botão ver --}}
                                                    <button type="button" rel="tooltip" class="btn btn-success"
                                                        data-toggle="modal" data-target="#id{{ $proposta->id }}">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </button>

                                                    {{-- Modal de detalhes --}}
                                                    <div class="modal fade" id="id{{ $proposta->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div style="max-width: 1200px;" class="modal-dialog"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Numero FinancyCred:
                                                                        <strong>{{ $proposta->id }}</strong>
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div style="text-align:left" class="modal-body">

                                                                    {{-- CPF + Vendedor --}}
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">CPF
                                                                                    Cliente</label>
                                                                                <span class="form-control">
                                                                                    {{ optional($proposta->cliente)->cpf ?? '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Vendedor</label>
                                                                                <span class="form-control">
                                                                                    {{ optional($proposta->vendedor)->name ?? '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Órgão / Tabela / Vigência --}}
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Orgão</label>
                                                                                <span
                                                                                    class="form-control">{{ $proposta->orgao }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Tabela
                                                                                    Digitada</label>
                                                                                <span
                                                                                    class="form-control">{{ $proposta->tabela_digitada }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Vigência
                                                                                    da Tabela</label>
                                                                                <span
                                                                                    class="form-control">{{ $proposta->vigencia_tabela }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Banco + Valores --}}
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Banco</label>
                                                                                <span
                                                                                    class="form-control">{{ $proposta->banco }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Valor
                                                                                    Bruto</label>
                                                                                <span id="valor_bruto"
                                                                                    class="form-control">
                                                                                    {{ number_format($proposta->valor_bruto ?? 0, 2, ',', '.') }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Valor
                                                                                    Líquido Liberado</label>
                                                                                <span id="valor_liquido_liberado"
                                                                                    class="form-control">
                                                                                    {{ number_format($proposta->valor_liquido_liberado ?? 0, 2, ',', '.') }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Produto + Juros + Parcela + Qtd Parcelas --}}
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Produto</label>
                                                                                <span class="form-control">
                                                                                    {{ optional($proposta->produto)->produto ?? '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Tx de
                                                                                    Júros</label>
                                                                                <span id="tx_juros"
                                                                                    class="form-control">
                                                                                    {{ number_format($proposta->tx_juros ?? 0, 1, ',', '.') . ' %' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Valor
                                                                                    da Parcela</label>
                                                                                <span class="form-control">
                                                                                    {{ number_format($proposta->valor_parcela ?? 0, 2, ',', '.') }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Qtd
                                                                                    Parcelas</label>
                                                                                <span class="form-control">
                                                                                    {{ $proposta->qtd_parcelas }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Benefícios / Salários do Cliente --}}
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Espécie
                                                                                    Benefício</label>
                                                                                <span class="form-control">
                                                                                    {{ optional($proposta->cliente)->especie_beneficio_1 ?? '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Salário</label>
                                                                                @php
                                                                                    $salario1 = optional(
                                                                                        $proposta->cliente,
                                                                                    )->salario_1;
                                                                                @endphp
                                                                                <span id="salario_1"
                                                                                    class="form-control">
                                                                                    {{ $salario1 !== null ? 'R$ ' . number_format($salario1, 2, ',', '.') : '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Espécie
                                                                                    Benefício 2</label>
                                                                                <span class="form-control">
                                                                                    {{ optional($proposta->cliente)->especie_beneficio_2 ?? '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="bmd-label-floating">Salário
                                                                                    2</label>
                                                                                @php
                                                                                    $salario2 = optional(
                                                                                        $proposta->cliente,
                                                                                    )->salario_2;
                                                                                @endphp
                                                                                <span id="salario_2"
                                                                                    class="form-control">
                                                                                    {{ $salario2 !== null ? 'R$ ' . number_format($salario2, 2, ',', '.') : '-' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">
                                                                        Fechar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Botão editar --}}
                                                    @can('propostas.edit')
                                                        <a href="{{ route('propostas.edit', $proposta->id) }}">
                                                            <button type="button" rel="tooltip" class="btn btn-info">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    {{-- Botão imprimir --}}
                                                    <a target="_blank"
                                                        href="{{ route('proposta.pdf', $proposta->id) }}">
                                                        <button type="button" rel="tooltip"
                                                            class="btn btn-warning">
                                                            <i class="material-icons">print</i>
                                                        </button>
                                                    </a>

                                                    {{-- Botão deletar --}}
                                                    @can('propostas.destroy')
                                                        <form class="d-inline"
                                                            action="{{ route('propostas.destroy', $proposta->id) }}"
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
                            {{ $propostas->links('vendor.pagination.simple-creative-tim') }}
                        </div>
                    </div><!-- card-->
                </div><!-- col-md-12-->
            </div><!-- row-->
        </div><!-- container-fluid-->
    </div><!-- content-->

</div>
