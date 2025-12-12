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

                <form id="form-proposta" method="POST" action="{{ route('propostas.store') }}">
                    @csrf

                    {{-- LINHA 1: CPF, Nome Cliente (visual), Produto --}}
                    <div class="row">

                        {{-- CPF DO CLIENTE --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="cpf" class="ms-0">CPF do Cliente</label>
                                <input type="text" name="cpf" id="cpf" class="form-control cpf-mask"
                                    value="{{ old('cpf') }}" required>
                            </div>

                            {{-- CLIENTE NÃO ENCONTRADO --}}
                            <div id="cliente-nao-encontrado" class="mt-2 d-none">
                                <span class="text-danger">Cliente não encontrado.</span>

                                <a id="btn-cadastrar-cliente" href="#" class="btn btn-sm btn-primary ml-2">
                                    Cadastrar Cliente
                                </a>
                            </div>

                            {{-- CLIENTE ENCONTRADO --}}
                            <div id="cliente-encontrado" class="mt-2 d-none">
                                <span class="text-success">
                                    Cliente encontrado:
                                    <strong id="cliente-encontrado-nome"></strong>
                                </span>
                            </div>
                        </div>

                        {{-- NOME DO CLIENTE (apenas exibição) --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Nome do Cliente</label>
                                <input type="text" id="cliente_nome" class="form-control" value="" readonly>
                            </div>
                        </div>

                        {{-- PRODUTO (com nome do banco junto) --}}
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

                        {{-- BANCO --}}
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
                                <input type="text" name="valor_bruto" id="valor_bruto" class="form-control money-mask"
                                    value="{{ old('valor_bruto') }}">
                            </div>
                        </div>

                        {{-- Valor Líquido --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Valor Líquido Liberado</label>
                                <input type="text" name="valor_liquido_liberado" id="valor_liquido_liberado"
                                    class="form-control money-mask" value="{{ old('valor_liquido_liberado') }}">
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 3: Parcela, Qtd Parcelas, Taxa --}}
                    <div class="row">
                        {{-- Valor Parcela --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Valor da Parcela</label>
                                <input type="text" name="valor_parcela" id="valor_parcela"
                                    class="form-control money-mask" value="{{ old('valor_parcela') }}">
                            </div>
                        </div>

                        {{-- Qtd Parcelas --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Qtd Parcelas</label>
                                <input type="number" name="qtd_parcelas" class="form-control"
                                    value="{{ old('qtd_parcelas') }}">
                            </div>
                        </div>

                        {{-- Taxa de Juros --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label class="ms-0">Taxa de Juros (%)</label>
                                <input type="text" name="tx_juros" id="tx_juros" class="form-control percent-mask"
                                    value="{{ old('tx_juros') }}">
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 4: Convênio + Órgão --}}
                    <div class="row">
                        {{-- Convênio --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="convenio_id" class="ms-0">Convênio</label>
                                <select name="convenio_id" id="convenio_id" class="form-control">
                                    <option value="">Selecione...</option>
                                    @foreach ($convenios as $convenio)
                                        <option value="{{ $convenio->id }}"
                                            {{ (int) old('convenio_id') === (int) $convenio->id ? 'selected' : '' }}>
                                            {{ $convenio->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Órgão Pagador (select) --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-3">
                                <label for="orgao_id" class="ms-0">Órgão pagador</label>
                                <select id="orgao_id" class="form-control">
                                    <option value="">Selecione o convênio primeiro</option>
                                </select>
                            </div>
                        </div>

                        {{-- Campo oculto que realmente vai para a coluna "orgao" da proposta --}}
                        <input type="hidden" name="orgao" id="orgao_hidden" value="{{ old('orgao') }}">
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

            // ---------- ELEMENTOS BÁSICOS ----------
            const cpfInput = document.getElementById('cpf');
            const clienteNaoEncontrado = document.getElementById('cliente-nao-encontrado');
            const clienteEncontrado = document.getElementById('cliente-encontrado');
            const clienteEncontradoNome = document.getElementById('cliente-encontrado-nome');
            const clienteNomeInput = document.getElementById('cliente_nome');
            const btnCadastrarCliente = document.getElementById('btn-cadastrar-cliente');

            const convenioSelect = document.getElementById('convenio_id');
            const orgaoSelect = document.getElementById('orgao_id');
            const orgaoHidden = document.getElementById('orgao_hidden');

            const rotaConsultaCpf = @json(route('propostas.consulta-cpf'));
            const urlCadastroClienteBase = @json(route('clientes.create'));

            // ============================================================
            // 1) BUSCA DO CLIENTE PELO CPF (preenche nome + convênio + órgão)
            // ============================================================
            function limparCliente() {
                if (clienteNaoEncontrado) clienteNaoEncontrado.classList.add('d-none');
                if (clienteEncontrado) clienteEncontrado.classList.add('d-none');
                if (clienteEncontradoNome) clienteEncontradoNome.textContent = '';
                if (clienteNomeInput) clienteNomeInput.value = '';
            }

            function limparConvenioOrgao() {
                if (convenioSelect) convenioSelect.value = '';
                if (orgaoSelect) orgaoSelect.innerHTML = '<option value="">Selecione o convênio primeiro</option>';
                if (orgaoHidden) orgaoHidden.value = '';
            }

            if (cpfInput) {
                cpfInput.addEventListener('blur', function() {
                    const cpf = cpfInput.value.trim();
                    if (!cpf) {
                        limparCliente();
                        limparConvenioOrgao();
                        return;
                    }

                    fetch(rotaConsultaCpf + '?cpf=' + encodeURIComponent(cpf), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(function(res) {
                            if (!res.ok) {
                                throw new Error('Erro na consulta de CPF');
                            }
                            return res.json();
                        })
                        .then(function(data) {
                            if (!data.exists) {
                                // CLIENTE NÃO ENCONTRADO
                                limparCliente();
                                limparConvenioOrgao();

                                if (clienteNaoEncontrado) {
                                    clienteNaoEncontrado.classList.remove('d-none');
                                }

                                if (btnCadastrarCliente) {
                                    const redirectTo = window.location.href; // volta pro create depois
                                    btnCadastrarCliente.href =
                                        urlCadastroClienteBase +
                                        '?redirect_to=' + encodeURIComponent(redirectTo) +
                                        '&cpf=' + encodeURIComponent(cpf);
                                }

                                return;
                            }

                            // CLIENTE ENCONTRADO
                            if (clienteNaoEncontrado) {
                                clienteNaoEncontrado.classList.add('d-none');
                            }
                            if (clienteEncontrado) {
                                clienteEncontrado.classList.remove('d-none');
                            }
                            if (clienteEncontradoNome) {
                                clienteEncontradoNome.textContent = data.cliente.nome || '';
                            }
                            if (clienteNomeInput) {
                                clienteNomeInput.value = data.cliente.nome || '';
                            }

                            // AUTO-PREENCHER CONVÊNIO + ÓRGÃO, SE EXISTIREM
                            const convenioIdDoCliente = data.cliente.convenio_id || null;
                            const orgaoIdDoCliente = data.cliente.orgao_id || null;

                            if (convenioIdDoCliente && convenioSelect) {
                                convenioSelect.value = String(convenioIdDoCliente);
                                carregarOrgaosDoConvenio(convenioIdDoCliente, orgaoIdDoCliente);
                            } else {
                                limparConvenioOrgao();
                            }
                        })
                        .catch(function(err) {
                            console.error(err);
                            limparCliente();
                            // não limpamos convênio/órgão aqui pra não atrapalhar o operador se já estiver preenchendo
                        });
                });
            }

            // ============================================================
            // 2) CONVÊNIO + ÓRGÃO (mesmo código que já estávamos usando)
            // ============================================================
            function carregarOrgaosDoConvenio(convenioId, orgaoSelecionadoId = null) {
                if (!orgaoSelect || !orgaoHidden) return;

                orgaoSelect.innerHTML = '<option value="">Carregando órgãos...</option>';
                orgaoHidden.value = '';

                if (!convenioId) {
                    orgaoSelect.innerHTML = '<option value="">Selecione o convênio primeiro</option>';
                    return;
                }

                fetch("{{ route('orgaos.by-convenio') }}?convenio_id=" + convenioId)
                    .then(function(res) {
                        if (!res.ok) {
                            throw new Error('Erro ao buscar órgãos');
                        }
                        return res.json();
                    })
                    .then(function(lista) {
                        if (!Array.isArray(lista)) {
                            console.error('Resposta inesperada de orgaos.by-convenio:', lista);
                            lista = [];
                        }

                        orgaoSelect.innerHTML = '<option value="">Selecione...</option>';

                        lista.forEach(function(orgao) {
                            const opt = document.createElement('option');
                            opt.value = orgao.id;
                            opt.textContent = orgao.nome;
                            orgaoSelect.appendChild(opt);
                        });

                        // Caso: veio órgão pré-selecionado (cliente)
                        if (orgaoSelecionadoId) {
                            orgaoSelect.value = String(orgaoSelecionadoId);
                            const opt = orgaoSelect.options[orgaoSelect.selectedIndex];
                            if (opt && opt.value) {
                                orgaoHidden.value = opt.textContent;
                                return;
                            }
                        }

                        // Se não há órgão selecionado, mas tem lista, pode deixar sem nada ou pegar o primeiro.
                        // Aqui vamos deixar sem nada pra forçar o operador a escolher.
                    })
                    .catch(function(err) {
                        console.error(err);
                        orgaoSelect.innerHTML = '<option value="">Erro ao carregar órgãos</option>';
                        orgaoHidden.value = '';
                    });
            }

            // Quando mudar o convênio manualmente
            if (convenioSelect) {
                convenioSelect.addEventListener('change', function() {
                    const convenioId = this.value || null;
                    carregarOrgaosDoConvenio(convenioId, null);
                });
            }

            // Sempre que mudar o órgão no select, atualiza o hidden
            if (orgaoSelect) {
                orgaoSelect.addEventListener('change', function() {
                    const opt = this.options[this.selectedIndex];
                    if (opt && opt.value) {
                        orgaoHidden.value = opt.textContent;
                    } else {
                        orgaoHidden.value = '';
                    }
                });
            }

            // --------- PRÉ-CARREGAMENTO (se algum dia usarmos convenios pré-setados aqui) ---------
            @if (!empty($convenioSelecionadoId ?? null))
                (function() {
                    const convenioInicial = "{{ $convenioSelecionadoId }}";
                    const orgaoInicial = "{{ $orgaoSelecionadoId ?? '' }}";

                    if (convenioSelect) {
                        convenioSelect.value = convenioInicial;
                        carregarOrgaosDoConvenio(convenioInicial, orgaoInicial || null);
                    }
                })();
            @endif

        });
    </script>
@endsection
