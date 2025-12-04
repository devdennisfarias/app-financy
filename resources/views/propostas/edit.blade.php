@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Editar Proposta')])

@section('content')
    <div class="content">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Ocorreu um Erro!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('propostas.index') }}" class="btn btn-sm btn">
                        <i class="material-icons">reply</i>
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('propostas.update', $proposta->id) }}">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Editar Proposta #{{ $proposta->id }}</h4>
                    </div>

                    <div class="card-body">

                        {{-- CPF Cliente --}}
                        <div class="row">
                            <div class="col-md-4">
                                <label class="bmd-label-floating">CPF Cliente</label>
                                <input type="text" readonly class="form-control"
                                    value="{{ optional($proposta->cliente)->cpf ?? '-' }}">
                            </div>

                            <div class="col-md-4">
                                <label class="bmd-label-floating">Vendedor</label>
                                <input type="text" readonly class="form-control"
                                    value="{{ optional($proposta->vendedor)->name ?? '-' }}">
                            </div>
                        </div>

                        {{-- Banco e valores --}}
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label class="bmd-label-floating">Banco</label>
                                <input type="text" name="banco" class="form-control"
                                    value="{{ old('banco', $proposta->banco) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="bmd-label-floating">Valor Bruto</label>
                                <input type="text" name="valor_bruto" class="form-control"
                                    value="{{ old('valor_bruto', $proposta->valor_bruto) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="bmd-label-floating">Valor Líquido</label>
                                <input type="text" name="valor_liquido_liberado" class="form-control"
                                    value="{{ old('valor_liquido_liberado', $proposta->valor_liquido_liberado) }}">
                            </div>
                        </div>

                        {{-- Produto --}}
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Produto</label>
                                <select name="produto_id" class="form-control">
                                    <option value="">Selecione...</option>

                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto->id }}"
                                            {{ $proposta->produto_id == $produto->id ? 'selected' : '' }}>
                                            {{ $produto->produto }} — {{ optional($produto->instituicao)->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="bmd-label-floating">Tx Juros (%)</label>
                                <input type="text" name="tx_juros" class="form-control"
                                    value="{{ old('tx_juros', $proposta->tx_juros) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="bmd-label-floating">Valor Parcela</label>
                                <input type="text" name="valor_parcela" class="form-control"
                                    value="{{ old('valor_parcela', $proposta->valor_parcela) }}">
                            </div>
                        </div>

                        {{-- Qtd Parcelas --}}
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label class="bmd-label-floating">Qtd Parcelas</label>
                                <input type="number" name="qtd_parcelas" class="form-control"
                                    value="{{ old('qtd_parcelas', $proposta->qtd_parcelas) }}">
                            </div>
                        </div>

                        {{-- Botões --}}
                        <div class="row mt-4">
                            <div class="col text-right">
                                <a href="{{ route('propostas.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection
