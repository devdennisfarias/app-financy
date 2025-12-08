@extends('layouts.app', [
    'activePage' => 'orgaos',
    'titlePage' => __('Novo Órgão Pagador'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <x-page-header title="Novo Órgão Pagador">
                <a href="{{ route('orgaos.index') }}" class="btn btn-default btn-sm">
                    <i class="material-icons">arrow_back</i> Voltar
                </a>
            </x-page-header>

            <x-session-alerts class="mb-3" />

            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-card title="Dados do Órgão Pagador">
                <form method="POST" action="{{ route('orgaos.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-3">
                                <label for="nome" class="ms-0">
                                    Nome <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nome" id="nome" class="form-control"
                                    value="{{ old('nome') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="convenio_id" class="ms-0">
                                    Convênio <span class="text-danger">*</span>
                                </label>
                                <select name="convenio_id" id="convenio_id" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach ($convenios as $conv)
                                        <option value="{{ $conv->id }}"
                                            {{ old('convenio_id') == $conv->id ? 'selected' : '' }}>
                                            {{ $conv->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check mt-4">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="ativo" value="1"
                                        {{ old('ativo', 1) ? 'checked' : '' }}>
                                    Ativo
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">save</i> Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection
