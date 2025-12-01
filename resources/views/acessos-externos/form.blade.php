@extends('layouts.app', [
    'activePage' => $activePage ?? 'acessos-externos',
    'titlePage' => $titulo ?? 'Acesso Externo',
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ $titulo ?? 'Acesso Externo' }}</h4>
                            <p class="card-category">Cadastro de bancos, plataformas e sistemas externos</p>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ $route }}">
                                @csrf
                                @if (isset($method) && strtoupper($method) === 'PUT')
                                    @method('PUT')
                                @endif

                                {{-- Nome --}}
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Nome') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <input type="text" name="nome" class="form-control"
                                                value="{{ old('nome', $acesso->nome) }}" required>
                                            @error('nome')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Link --}}
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Link de acesso') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <input type="text" name="link" class="form-control"
                                                value="{{ old('link', $acesso->link) }}">
                                            @error('link')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Ex.: https://sistema.banco.com.br
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Usuário / Login --}}
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Usuário / Login') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <input type="text" name="usuario" class="form-control"
                                                value="{{ old('usuario', $acesso->usuario) }}">
                                            @error('usuario')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Senha (texto puro) --}}
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Senha') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <input type="text" name="senha" class="form-control"
                                                value="{{ old('senha', $acesso->senha) }}">
                                            @error('senha')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                A senha será exibida mascarada na listagem.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Observação --}}
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Observação') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <textarea name="observacao" class="form-control" rows="3">{{ old('observacao', $acesso->observacao) }}</textarea>
                                            @error('observacao')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Botões --}}
                                <div class="card-footer ml-auto mr-auto">
                                    <a href="{{ route('acessos-externos.index') }}" class="btn btn-default mr-2">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ $buttonText ?? 'Salvar' }}
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
