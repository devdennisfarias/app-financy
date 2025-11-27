@extends('layouts.app', [
    'activePage' => 'contas-bancarias',
    'titlePage' => __('Editar Conta Bancária')
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
            <div class="col-md-8">
                <form method="POST" action="{{ route('contas-bancarias.update', $conta->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Conta Bancária</h4>
                            <p class="card-category">Atualize os dados da conta</p>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="banco_id" class="bmd-label-floating">Banco *</label>
                                <select name="banco_id" id="banco_id" class="form-control" required>
                                    <option value="">Selecione um banco</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->id }}" {{ old('banco_id', $conta->banco_id) == $banco->id ? 'selected' : '' }}>
                                            {{ $banco->nome }} @if($banco->codigo) ({{ $banco->codigo }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('banco_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nome" class="bmd-label-floating">Nome da Conta *</label>
                                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $conta->nome) }}" required>
                                @error('nome')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="agencia" class="bmd-label-floating">Agência</label>
                                <input type="text" name="agencia" id="agencia" class="form-control" value="{{ old('agencia', $conta->agencia) }}">
                                @error('agencia')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="conta" class="bmd-label-floating">Conta</label>
                                <input type="text" name="conta" id="conta" class="form-control" value="{{ old('conta', $conta->conta) }}">
                                @error('conta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tipo_conta" class="bmd-label-floating">Tipo de Conta</label>
                                <input type="text" name="tipo_conta" id="tipo_conta" class="form-control" value="{{ old('tipo_conta', $conta->tipo_conta) }}">
                                @error('tipo_conta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="saldo_inicial" class="bmd-label-floating">Saldo Inicial</label>
                                <input type="number" step="0.01" name="saldo_inicial" id="saldo_inicial" class="form-control" value="{{ old('saldo_inicial', $conta->saldo_inicial) }}">
                                @error('saldo_inicial')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('contas-bancarias.index') }}" class="btn btn-secondary">
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
