@extends('layouts.app', [
    'activePage' => 'propostas-usuario',
    'titlePage' => __('Propostas por Usuário')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Filtros --}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Propostas por Usuário</h4>
                <p class="card-category">Acompanhe as propostas de um usuário específico</p>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('propostas.usuario') }}">
                    <div class="row">

                        {{-- Usuário --}}
                        <div class="col-md-4">
                            <label>Usuário</label>
                            <select name="user_id" class="form-control" onchange="this.form.submit()">
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}" {{ $u->id == $usuarioSelecionado->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Período --}}
                        <div class="col-md-3">
                            <label>Data Início</label>
                            <input type="date" name="data_inicio" value="{{ $filtros['data_inicio'] ?? '' }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Data Fim</label>
                            <input type="date" name="data_fim" value="{{ $filtros['data_fim'] ?? '' }}" class="form-control">
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

        {{-- Tabela --}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">
                    Propostas do Usuário: {{ $usuarioSelecionado->name }}
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
                                <th>Valor</th>
                                <th>Data</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($propostas as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ optional($p->cliente)->nome }}</td>
                                    <td>{{ optional($p->produto)->nome }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td>{{ number_format($p->valor ?? 0, 2, ',', '.') }}</td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Nenhuma proposta encontrada.</td>
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
