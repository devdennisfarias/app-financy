@extends('layouts.app', [
    'activePage' => 'esteira',
    'titlePage' => __('Esteira de Propostas'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- FILTROS (estilo Material Dashboard input-group-static) --}}
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Esteira de Propostas</h4>
                    <p class="card-category">Acompanhe o fluxo das propostas em cada etapa</p>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('esteira.index') }}">
                        <div class="row">

                            {{-- Data início --}}
                            <div class="col-md-2">
                                <div class="input-group input-group-static mb-3">
                                    <label for="data_inicio" class="ms-0">Data Início</label>
                                    <input type="date" id="data_inicio" name="data_inicio" class="form-control"
                                        value="{{ $filtros['data_inicio'] ?? '' }}">
                                </div>
                            </div>

                            {{-- Data fim --}}
                            <div class="col-md-2">
                                <div class="input-group input-group-static mb-3">
                                    <label for="data_fim" class="ms-0">Data Fim</label>
                                    <input type="date" id="data_fim" name="data_fim" class="form-control"
                                        value="{{ $filtros['data_fim'] ?? '' }}">
                                </div>
                            </div>

                            {{-- Usuário --}}
                            <div class="col-md-3">
                                <div class="input-group input-group-static mb-3">
                                    <label for="user_id" class="ms-0">Usuário</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach ($usuarios as $u)
                                            <option value="{{ $u->id }}"
                                                {{ ($filtros['user_id'] ?? '') == $u->id ? 'selected' : '' }}>
                                                {{ $u->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Produto --}}
                            <div class="col-md-3">
                                <div class="input-group input-group-static mb-4">
                                    <label for="produto" class="ms-0">Produto</label>
                                    <select class="form-control" id="produto" name="produto">
                                        <option value="">Todos</option>
                                        @foreach ($produtos as $produto)
                                            <option value="{{ $produto->id }}"
                                                {{ ($filtros['produto'] ?? '') == $produto->id ? 'selected' : '' }}>
                                                {{ $produto->produto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Órgão --}}
                            <div class="col-md-2">
                                <div class="input-group input-group-static mb-3">
                                    <label for="orgao" class="ms-0">Órgão / Convênio</label>
                                    <input type="text" id="orgao" name="orgao" class="form-control"
                                        placeholder="INSS, Exército..." value="{{ $filtros['orgao'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            {{-- Banco --}}
                            <div class="col-md-3">
                                <div class="input-group input-group-static mb-3">
                                    <label for="banco" class="ms-0">Banco</label>
                                    <input type="text" id="banco" name="banco" class="form-control"
                                        placeholder="BMG, PAN, Daycoval..." value="{{ $filtros['banco'] ?? '' }}">
                                </div>
                            </div>

                            {{-- CPF --}}
                            <div class="col-md-3">
                                <div class="input-group input-group-static mb-3">
                                    <label for="cpf" class="ms-0">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control"
                                        placeholder="Somente números" value="{{ $filtros['cpf'] ?? '' }}">
                                </div>
                            </div>

                            {{-- Nome cliente --}}
                            <div class="col-md-4">
                                <div class="input-group input-group-static mb-3">
                                    <label for="nome" class="ms-0">Nome do Cliente</label>
                                    <input type="text" id="nome" name="nome" class="form-control"
                                        placeholder="Parte do nome" value="{{ $filtros['nome'] ?? '' }}">
                                </div>
                            </div>

                            {{-- Status esteira (status_tipo_atual_id) --}}
                            <div class="col-md-2">
                                <div class="input-group input-group-static mb-3">
                                    <label for="status_tipo_atual_id" class="ms-0">Status Esteira</label>
                                    <select name="status_tipo_atual_id" id="status_tipo_atual_id" class="form-control">
                                        <option value="">Todos</option>
																				
                                        @foreach ($statusTipos as $st)
                                            <option value="{{ $st->id }}"
                                                {{ ($filtros['status_tipo_atual_id'] ?? '') == $st->id ? 'selected' : '' }}>
                                                {{ $st->nome ?? ($st->descricao ?? '#' . $st->tipo_status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="material-icons">search</i> Filtrar
                                </button>
                                <a href="{{ route('esteira.index') }}" class="btn btn-default">
                                    Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- KPIs simples (opcional, estilo resumo da planilha) --}}
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Total de Propostas</p>
                            <h3 class="card-title">{{ $resumo['total'] ?? $propostas->total() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category text-success">Aprovadas</p>
                            <h3 class="card-title">{{ $resumo['aprovadas'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category text-warning">Pendentes</p>
                            <h3 class="card-title">{{ $resumo['pendentes'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-body">
                            <p class="card-category">Valor Total Liberado</p>
                            <h3 class="card-title">
                                R$ {{ number_format($resumo['valor_total'] ?? 0, 2, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABELA ESTILO PLANILHA --}}
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Lista da Esteira</h4>
                    <p class="card-category">Visão detalhada de todas as propostas</p>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead class="text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>CPF</th>
                                    <th>Produto</th>
                                    <th>Banco</th>
                                    <th>Órgão</th>
                                    <th>Tabela</th>
                                    <th>Valor Líquido</th>
                                    <th>Parcela</th>
                                    <th>Qtd Parcelas</th>
                                    <th>Status Atual</th>
                                    <th>Status Esteira</th>
                                    <th>Usuário</th>
                                    <th>Observação</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($propostas as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '' }}</td>
                                        <td>{{ optional($p->cliente)->nome }}</td>
                                        <td>{{ optional($p->cliente)->cpf }}</td>
                                        <td>{{ optional($p->produto)->nome ?? optional($p->produto)->produto }}</td>
                                        <td>{{ $p->banco }}</td>
                                        <td>{{ $p->orgao }}</td>
                                        <td>{{ $p->tabela_digitada }}</td>
                                        <td>
                                            @if ($p->valor_liquido_liberado)
                                                R$ {{ number_format($p->valor_liquido_liberado, 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->valor_parcela)
                                                R$ {{ number_format($p->valor_parcela, 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>{{ $p->qtd_parcelas }}</td>

                                        {{-- aqui futuramente você pode mostrar o nome do status em vez do id --}}
                                        <td>{{ $p->status_atual_id }}</td>
                                        <td>{{ $p->status_tipo_atual_id }}</td>

                                        <td>{{ optional($p->user)->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($p->observacao ?? '', 40) }}</td>

                                        <td class="td-actions text-right">
                                            <a href="{{ route('propostas.edit', $p->id) }}" class="btn btn-info btn-sm"
                                                title="Editar Proposta">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="16">Nenhuma proposta encontrada para os filtros informados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- paginação --}}
                    <div class="mt-3">
                        {{ $propostas->appends($filtros ?? [])->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
