@extends('layouts.app', ['activePage' => 'produtos', 'titlePage' => __('Produtos')])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 text-left">
                    @can('produtos.create')
                        <a href="{{ route('produtos.create') }}" class="btn btn-sm btn btn-success"><i
                                class="material-icons">add</i> Adicionar</a>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cadastro de Produtos</h4>
                        </div>
                        <div class="card-body">

                            {{-- Filtros --}}
                            <form method="GET" action="{{ route('produtos.index') }}" class="mb-3">
                                <div class="row">

                                    {{-- Filtro por instituição --}}
                                    <div class="col-md-5">
                                        <div class="form-group bmd-form-group">
                                            <label for="instituicao_id">Instituição</label>
                                            <select name="instituicao_id" id="instituicao_id" class="form-control">
                                                <option value="">Todas</option>
                                                <option value="gen"
                                                    {{ ($instituicaoFiltro ?? '') === 'gen' ? 'selected' : '' }}>
                                                    Somente genéricos (sem instituição)
                                                </option>
                                                @foreach ($instituicoes as $inst)
                                                    <option value="{{ $inst->id }}"
                                                        {{ (string) ($instituicaoFiltro ?? '') === (string) $inst->id ? 'selected' : '' }}>
                                                        {{ $inst->nome }}
                                                        @if ($inst->tipo)
                                                            ({{ $inst->tipo }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Filtro por tipo de instituição --}}
                                    <div class="col-md-5">
                                        <div class="form-group bmd-form-group">
                                            <label for="tipo_instituicao">Tipo da
                                                Instituição</label>
                                            <select name="tipo_instituicao" id="tipo_instituicao" class="form-control">
                                                <option value="">Todos</option>
                                                @foreach ($tiposInstituicao as $valor => $label)
                                                    <option value="{{ $valor }}"
                                                        {{ ($tipoFiltro ?? '') === $valor ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Botões --}}
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            Filtrar
                                        </button>
                                        <a href="{{ route('produtos.index') }}" class="btn btn-default">
                                            Limpar
                                        </a>
                                    </div>

                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Produto</th>
                                            <th>Instituição</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($produtos as $produto)
                                            <tr>
                                                <td>{{ $produto->id }}</td>

                                                <td>{{ $produto->produto }}</td>

                                                <td>
                                                    @if ($produto->instituicao)
                                                        {{ $produto->instituicao->nome }}
                                                        <span class="text-muted">({{ $produto->instituicao->tipo }})</span>
                                                    @else
                                                        <span class="text-muted">Genérico</span>
                                                    @endif
                                                </td>

                                                <td class="td-actions text-right">

                                                    {{-- Botão Editar --}}
                                                    <a href="{{ route('produtos.edit', $produto->id) }}"
                                                        class="btn btn-success btn-link btn-sm" title="Editar">
                                                        <i class="material-icons">edit</i>
                                                    </a>

                                                    {{-- Botão Excluir --}}
                                                    <form action="{{ route('produtos.destroy', $produto->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-link btn-sm"
                                                            title="Excluir">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Nenhum produto encontrado.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Paginação --}}
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    {{ $produtos->links() }}
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    {{ $produtos->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
