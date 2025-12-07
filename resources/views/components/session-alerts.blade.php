{{-- Exibe automaticamente mensagens de sessão: success, error, warning, info --}}

@if (session('success'))
    <x-alert type="success" title="Confirmação!" :message="session('success')" />
@endif

@if (session('error'))
    <x-alert type="danger" title="Erro!" :message="session('error')" />
@endif

@if (session('warning'))
    <x-alert type="warning" title="Atenção!" :message="session('warning')" />
@endif

@if (session('info'))
    <x-alert type="info" title="Informação:" :message="session('info')" />
@endif
