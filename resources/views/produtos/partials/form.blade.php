<div class="row mt-3">
    {{-- Nome do produto --}}
    <div class="col-md-4">
        <div class="form-group bmd-form-group">
            <label  for="produto">Nome do Produto</label>
            <input type="text" name="produto" id="produto" class="form-control"
                value="{{ old('produto', isset($produto) ? $produto->produto : '') }}">
            @error('produto')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Instituição existente --}}
    <div class="col-md-4">
        <div class="form-group bmd-form-group">
            <label  for="banco_id">
                Instituição (Banco / Promotora / Fintech)
            </label>
            <select name="banco_id" id="banco_id" class="form-control">
                <option value="">Selecione...</option>
                @foreach ($instituicoes as $inst)
                    <option value="{{ $inst->id }}"
                        {{ (string) old('banco_id', isset($produto) ? $produto->banco_id : '') === (string) $inst->id ? 'selected' : '' }}>
                        {{ $inst->nome }}
                        @if ($inst->tipo)
                            ({{ $inst->tipo }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('banco_id')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror

            {{-- Toggle para cadastrar nova instituição --}}
            <div class="form-check mt-2">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" id="nova_instituicao_toggle">
                    Cadastrar nova instituição
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
        </div>
    </div>

    {{-- Campos da nova instituição (nome + tipo + código) --}}
    <div class="col-md-4" id="nova_instituicao_campos" style="display: none;">
        <div class="form-group bmd-form-group">
            <label  for="nova_instituicao_nome">Nome da nova instituição</label>
            <input type="text" name="nova_instituicao_nome" id="nova_instituicao_nome" class="form-control"
                value="{{ old('nova_instituicao_nome') }}">
            @error('nova_instituicao_nome')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group bmd-form-group">
            <label  for="nova_instituicao_tipo">Tipo da nova instituição</label>
            <select name="nova_instituicao_tipo" id="nova_instituicao_tipo" class="form-control">
                <option value="">Selecione...</option>
                @foreach ($tiposInstituicao as $valor => $label)
                    <option value="{{ $valor }}"
                        {{ old('nova_instituicao_tipo') === $valor ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
                @error('nova_instituicao_tipo')
                    <span class="text-danger d-block">{{ $message }}</span>
                @enderror
            </select>
        </div>

        <div class="form-group bmd-form-group">
            <label  for="nova_instituicao_codigo">Código (opc.)</label>
            <input type="text" name="nova_instituicao_codigo" id="nova_instituicao_codigo" class="form-control"
                value="{{ old('nova_instituicao_codigo') }}">
            @error('nova_instituicao_codigo')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- Descrição do produto --}}
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label  for="descricao">Descrição</label>
            <input type="text" name="descricao" id="descricao" class="form-control"
                value="{{ old('descricao', isset($produto) ? $produto->descricao : '') }}">
            @error('descricao')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
