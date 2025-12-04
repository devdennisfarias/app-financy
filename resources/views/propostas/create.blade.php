@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Cadastro de Propostas')])

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

        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- BLOCO AVISO CLIENTE NÃO ENCONTRADO --}}
        <div id="cliente-nao-encontrado" class="d-none">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Cliente não cadastrado</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Button trigger modal -->
            <button id="modalButton" type="button" rel="tooltip" class="btn btn-success" data-toggle="modal"
                data-target="#cadastrar_cliente">
                Cadastrar cliente
                <i class="material-icons">add</i>
            </button>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cadastro de Propostas</h4>
                        </div>

                        <form name="cadastro_proposta" method="post" action="{{ route('propostas.store') }}"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        {{-- CPF + NOME CLIENTE + VENDEDOR --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">CPF Cliente</label>
                                                    <input id="cpf" type="text" class="form-control" name="cpf"
                                                        value="{{ old('cpf') }}">
                                                    <input type="hidden" id="cliente_id" name="cliente_id"
                                                        value="{{ old('cliente_id') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nome Cliente</label>
                                                    <input id="nome_cliente" type="text" class="form-control"
                                                        value="{{ old('nome_cliente') }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Vendedor</label>
                                                    <input value="{{ $user->name }}" readonly="readonly" type="text"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ORGÃO --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Orgão</label>
                                                    <input id="orgao" type="text" class="form-control" name="orgao"
                                                        value="{{ old('orgao') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- PRODUTO + BANCO + VALORES --}}
                                        <div class="row">
                                            {{-- Produto primeiro --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Selecione um Produto</label>
                                                    <select id="produto_id" class="form-control" name="produto_id" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}"
                                                                data-instituicao-id="{{ optional($produto->instituicao)->id }}"
                                                                data-instituicao-nome="{{ optional($produto->instituicao)->nome }}"
                                                                {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                                                {{ $produto->produto }}
                                                                @if ($produto->instituicao)
                                                                    — {{ $produto->instituicao->nome }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Banco - somente leitura, preenchido pelo produto --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Banco / Instituição</label>

                                                    {{-- visível (readonly) --}}
                                                    <input id="banco_label" type="text" class="form-control"
                                                        value="{{ old('banco') }}" readonly>

                                                    {{-- hidden que vão pro backend --}}
                                                    <input type="hidden" name="banco" id="banco"
                                                        value="{{ old('banco') }}">
                                                    <input type="hidden" name="banco_id" id="banco_id"
                                                        value="{{ old('banco_id') }}">
                                                </div>
                                            </div>

                                            {{-- Valor Bruto --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Bruto</label>
                                                    <input id="valor_bruto" type="text" class="form-control"
                                                        name="valor_bruto" value="{{ old('valor_bruto') }}">
                                                </div>
                                            </div>

                                            {{-- Valor Líquido --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor Líquido Liberado</label>
                                                    <input id="valor_liquido_liberado" type="text"
                                                        class="form-control" name="valor_liquido_liberado"
                                                        value="{{ old('valor_liquido_liberado') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- JUROS / PARCELA / PRAZO --}}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tx de Júros</label>
                                                    <input id="tx_juros" type="text" class="form-control"
                                                        name="tx_juros" value="{{ old('tx_juros') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Valor da Parcela</label>
                                                    <input id="valor_parcela" type="text" class="form-control"
                                                        name="valor_parcela" value="{{ old('valor_parcela') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Qtd Parcelas</label>
                                                    <input type="number" class="form-control" name="qtd_parcelas"
                                                        value="{{ old('qtd_parcelas') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- BENEFÍCIOS / SALÁRIOS (informativos, preenchidos via CPF) --}}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício</label>
                                                    <input id="especie_beneficio_1" readonly="readonly" type="text"
                                                        class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário</label>
                                                    <input id="salario_1" readonly="readonly" type="text"
                                                        class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Espécie Benefício 2</label>
                                                    <input id="especie_beneficio_2" readonly="readonly" type="text"
                                                        class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Salário 2</label>
                                                    <input id="salario_2" readonly="readonly" type="text"
                                                        class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- DOCUMENTOS --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="btn btn-success" for="file">
                                                        <i class="material-icons">books</i>
                                                        <span>Selecionar documentos</span>
                                                    </label>
                                                    <input id="file" style="display:none" type="file"
                                                        name="documentos[]" multiple>
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
                                                        class="btn btn-fill btn-success">Cadastrar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- col-md-12 -->
                                </div><!-- row -->
                            </div><!-- card-body -->
                        </form>
                    </div> <!-- fim card -->
                </div><!-- fim col-12 -->
            </div><!-- fim row -->
        </div><!-- fim container-fluid -->
    </div><!-- Fim content -->

    {{-- MODAL CADASTRO CLIENTE (igual ao original, só acrescente se quiser campo "convenio" aqui também) --}}
    {{-- ... mantive exatamente como você mandou, para não quebrar nada ... --}}
    {{-- se quiser depois eu monto a versão desse modal com o campo de convênio direitinho --}}

@endsection

@section('post-script')
    <script>
        // Consulta CPF e preenche dados do cliente
        $(document).ready(function() {
            $("#cpf").blur(function() {
                let cpf = $("#cpf").val();
                $.get("{{ route('propostas.consulta-cpf') }}", {
                    cpf: cpf
                }, function(data, status) {
                    if (data == false) {
                        $("#cliente-nao-encontrado").removeClass("d-none");
                        $('#cpfModal').val($("#cpf").val());
                        $('#nome_cliente').val('');
                        $('#cliente_id').val('');
                        $('#especie_beneficio_1').val('');
                        $('#salario_1').val('');
                        $('#especie_beneficio_2').val('');
                        $('#salario_2').val('');
                    } else {
                        $("#cliente-nao-encontrado").addClass("d-none");

                        $('#cliente_id').val(data['id'] ?? '');
                        $('#nome_cliente').val(data['nome'] ?? '');

                        $('#orgao').val(data['orgao_1']);
                        $('#salario_1').val(data['salario_1']);
                        $('#especie_beneficio_1').val(data['especie_beneficio_1']);
                        $('#salario_2').val(data['salario_2']);
                        $('#especie_beneficio_2').val(data['especie_beneficio_2']);
                    }
                });

            });
        });

        // Ao trocar o produto, preencher banco (readonly) + banco_id
        document.addEventListener('DOMContentLoaded', function() {
            var produtoSelect = document.getElementById('produto_id');
            var bancoLabel = document.getElementById('banco_label'); // visível
            var bancoInput = document.getElementById('banco'); // hidden name="banco"
            var bancoIdInput = document.getElementById('banco_id'); // hidden name="banco_id"

            if (!produtoSelect) return;

            // limpa banco se não tiver produto selecionado
            if (!produtoSelect.value) {
                if (bancoLabel) bancoLabel.value = '';
                if (bancoInput) bancoInput.value = '';
                if (bancoIdInput) bancoIdInput.value = '';
            }

            produtoSelect.addEventListener('change', function() {
                var opt = produtoSelect.options[produtoSelect.selectedIndex];
                if (!opt) return;

                var instId = opt.getAttribute('data-instituicao-id');
                var instNome = opt.getAttribute('data-instituicao-nome');

                if (bancoLabel) {
                    bancoLabel.value = instNome || '';
                }
                if (bancoInput) {
                    bancoInput.value = instNome || '';
                }
                if (bancoIdInput) {
                    bancoIdInput.value = instId || '';
                }
            });
        });
    </script>
@endsection
