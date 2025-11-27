@extends('layouts.app', [
    'activePage' => 'financeiro-lancamentos',
    'titlePage' => __('Editar Lançamento Financeiro')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        @if ($errors->any())
            <div class="alert alert-danger">
                <span><b>Erro:</b> Verifique os campos abaixo.</span>
            </div>
        @endif

        <div class="row">
            <div class="col-md-10">
                <form method="POST" action="{{ route('lancamentos.update', $lancamento->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Lançamento</h4>
                            <p class="card-category">Atualize os dados do lançamento</p>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo *</label>
                                        <select name="tipo" class="form-control" required>
                                            <option value="receita" {{ old('tipo', $lancamento->tipo) == 'receita' ? 'selected' : '' }}>Receita</option>
                                            <option value="despesa" {{ old('tipo', $lancamento->tipo) == 'despesa' ? 'selected' : '' }}>Despesa</option>
                                        </select>
                                        @error('tipo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Natureza *</label>
                                        <select name="natureza" class="form-control" required>
                                            <option value="pagar" {{ old('natureza', $lancamento->natureza) == 'pagar' ? 'selected' : '' }}>Pagar</option>
                                            <option value="receber" {{ old('natureza', $lancamento->natureza) == 'receber' ? 'selected' : '' }}>Receber</option>
                                        </select>
                                        @error('natureza')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Conta Bancária</label>
                                        <select name="conta_bancaria_id" class="form-control">
                                            <option value="">Selecione (opcional)</option>
                                            @foreach($contas as $conta)
                                                <option value="{{ $conta->id }}" {{ old('conta_bancaria_id', $lancamento->conta_bancaria_id) == $conta->id ? 'selected' : '' }}>
                                                    {{ $conta->nome }} - {{ optional($conta->banco)->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('conta_bancaria_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Descrição *</label>
                                <input type="text" name="descricao" class="form-control" value="{{ old('descricao', $lancamento->descricao) }}" required>
                                @error('descricao')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Categoria</label>
                                <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $lancamento->categoria) }}">
                                @error('categoria')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de Competência</label>
                                        <input type="date" name="data_competencia" class="form-control" value="{{ old('data_competencia', $lancamento->data_competencia) }}">
                                        @error('data_competencia')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de Vencimento</label>
                                        <input type="date" name="data_vencimento" class="form-control" value="{{ old('data_vencimento', $lancamento->data_vencimento) }}">
                                        @error('data_vencimento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de Pagamento</label>
                                        <input type="date" name="data_pagamento" class="form-control" value="{{ old('data_pagamento', $lancamento->data_pagamento) }}">
                                        @error('data_pagamento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor Previsto *</label>
                                        <input type="number" step="0.01" name="valor_previsto" class="form-control" value="{{ old('valor_previsto', $lancamento->valor_previsto) }}" required>
                                        @error('valor_previsto')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor Pago</label>
                                        <input type="number" step="0.01" name="valor_pago" class="form-control" value="{{ old('valor_pago', $lancamento->valor_pago) }}">
                                        @error('valor_pago')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status *</label>
                                        <select name="status" class="form-control" required>
                                            <option value="aberto" {{ old('status', $lancamento->status) == 'aberto' ? 'selected' : '' }}>Aberto</option>
                                            <option value="pago" {{ old('status', $lancamento->status) == 'pago' ? 'selected' : '' }}>Pago</option>
                                            <option value="atrasado" {{ old('status', $lancamento->status) == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                            <option value="cancelado" {{ old('status', $lancamento->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('lancamentos.index') }}" class="btn btn-secondary">
                                <i class="material-icons">arrow_back</i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="material-icons">save</i> Atualizar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
