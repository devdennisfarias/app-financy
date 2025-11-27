@extends('layouts.app', [
    'activePage' => 'acessos-externos',
    'titlePage'  => __('Novo Acesso Externo')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('acessos-externos.store') }}">
                    @csrf

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Novo Acesso Externo</h4>
                            <p class="card-category">Cadastro de bancos, portais e sistemas externos</p>
                        </div>

                        <div class="card-body">

                            {{-- Banco / Sistema (select de bancos) --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="nome" class="bmd-label-floating">Banco / Sistema *</label>
                                        <select name="nome" id="nome" class="form-control" required>
                                            <option value="">Selecione...</option>
                                            @foreach($bancos as $nomeBanco => $nomeBancoExibicao)
                                                <option value="{{ $nomeBanco }}"
                                                    {{ old('nome', $acesso->nome) == $nomeBanco ? 'selected' : '' }}>
                                                    {{ $nomeBancoExibicao }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nome')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Link --}}
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="link" class="bmd-label-floating">Link de acesso (URL)</label>
                                        <input type="text"
                                               name="link"
                                               id="link"
                                               class="form-control"
                                               value="{{ old('link', $acesso->link) }}">
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Usuário e Senha --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="usuario" class="bmd-label-floating">Usuário / Login</label>
                                        <input type="text"
                                               name="usuario"
                                               id="usuario"
                                               class="form-control"
                                               value="{{ old('usuario', $acesso->usuario) }}">
                                        @error('usuario')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="senha" class="bmd-label-floating">Senha</label>
                                        <input type="text"
                                               name="senha"
                                               id="senha"
                                               class="form-control"
                                               value="{{ old('senha', $acesso->senha) }}">
                                        @error('senha')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Observação --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label for="observacao" class="bmd-label-floating">Observação</label>
                                        <textarea name="observacao"
                                                  id="observacao"
                                                  class="form-control"
                                                  rows="3">{{ old('observacao', $acesso->observacao) }}</textarea>
                                        @error('observacao')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('acessos-externos.index') }}" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
