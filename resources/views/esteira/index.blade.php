@extends('layouts.app', [
    'activePage' => 'esteira',
    'titlePage' => __('Esteira de Propostas'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho da página --}}
            <x-page-header title="Esteira de Propostas">
            </x-page-header>

            {{-- Alertas de sessão --}}
            <x-session-alerts class="mb-3" />

            {{-- FILTROS --}}
            <x-card title="Filtros da Esteira" bodyClass="pb-2 pt-2">
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
                            <div class="input-group input-group-static mb-3">
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

                        {{-- Nome --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label for="nome" class="ms-0">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control"
                                    placeholder="Parte do nome" value="{{ $filtros['nome'] ?? '' }}">
                            </div>
                        </div>

                        {{-- Status Atual --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label for="status_atual_id" class="ms-0">Status</label>
                                <select name="status_atual_id" id="status_atual_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($statusList as $status)
                                        <option value="{{ $status->id }}"
                                            {{ ($filtros['status_atual_id'] ?? '') == $status->id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Botões --}}
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
            </x-card>

            {{-- KPIs simples --}}
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

            {{-- TABELA DA ESTEIRA --}}
            <x-card title="Lista da Esteira">
                <x-slot name="header">
                    <p class="card-category">Visão detalhada das propostas em andamento</p>
                </x-slot>

                <x-table :striped="true">
                    <x-slot name="head">
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>CPF</th>
                            <th>Convênio</th>
                            <th>Órgão Pagador</th>
                            <th>Produto</th>
                            <th>Banco</th>
                            <th>Tabela</th>
                            <th>Valor Líquido</th>
                            <th>Parcela</th>
                            <th>Qtd Parcelas</th>
                            <th>Status</th>
                            <th>Usuário</th>
                            <th>Observação</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </x-slot>

                    @forelse ($propostas as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '' }}</td>
                            <td>{{ optional($p->cliente)->nome }}</td>
                            <td>{{ optional($p->cliente)->cpf }}</td>

                            {{-- Convênio (via órgão do cliente) --}}
                            <td>
                                {{ optional(optional(optional($p->cliente)->orgao)->convenio)->nome ?? '-' }}
                            </td>

                            {{-- Órgão pagador --}}
                            <td>
                                {{ optional(optional($p->cliente)->orgao)->nome ?? '-' }}
                            </td>

                            <td>{{ optional($p->produto)->nome ?? optional($p->produto)->produto }}</td>
                            <td>{{ $p->banco }}</td>
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

                            {{-- Status atual (nome, não id) --}}
                            <td>
                                @php
                                    $statusNome = optional($p->status_atual)->status;
                                @endphp

                                @if ($statusNome)
                                    <span
                                        class="badge
                                        @if (str_starts_with($statusNome, 'Aprov')) badge-success
                                        @elseif (str_starts_with($statusNome, 'Pendente')) badge-warning
                                        @elseif (str_starts_with($statusNome, 'Cancel')) badge-danger
                                        @else badge-secondary @endif
                                    ">
                                        {{ $statusNome }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

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
                </x-table>

                {{-- Paginação --}}
                <x-slot name="footerSlot">
                    {{ $propostas->appends($filtros ?? [])->links() }}
                </x-slot>
            </x-card>

        </div>
    </div>
@endsection
