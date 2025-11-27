@extends('layouts.app', [
    'activePage' => 'fornecedores',
    'titlePage'  => __('Editar Fornecedor')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="{{ route('fornecedores.update', $fornecedor->id) }}" autocomplete="off">
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Fornecedor</h4>
                            <p class="card-category">{{ $fornecedor->nome }}</p>
                        </div>
                        <div class="card-body">
                            @include('financeiro.fornecedores._form', ['fornecedor' => $fornecedor])
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-default">
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
