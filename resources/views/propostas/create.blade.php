@extends('layouts.app', [
    'activePage' => 'propostas',
    'titlePage' => __('Nova Proposta'),
])

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cabeçalho --}}
            <x-page-header title="Nova Proposta">
                <a href="{{ route('propostas.index') }}" class="btn btn-default btn-sm">
                    <i class="material-icons">list</i> Lista de Propostas
                </a>
            </x-page-header>

            {{-- Alertas --}}
            <x-session-alerts class="mb-3" />

            <x-card>

                <form method="POST" action="{{ route('propostas.store') }}">
                    @csrf

                    {{-- LINHA 1: CPF, Nome Cliente (exibição), Produto --}}
                    <div class="row">

                        {{-- CPF DO CLIENTE --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="cpf" class="ms-0">CPF do Cliente</label>
                                <input type="text" name="cpf" id="cpf" class="form-control"
                                    value="{{ old('cpf') }}" required>
                            </div>

                            {{-- BLOCO DE "CLIENTE NÃO ENCONTRADO" --}}
                            <div id="cliente-nao-encontrado" class="mt-2 d-none">
                                <span class="text-danger">Cliente não encontrado.</span>

                                <a id="btn-cadastrar-cliente" href="#" class="btn btn-sm btn-primary ml-2">
                                    Cadastrar Cliente
                                </a>
                            </div>

                            {{-- BLOCO DE "CLIENTE ENCONTRADO" --}}
                            <div id="cliente-encontrado" class="mt-2 d-none">
                                <span class="text-success">
                                    Cliente encontrado:
                                    <strong id="cliente-encontrado-nome"></strong>
                                </span>
                            </div>
                        </div>

                        {{-- NOME DO CLIENTE (APENAS EXIBIÇÃO DIDÁTICA) --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Nome do Cliente</label>
                                <input type="text" id="cliente_nome" class="form-control" value="" readonly>
                            </div>
                        </div>

                        {{-- PRODUTO (COM BANCO CONCATENADO) --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="produto_id" class="ms-0">Produto</label>
                                <select name="produto_id" id="produto_id" class="form-control" required>
                                    <option value="">Selecione</option>
                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto->id }}"
                                            data-banco-id="{{ optional($produto->instituicao)->id }}"
                                            data-banco-nome="{{ optional($produto->instituicao)->nome }}"
                                            {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                            {{ $produto->produto }}
                                            @if ($produto->instituicao)
                                                - {{ $produto->instituicao->nome }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- LINHA 2: Banco, Valor Bruto, Valor Líquido --}}
                    <div class="row">

                        {{-- BANCO (SERÁ SELECIONADO AUTOMATICAMENTE PELO PRODUTO, SE POSSÍVEL) --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="banco_id" class="ms-0">Banco</label>
                                <select name="banco_id" id="banco_id" class="form-control">
                                    <option value="">Automático pelo produto</option>
                                    @foreach ($instituicoes as $banco)
                                        <option value="{{ $banco->id }}"
                                            {{ old('banco_id') == $banco->id ? 'selected' : '' }}>
                                            {{ $banco->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Valor Bruto --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Valor Bruto</label>
                                <input type="text" name="valor_bruto" class="form-control"
                                    value="{{ old('valor_bruto') }}">
                            </div>
                        </div>

                        {{-- Valor Líquido --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Valor Líquido Liberado</label>
                                <input type="text" name="valor_liquido_liberado" class="form-control"
                                    value="{{ old('valor_liquido_liberado') }}">
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 3: Parcela, Qtd Parcelas, Taxa, Órgão --}}
                    <div class="row">
                        {{-- Valor Parcela --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Valor da Parcela</label>
                                <input type="text" name="valor_parcela" class="form-control"
                                    value="{{ old('valor_parcela') }}">
                            </div>
                        </div>

                        {{-- Qtd Parcelas --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Qtd Parcelas</label>
                                <input type="number" name="qtd_parcelas" class="form-control"
                                    value="{{ old('qtd_parcelas') }}">
                            </div>
                        </div>

                        {{-- Taxa de Juros --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Taxa de Juros</label>
                                <input type="text" name="tx_juros" class="form-control" value="{{ old('tx_juros') }}">
                            </div>
                        </div>

                        {{-- Órgão (livre – por enquanto) --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Órgão</label>
                                <input type="text" name="orgao" class="form-control" value="{{ old('orgao') }}">
                            </div>
                        </div>
                    </div>

                    {{-- BOTÕES --}}
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="material-icons">save</i> Salvar Proposta
                            </button>
                        </div>
                    </div>

                </form>

            </x-card>

        </div>
    </div>
@endsection

@section('post-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const boxNaoEncontrado = document.getElementById('cliente-nao-encontrado');
            const btnCadastrar = document.getElementById('btn-cadastrar-cliente');
            const boxEncontrado = document.getElementById('cliente-encontrado');
            const spanNomeCliente = document.getElementById('cliente-encontrado-nome');
            const inputNomeCliente = document.getElementById('cliente_nome');

            const produtoSelect = document.getElementById('produto_id');
            const bancoSelect = document.getElementById('banco_id');

            // 🔹 CPF: consulta cliente e exibe nome + opções
            cpfInput.addEventListener('blur', function() {
                let cpf = this.value.replace(/\D/g, '');
                if (!cpf) {
                    boxNaoEncontrado.classList.add('d-none');
                    boxEncontrado.classList.add('d-none');
                    inputNomeCliente.value = '';
                    return;
                }

                fetch("{{ route('propostas.consulta-cpf') }}?cpf=" + cpf)
                    .then(res => res.json())
                    .then(data => {
                        // Garante compatibilidade:
                        // - novo formato: { exists: true, cliente: {...} }
                        // - antigo: objeto direto de cliente ou false
                        let exists = false;
                        let cliente = null;

                        if (typeof data === 'object' && data !== null && 'exists' in data) {
                            // Formato novo
                            exists = !!data.exists;
                            cliente = data.cliente;
                        } else if (data && typeof data === 'object' && 'id' in data) {
                            // Formato antigo (retornando o próprio cliente)
                            exists = true;
                            cliente = data;
                        }

                        if (!exists || !cliente) {
                            // Não encontrou
                            boxNaoEncontrado.classList.remove('d-none');
                            boxEncontrado.classList.add('d-none');
                            inputNomeCliente.value = '';

                            let url = "{{ route('clientes.create') }}";
                            url += "?from=propostas.create&cpf=" + cpf;

                            btnCadastrar.href = url;
                        } else {
                            // Encontrou cliente
                            boxNaoEncontrado.classList.add('d-none');
                            boxEncontrado.classList.remove('d-none');

                            const nome = cliente.nome || '';
                            spanNomeCliente.textContent = nome;
                            inputNomeCliente.value = nome;
                        }
                    })
                    .catch(() => {
                        // Em caso de erro na requisição, não quebra a tela toda
                        boxNaoEncontrado.classList.add('d-none');
                        boxEncontrado.classList.add('d-none');
                        inputNomeCliente.value = '';
                    });
            });

            // 🔹 Produto: ao mudar, ajustar automaticamente o banco se tiver vínculo
            produtoSelect.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                const bancoId = opt.getAttribute('data-banco-id');
                const bancoNome = opt.getAttribute('data-banco-nome');

                if (bancoId) {
                    bancoSelect.value = bancoId;
                }
            });
        });
    </script>
@endsection
