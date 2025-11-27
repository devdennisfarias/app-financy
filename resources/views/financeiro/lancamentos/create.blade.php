@extends('layouts.app', [
    'activePage' => 'financeiro-lancamentos',
    'titlePage'  => __('Novo Lançamento Financeiro')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <form method="POST" action="{{ route('lancamentos.store') }}">
                    @csrf

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Novo lançamento</h4>
                            <p class="card-category">
                                Cadastre contas a pagar ou a receber
                            </p>
                        </div>

                        <div class="card-body">
                            @php
                                $natureza = old('natureza', $naturezaDefault ?? 'pagar'); // pagar | receber
                                $tipo     = old('tipo', $tipoDefault ?? ($natureza === 'receber' ? 'receita' : 'despesa'));
                            @endphp

                            {{-- Linha 1: Tipo, Natureza, Conta bancária --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select name="tipo" class="form-control">
                                            <option value="despesa" {{ $tipo === 'despesa' ? 'selected' : '' }}>
                                                Despesa
                                            </option>
                                            <option value="receita" {{ $tipo === 'receita' ? 'selected' : '' }}>
                                                Receita
                                            </option>
                                        </select>
                                        @error('tipo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Natureza</label>
                                        <select name="natureza" class="form-control">
                                            <option value="pagar" {{ $natureza === 'pagar' ? 'selected' : '' }}>
                                                Pagar
                                            </option>
                                            <option value="receber" {{ $natureza === 'receber' ? 'selected' : '' }}>
                                                Receber
                                            </option>
                                        </select>
                                        @error('natureza')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Conta bancária (opcional)</label>
                                        <select name="conta_bancaria_id" class="form-control">
                                            <option value="">Selecione</option>
                                            @foreach($contas as $conta)
                                                <option value="{{ $conta->id }}"
                                                    {{ old('conta_bancaria_id') == $conta->id ? 'selected' : '' }}>
                                                    {{ $conta->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('conta_bancaria_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Linha 2: Descrição e Categoria --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <input type="text" name="descricao" class="form-control"
                                               value="{{ old('descricao') }}">
                                        @error('descricao')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoria (opcional)</label>
                                        <input type="text" name="categoria" class="form-control"
                                               value="{{ old('categoria') }}">
                                        @error('categoria')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Linha 3: Datas --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de competência</label>
                                        <input type="date" name="data_competencia" class="form-control"
                                               value="{{ old('data_competencia') }}">
                                        @error('data_competencia')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de vencimento</label>
                                        <input type="date" name="data_vencimento" class="form-control"
                                               value="{{ old('data_vencimento') }}">
                                        @error('data_vencimento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data de pagamento/recebimento</label>
                                        <input type="date" name="data_pagamento" class="form-control"
                                               value="{{ old('data_pagamento') }}">
                                        @error('data_pagamento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Linha 4: Valores e Status --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor previsto</label>
                                        <input type="number" step="0.01" name="valor_previsto" class="form-control"
                                               value="{{ old('valor_previsto') }}">
                                        @error('valor_previsto')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor pago/recebido</label>
                                        <input type="number" step="0.01" name="valor_pago" class="form-control"
                                               value="{{ old('valor_pago') }}">
                                        @error('valor_pago')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            @php
                                                $status = old('status', 'aberto');
                                            @endphp
                                            <option value="aberto"   {{ $status === 'aberto' ? 'selected' : '' }}>Em aberto</option>
                                            <option value="pago"     {{ $status === 'pago' ? 'selected' : '' }}>Pago/Recebido</option>
                                            <option value="atrasado" {{ $status === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                            <option value="cancelado"{{ $status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>{{-- card-body --}}

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                Salvar
                            </button>
                            <a href="javascript:history.back()" class="btn btn-default">
                                Cancelar
                            </a>
                        </div>
                    </div>{{-- card --}}
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
