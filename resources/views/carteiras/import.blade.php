@extends('layouts.app', [
    'activePage' => 'carteiras',
    'titlePage' => __('Importar Carteira de Clientes'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Importar Carteira de Clientes">
                <a href="{{ route('carteiras.index') }}" class="btn btn-default btn-sm">
                    <i class="material-icons">arrow_back</i> Voltar para Carteira
                </a>
            </x-page-header>

            {{-- Alertas de sessão --}}
            <x-session-alerts class="mb-3" />

            {{-- Formulário de upload --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Arquivo de Clientes</h4>
                            <p class="card-category">
                                Envie um arquivo CSV na ordem: <strong>nome, telefone1, telefone2, telefone3</strong>
                            </p>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('carteiras.import.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="file">Selecione o arquivo CSV</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror" required>

                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <small class="form-text text-muted">
                                        Separador padrão: ponto e vírgula (;). A primeira linha pode ser cabeçalho.
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons">cloud_upload</i> Iniciar Importação
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Barra de status em tempo (import_carteira) --}}
            <livewire:long-operation-status type="import_carteira" />

        </div>
    </div>
@endsection
