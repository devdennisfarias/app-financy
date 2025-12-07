@props([
    'title' => null,
    'headerClass' => 'card-header-primary',
    'bodyClass' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    {{-- Header opcional --}}
    @if ($title || isset($header))
        <div class="card-header {{ $headerClass }}">
            <div class="row">
                <div class="col-md-6">
                    @if ($title)
                        <h4 class="card-title mb-0">{{ $title }}</h4>
                    @endif

                    {{-- Slot de header extra (filtros, descrição etc) --}}
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>

                {{-- Ações à direita no header (botões etc) --}}
                @isset($actions)
                    <div class="col-md-6 text-right">
                        {{ $actions }}
                    </div>
                @endisset
            </div>
        </div>
    @endif

    {{-- Body --}}
    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>

    {{-- Footer opcional --}}
    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @elseif(isset($footerSlot))
        <div class="card-footer">
            {{ $footerSlot }}
        </div>
    @endif
</div>
