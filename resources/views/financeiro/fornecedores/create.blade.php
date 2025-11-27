@extends('layouts.app', [
    'activePage' => 'fornecedores',
    'titlePage'  => __('Novo Fornecedor')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="{{ route('fornecedores.store') }}" autocomplete="off">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Novo Fornecedor</h4>
                            <p class="card-category">Cadastro de fornecedor</p>
                        </div>
                        <div class="card-body">
                            @include('financeiro.fornecedores._form')
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-default">
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
