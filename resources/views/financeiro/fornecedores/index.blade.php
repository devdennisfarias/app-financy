@extends('layouts.app', [
    'activePage' => 'fornecedores',
    'titlePage'  => __('Fornecedores')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Fornecedores</h4>
                            <p class="card-category">Cadastro de fornecedores da FinancyCred</p>
                        </div>
                        <a href="{{ route('fornecedores.create') }}" class="btn btn-success btn-sm">
                            <i class="material-icons">add</i> Novo Fornecedor
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($fornecedores->isEmpty())
                            <p>Nenhum fornecedor cadastrado.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Documento</th>
                                            <th>Telefone</th>
                                            <th>Email</th>
                                            <th>Contato</th>
                                            <th class="text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fornecedores as $f)
                                            <tr>
                                                <td>{{ $f->nome }}</td>
                                                <td>{{ $f->documento }}</td>
                                                <td>{{ $f->telefone }}</td>
                                                <td>{{ $f->email }}</td>
                                                <td>{{ $f->contato }}</td>
                                                <td class="td-actions text-right">
                                                    <a href="{{ route('fornecedores.edit', $f->id) }}"
                                                       class="btn btn-primary btn-link btn-sm" title="Editar">
                                                        <i class="material-icons">edit</i>
                                                    </a>

                                                    <form action="{{ route('fornecedores.destroy', $f->id) }}"
                                                          method="POST"
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('Deseja realmente excluir este fornecedor?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-link btn-sm"
                                                                title="Excluir">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $fornecedores->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
