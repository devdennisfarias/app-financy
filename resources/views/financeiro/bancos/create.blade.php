@extends('layouts.app', [
    'activePage' => 'financeiro-bancos',
    'titlePage' => __('Novo Banco')
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
                <form method="POST" action="{{ route('bancos.store') }}">
                    @csrf

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Novo Banco</h4>
                            <p class="card-category">Informe os dados do banco</p>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="nome" class="bmd-label-floating">Nome do Banco *</label>
                                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="codigo" class="bmd-label-floating">Código (opcional)</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}">
                                @error('codigo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('bancos.index') }}" class="btn btn-secondary">
                                <i class="material-icons">arrow_back</i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="material-icons">save</i> Salvar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
