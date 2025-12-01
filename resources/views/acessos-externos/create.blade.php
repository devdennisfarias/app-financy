@extends('layouts.app', [
    'activePage' => 'acessos-externos',
    'titlePage' => __('Novo Acesso Externo'),
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
                                <h4 class="card-title">Cadastrar Acesso Externo</h4>
                                <p class="card-category">Registre login e senha de bancos/sistemas</p>
                            </div>

                            <div class="card-body">

                                {{-- Banco / Sistema - SELECT NOVO LAYOUT --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="nome" class="ms-0">Banco / Sistema *</label>
                                            <select name="nome" id="nome" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                @foreach ($bancos as $nomeBanco => $nomeBancoExibicao)
                                                    <option value="{{ $nomeBanco }}"
                                                        {{ old('nome') == $nomeBanco ? 'selected' : '' }}>
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
                                            <label for="link" class="form-label">Link de Acesso (URL)</label>
                                            <input type="text" name="link" id="link" class="form-control"
                                                value="{{ old('link') }}">
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
                                            <input type="text" name="usuario" id="usuario" class="form-control"
                                                value="{{ old('usuario') }}">
                                            @error('usuario')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline my-3 w-100">
                                            <label for="senha" class="form-label">Senha</label>
                                            <input type="text" name="senha" id="senha" class="form-control"
                                                value="{{ old('senha') }}">
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
                                            <textarea name="observacao" id="observacao" class="form-control" rows="3" placeholder="Observações opcionais">{{ old('observacao') }}</textarea>
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
