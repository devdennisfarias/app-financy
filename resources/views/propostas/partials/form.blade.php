<div class="row">
    {{-- Produto --}}
    <div class="col-md-4">
        <div class="form-group bmd-form-group">
            <label for="produto_id" class="bmd-label-floating">Selecione um Produto</label>
            <select name="produto_id" id="produto_id" class="form-control">
                <option value="">Selecione...</option>
                @foreach ($produtos as $produto)
                    <option value="{{ $produto->id }}" data-instituicao-id="{{ optional($produto->instituicao)->id }}"
                        data-instituicao-nome="{{ optional($produto->instituicao)->nome }}"
                        {{ (string) old('produto_id', isset($proposta) ? $proposta->produto_id : '') === (string) $produto->id ? 'selected' : '' }}>
                        {{ $produto->produto }}
                        @if ($produto->instituicao)
                            - {{ $produto->instituicao->nome }}
                        @endif
                    </option>
                @endforeach
            </select>
            @error('produto_id')
                <span class="text-danger d-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Instituição --}}
    <div class="col-md-4">
        <div class="form-group bmd-form-group">
            <label for="banco_id" class="bmd-label-floating">Instituição</label>
            <select name="banco_id" id="banco_id" class="form-control">
                <option value="">Selecione...</option>
                @foreach ($instituicoes as $inst)
                    <option value="{{ $inst->id }}"
                        {{ (string) old('banco_id', isset($proposta) ? $proposta->banco_id : '') === (string) $inst->id ? 'selected' : '' }}>
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
        </div>
    </div>

    {{-- aqui você pode ter outros campos (ex.: tx_juros, qtd_parcelas etc.) --}}
</div>
