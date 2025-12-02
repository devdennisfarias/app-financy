@extends('layouts.app', [
    'activePage' => 'produtos',
    'titlePage'  => __('Editar Produto')
])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- CABEÇALHO --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Editar Produto</h4>
                        <p class="card-category">Atualize as informações deste produto</p>
                    </div>

                    <div class="card-body">

                        {{-- ERROS DE VALIDAÇÃO --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- FORMULÁRIO --}}
                        <form method="POST"
                              action="{{ route('produtos.update', $produto->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Partial do Formulário --}}
                            @include('produtos.partials.form')

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">

                                    <a href="{{ route('produtos.index') }}"
                                       class="btn btn-default">
                                        Voltar
                                    </a>

                                    <button type="submit"
                                            class="btn btn-primary">
                                        Salvar Alterações
                                    </button>

                                </div>
                            </div>
                        </form>

                    </div> {{-- card-body --}}
                </div> {{-- card --}}
            </div> {{-- col --}}
        </div> {{-- row --}}

    </div> {{-- container --}}
</div> {{-- content --}}
@endsection

{{-- Scripts adicionais usados no formulário --}}
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle       = document.getElementById('nova_instituicao_toggle');
    var camposDiv    = document.getElementById('nova_instituicao_campos');
    var selectInst   = document.getElementById('banco_id');

    if (!toggle || !camposDiv || !selectInst) {
        return;
    }

    function atualizarVisibilidadeCampos() {
        if (toggle.checked) {
            camposDiv.style.display = 'block';
            selectInst.value = '';
            selectInst.disabled = true;
        } else {
            camposDiv.style.display = 'none';
            selectInst.disabled = false;

            document.getElementById('nova_instituicao_nome').value = '';
            document.getElementById('nova_instituicao_tipo').value = '';
            document.getElementById('nova_instituicao_codigo').value = '';
        }
    }

    toggle.addEventListener('change', atualizarVisibilidadeCampos);

    // Se havia erro e veio preenchido, mantém aberto
    @if(old('nova_instituicao_nome'))
        toggle.checked = true;
        atualizarVisibilidadeCampos();
    @endif
});
</script>
@endpush
