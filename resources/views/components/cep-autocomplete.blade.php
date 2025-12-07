<div class="row">
    <div class="col-md-2">
        <div class="input-group input-group-static mb-3">
            <label for="cep" class="ms-0">CEP <span class="text-danger">*</span></label>
            <input type="text" id="cep" name="cep" class="form-control" value="{{ old('cep', $cep ?? '') }}">
        </div>
    </div>

    <div class="col-md-5">
        <div class="input-group input-group-static mb-3">
            <label for="endereco" class="ms-0">Endereço</label>
            <input type="text" id="endereco" name="endereco" class="form-control"
                value="{{ old('endereco', $endereco ?? '') }}">
        </div>
    </div>

    <div class="col-md-2">
        <div class="input-group input-group-static mb-3">
            <label for="numero" class="ms-0">Número</label>
            <input type="text" id="numero" name="numero" class="form-control"
                value="{{ old('numero', $numero ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="input-group input-group-static mb-3">
            <label for="complemento" class="ms-0">Complemento</label>
            <input type="text" id="complemento" name="complemento" class="form-control"
                value="{{ old('complemento', $complemento ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="input-group input-group-static mb-3">
            <label for="bairro" class="ms-0">Bairro</label>
            <input type="text" id="bairro" name="bairro" class="form-control"
                value="{{ old('bairro', $bairro ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="input-group input-group-static mb-3">
            <label for="cidade" class="ms-0">Cidade</label>
            <input type="text" id="cidade" name="cidade" class="form-control"
                value="{{ old('cidade', $cidade ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="input-group input-group-static mb-3">
            <label for="estado" class="ms-0">Estado</label>
            <select id="estado" name="estado" class="form-control">
                <option value="">Selecione</option>
                @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                    <option value="{{ $uf }}" {{ old('estado', $estado ?? '') == $uf ? 'selected' : '' }}>
                        {{ $uf }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cepInput = document.getElementById('cep');

            if (!cepInput) return;

            cepInput.addEventListener('blur', function() {
                const cep = cepInput.value.replace(/\D/g, '');

                if (cep.length !== 8) return;

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            document.getElementById('cidade').value = data.localidade || '';
                            document.getElementById('estado').value = data.uf || '';
                        }
                    });
            });
        });
    </script>
@endpush
