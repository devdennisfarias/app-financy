@props([
    'convenios' => [],
    'orgaos' => [],
    'selectedConvenio' => null,
    'selectedOrgao' => null,
])

<div class="row">

    {{-- CONVÊNIO --}}
    <div class="col-md-6">
        <div class="input-group input-group-static mb-3">
            <label for="convenio_id" class="ms-0">Convênio</label>

            {{-- esse select não precisa de "name", é só controlador visual --}}
            <select id="convenio_id" class="form-control">
                <option value="">Selecione...</option>

                @foreach ($convenios as $convenio)
                    <option value="{{ $convenio->id }}"
                        {{ old('convenio_id', $selectedConvenio) == $convenio->id ? 'selected' : '' }}>
                        {{ $convenio->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ÓRGÃO PAGADOR --}}
    <div class="col-md-6">
        <div class="input-group input-group-static mb-3">
            <label for="orgao_id" class="ms-0">Órgão Pagador</label>

            <select name="orgao_id" id="orgao_id" class="form-control">
                <option value="">Selecione o convênio primeiro...</option>

                @foreach ($orgaos as $orgao)
                    <option value="{{ $orgao->id }}" data-convenio="{{ $orgao->convenio_id }}"
                        {{ old('orgao_id', $selectedOrgao) == $orgao->id ? 'selected' : '' }}>
                        {{ $orgao->nome }}
                        @if ($orgao->convenio)
                            — {{ $orgao->convenio->nome }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const convenioSelect = document.getElementById('convenio_id');
            const orgaoSelect = document.getElementById('orgao_id');

            if (!convenioSelect || !orgaoSelect) {
                return;
            }

            function filtrarOrgaos() {
                const convenioId = convenioSelect.value;

                let encontrou = false;

                Array.from(orgaoSelect.options).forEach(option => {
                    const convenioOption = option.getAttribute('data-convenio');

                    // pula a opção padrão (sem data-convenio)
                    if (!convenioOption) {
                        return;
                    }

                    if (convenioId === '' || convenioOption === convenioId) {
                        option.hidden = false;
                        encontrou = true;
                    } else {
                        option.hidden = true;
                        option.selected = false;
                    }
                });

                if (!encontrou && convenioId !== '') {
                    orgaoSelect.value = '';
                }
            }

            convenioSelect.addEventListener('change', filtrarOrgaos);

            // Executa no carregamento (edição)
            filtrarOrgaos();
        });
    </script>
@endpush
