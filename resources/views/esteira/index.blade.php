@extends('layouts.app', [
    'activePage' => 'esteira',
    'titlePage'  => __('Esteira de Propostas')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Filtros --}}
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
                            <label>Data Início</label>
                            <input type="date" name="data_inicio"
                                   value="{{ $filtros['data_inicio'] ?? '' }}"
                                   class="form-control">
                        </div>

                        {{-- Data fim --}}
                        <div class="col-md-2">
                            <label>Data Fim</label>
                            <input type="date" name="data_fim"
                                   value="{{ $filtros['data_fim'] ?? '' }}"
                                   class="form-control">
                        </div>

                        {{-- Usuário --}}
                        <div class="col-md-3">
                            <label>Usuário</label>
                            <select name="user_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}"
                                        {{ ($filtros['user_id'] ?? '') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Produto --}}
                        <div class="col-md-3">
                            <label>Produto</label>
                            <input type="text" name="produto"
                                   value="{{ $filtros['produto'] ?? '' }}"
                                   class="form-control"
                                   placeholder="Ex: Novo, Portabilidade...">
                        </div>

                        {{-- Órgão --}}
                        <div class="col-md-2">
                            <label>Órgão</label>
                            <input type="text" name="orgao"
                                   value="{{ $filtros['orgao'] ?? '' }}"
                                   class="form-control"
                                   placeholder="INSS, Exército...">
                        </div>

                    </div>

                    <div class="row mt-3">
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

        {{-- Esteira em colunas --}}
        <div class="row">

            @foreach($statusTipos as $statusTipo)
                @php
                    $lista = $propostasPorStatus[$statusTipo->id] ?? collect();
                @endphp

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header"
                             style="background: #f5f5f5; border-bottom: 1px solid #ddd;">
                            <h4 class="card-title" style="font-size: 15px; margin-bottom: 0;">
                                {{ $statusTipo->descricao ?? $statusTipo->nome ?? 'Status' }}
                            </h4>
                            <p class="card-category" style="margin: 0;">
                                {{ $lista->count() }} proposta(s)
                            </p>
                        </div>

                        <div class="card-body"
                             style="max-height: 65vh; overflow-y: auto; padding: 10px;">

                            @forelse($lista as $p)
                                <div class="card card-stats mb-2"
                                     style="border: 1px solid #eee; box-shadow: none;">
                                    <div class="card-body" style="padding: 10px 12px;">

                                        <div style="font-weight: 600; font-size: 13px;">
                                            #{{ $p->id }} -
                                            {{ Str::limit(optional($p->cliente)->nome, 22) }}
                                        </div>

                                        <div style="font-size: 12px; color: #777;">
                                            {{ optional($p->produto)->produto ?? optional($p->produto)->nome }}
                                        </div>

                                        <div style="font-size: 12px; margin-top: 5px;">
                                            Valor: <strong>
                                                R$
                                                {{ number_format($p->valor_liquido_liberado ?? 0, 2, ',', '.') }}
                                            </strong>
                                        </div>

                                        <div style="font-size: 11px; color: #999;">
                                            Usuário: {{ optional($p->user)->name }}<br>
                                            Criada em: {{ $p->created_at->format('d/m/Y') }}
                                        </div>

                                        <div class="mt-1 text-right">
                                            <a href="{{ route('propostas.edit', $p->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="material-icons" style="font-size: 16px;">edit</i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <p style="font-size: 12px; color: #999;">Nenhuma proposta.</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</div>
@endsection
