<div wire:poll.3s="refreshStatus">
    @if ($operation)
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>
                                    {{ $operation->description ?? 'Operação em andamento' }}
                                </strong>
                            </div>
                            <div>
                                <span
                                    class="badge badge-pill
                                    @if ($operation->status === 'completed') badge-success
                                    @elseif($operation->status === 'failed') badge-danger
                                    @elseif($operation->status === 'running') badge-info
                                    @else badge-secondary @endif
                                ">
                                    {{ ucfirst($operation->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped
                                @if ($operation->status === 'running') active @endif"
                                role="progressbar" aria-valuenow="{{ $operation->progress }}" aria-valuemin="0"
                                aria-valuemax="100" style="width: {{ $operation->progress }}%;">
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            {{ $operation->processed_items }} de {{ $operation->total_items }} registros processados
                            @if ($operation->status === 'completed')
                                • Importação concluída
                            @elseif($operation->status === 'failed')
                                • Importação falhou (veja os detalhes no log)
                            @endif
                        </small>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
