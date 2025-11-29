@extends('layouts.app', [
    'activePage' => 'acessos-externos',
    'titlePage'  => __('Editar Acesso Externo')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('acessos-externos.update', $acesso->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Acesso Externo</h4>
                            <p class="card-category">Atualize os dados de acesso ao sistema/banco</p>
                        </div>

                        <div class="card-body">

                            {{-- Banco / Sistema (SELECT COM NOVO LAYOUT) --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="nome" class="ms-0">Banco / Sistema *</label>
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
                                    <div class="input-group input-group-outline my-3 w-100">
                                        <label for="link" class="form-label">Link de acesso (URL)</label>
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
                                    <div class="input-group input-group-outline my-3 w-100">
                                        <label for="usuario" class="form-label">Usuário / Login</label>
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
                                    <div class="input-group input-group-outline my-3 w-100">
                                        <label for="senha" class="form-label">Senha</label>
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
                                    <div class="input-group input-group-dynamic">
                                        <textarea name="observacao"
                                                  id="observacao"
                                                  class="form-control"
                                                  rows="3"
                                                  placeholder="Observações sobre esse acesso...">{{ old('observacao', $acesso->observacao) }}</textarea>
                                        @error('observacao')
                                            <span class="text-danger d-block mt-1">{{ $message }}</span>
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
