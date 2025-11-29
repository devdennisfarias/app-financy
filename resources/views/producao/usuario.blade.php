@extends('layouts.app', [
    'activePage' => 'producao-usuario',
    'titlePage'  => __('Produção por Usuário')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Filtros --}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Selecione o Usuário</h4>
                <p class="card-category">Acompanhe a produção de um usuário específico</p>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('producao.usuario') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Usuário</label>
                            <select name="user_id" class="form-control" onchange="this.form.submit()">
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}"
                                        {{ $u->id == $usuarioSelecionado->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Data Início</label>
                            <input type="date" name="data_inicio" class="form-control"
                                   value="{{ $filtros['data_inicio'] ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label>Data Fim</label>
                            <input type="date" name="data_fim" class="form-control"
                                   value="{{ $filtros['data_fim'] ?? '' }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <p class="card-category">Total de Propostas</p>
                        <h3 class="card-title">{{ $resumo['total'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <p class="card-category text-success">Concluídas</p>
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
                            R$
                            {{ number_format($resumo['valor_total'] ?? 0, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lista --}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">
                    Produção do Usuário: {{ $usuarioSelecionado->name }}
                </h4>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Produto</th>
                                <th>Status</th>
                                <th>Valor Liberado</th>
                                <th>Data</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($propostas as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ optional($p->cliente)->nome }}</td>
                                    <td>{{ optional($p->produto)->produto ?? optional($p->produto)->nome }}</td>

                                    {{-- Status com accessor --}}
                                    <td>
                                        @php
                                            $statusTexto  = $p->status_tipo_descricao ?? 'Não informado';
                                            $statusClasse = $p->status_tipo_badge_class ?? 'badge-default';
                                        @endphp
                                        <span class="badge {{ $statusClasse }}">
                                            {{ $statusTexto }}
                                        </span>
                                    </td>

                                    <td>
                                        R$
                                        {{ number_format($p->valor_liquido_liberado ?? 0, 2, ',', '.') }}
                                    </td>

                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>

                                    <td class="text-right">
                                        <a href="{{ route('propostas.edit', $p->id) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="material-icons">edit</i>
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Nenhuma proposta encontrada para este usuário.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{ $propostas->appends(request()->query())->links() }}

            </div>
        </div>

    </div>
</div>
@endsection
