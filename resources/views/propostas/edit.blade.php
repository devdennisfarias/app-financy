@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Editar Proposta')])

@section('content')
    <div class="content">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Ocorreu um Erro!</strong>
                <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Confirmação!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('propostas.index') }}" class="btn btn-sm btn">
                        <i class="material-icons">reply</i>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Editar Proposta #{{ $proposta->id }}</h4>
                        </div>

                        <form name="editar_proposta" method="post" action="{{ route('propostas.update', $proposta->id) }}"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        {{-- CPF + CLIENTE + VENDEDOR --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">CPF Cliente</label>
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ optional($proposta->cliente)->cpf ?? '-' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nome Cliente</label>
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ optional($proposta->cliente)->nome ?? '-' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vendedor</label>
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ optional($proposta->vendedor)->name ?? $user->name }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ORGÃO + STATUS --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão</label>
                                                    <input id="orgao" type="text" class="form-control" name="orgao"
                                                        value="{{ old('orgao', $proposta->orgao) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Status da Proposta</label>
                                                    <select name="status_atual_id" class="form-control">
                                                        <option value="">Selecione...</option>
                                                        @foreach ($statusList as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ (int) old('status_atual_id', $proposta->status_atual_id) === (int) $status->id ? 'selected' : '' }}>
                                                                {{ $status->status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- PRODUTO + BANCO + VALORES --}}
                                        <div class="row">
                                            {{-- Produto --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Produto</label>
                                                    <select id="produto_id" class="form-control" name="produto_id" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}"
                                                                data-instituicao-id="{{ optional($produto->instituicao)->id }}"
                                                                data-instituicao-nome="{{ optional($produto->instituicao)->nome }}"
                                                                {{ (int) old('produto_id', $proposta->produto_id) === (int) $produto->id ? 'selected' : '' }}>
                                                                {{ $produto->produto }}
                                                                @if ($produto->instituicao)
                                                                    — {{ $produto->instituicao->nome }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Banco (readonly) --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco</label>

                                                    @php
                                                        $bancoNome = old('banco', $proposta->banco);
                                                    @endphp

                                                    <input id="banco_label" type="text" class="form-control"
                                                        value="{{ $bancoNome }}" readonly>

                                                    <input type="hidden" name="banco" id="banco"
                                                        value="{{ $bancoNome }}">
                                                    <input type="hidden" name="banco_id" id="banco_id"
                                                        value="{{ old('banco_id', $proposta->banco_id) }}">
                                                </div>
                                            </div>

                                            {{-- Valor Bruto --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Bruto</label>
                                                    <input id="valor_bruto" type="text" class="form-control money"
                                                        name="valor_bruto"
                                                        value="{{ old('valor_bruto', $proposta->valor_bruto !== null ? number_format($proposta->valor_bruto, 2, ',', '.') : '') }}">
                                                </div>
                                            </div>

                                            {{-- Valor Líquido --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Líquido Liberado</label>
                                                    <input id="valor_liquido_liberado" type="text"
                                                        class="form-control money" name="valor_liquido_liberado"
                                                        value="{{ old('valor_liquido_liberado', $proposta->valor_liquido_liberado !== null ? number_format($proposta->valor_liquido_liberado, 2, ',', '.') : '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- JUROS / PARCELA / PRAZO --}}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tx de Júros</label>
                                                    <input id="tx_juros" type="text" class="form-control money"
                                                        name="tx_juros"
                                                        value="{{ old('tx_juros', $proposta->tx_juros !== null ? number_format($proposta->tx_juros, 2, ',', '.') : '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor da Parcela</label>
                                                    <input id="valor_parcela" type="text" class="form-control money"
                                                        name="valor_parcela"
                                                        value="{{ old('valor_parcela', $proposta->valor_parcela !== null ? number_format($proposta->valor_parcela, 2, ',', '.') : '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Qtd Parcelas</label>
                                                    <input type="number" class="form-control" name="qtd_parcelas"
                                                        value="{{ old('qtd_parcelas', $proposta->qtd_parcelas) }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- CAMPOS INFORMATIVOS DO CLIENTE (somente leitura) --}}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício</label>
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ optional($proposta->cliente)->especie_beneficio_1 ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário</label>
                                                    @php
                                                        $sal1 = optional($proposta->cliente)->salario_1;
                                                    @endphp
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ $sal1 !== null ? 'R$ ' . number_format($sal1, 2, ',', '.') : '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício 2</label>
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ optional($proposta->cliente)->especie_beneficio_2 ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário 2</label>
                                                    @php
                                                        $sal2 = optional($proposta->cliente)->salario_2;
                                                    @endphp
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ $sal2 !== null ? 'R$ ' . number_format($sal2, 2, ',', '.') : '-' }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- BOTÕES --}}
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <button type="button"
                                                        onclick="window.location='{{ route('propostas.index') }}'"
                                                        class="btn btn-fill btn-danger">Cancelar</button>
                                                    <button type="submit"
                                                        class="btn btn-fill btn-success">Salvar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div> {{-- col --}}
                                </div>{{-- row --}}
                            </div>{{-- card-body --}}
                        </form>
                    </div>{{-- card --}}
                </div>{{-- col --}}
            </div>{{-- row --}}
        </div>{{-- container-fluid --}}
    </div>{{-- content --}}
@endsection

@section('post-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var produtoSelect = document.getElementById('produto_id');
            var bancoLabel = document.getElementById('banco_label');
            var bancoInput = document.getElementById('banco');
            var bancoIdInput = document.getElementById('banco_id');

            if (produtoSelect) {
                produtoSelect.addEventListener('change', function() {
                    var opt = produtoSelect.options[produtoSelect.selectedIndex];
                    if (!opt) return;

                    var instId = opt.getAttribute('data-instituicao-id');
                    var instNome = opt.getAttribute('data-instituicao-nome');

                    if (bancoLabel) bancoLabel.value = instNome || '';
                    if (bancoInput) bancoInput.value = instNome || '';
                    if (bancoIdInput) bancoIdInput.value = instId || '';
                });
            }

            // MÁSCARA CAMPOS MONETÁRIOS (edição)
            function aplicarMascaraMoney(input) {
                input.addEventListener('input', function() {
                    let v = input.value;
                    v = v.replace(/\D/g, '');

                    if (!v) {
                        input.value = '';
                        return;
                    }

                    v = (parseInt(v, 10) / 100).toFixed(2);
                    v = v.replace('.', ',');

                    input.value = v;
                });

                // formata valor inicial
                if (input.value) {
                    let v = input.value.toString();
                    v = v.replace(/\./g, '').replace(',', '');
                    if (v) {
                        v = (parseInt(v, 10) / 100).toFixed(2);
                        v = v.replace('.', ',');
                        input.value = v;
                    }
                }
            }

            document.querySelectorAll('.money').forEach(function(input) {
                aplicarMascaraMoney(input);
            });

            const form = document.querySelector("form[name='editar_proposta']");
            if (form) {
                form.addEventListener('submit', function() {
                    document.querySelectorAll('.money').forEach(function(input) {
                        let v = input.value;
                        if (!v) return;

                        v = v.replace(/\./g, '').replace(',', '.');

                        input.value = v;
                    });
                });
            }
        });
    </script>
@endsection
