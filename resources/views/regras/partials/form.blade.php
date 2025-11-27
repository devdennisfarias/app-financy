<div class="row mt-3">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('regra', 'Regra', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('regra', null, ['class' => 'form-control']) !!}
            @error('regra')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('descricao', 'Descrição', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
            @error('descricao')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Produtos</h4>
                <span>Selecione a porcentagem de comissão desta regra para cada produto</span>
            </div>
            <div class="card-body">
                <div class="row row-cols-3">
                    @if ($regras_produtos)
                        @foreach ($regras_produtos as $regra_produto)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">
                                        {{ $regra_produto->produto->produto }}
                                        {!! Form::text('produtos[]', $regra_produto->produto->id, ['class' => 'form-control mr-2 d-none']) !!}
                                    </label>
                                    {!! Form::text('comissoes[]', $regra_produto->comissao, ['class' => 'regraComissao form-control mr-2']) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($produtos as $produto)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">
                                        {{ $produto->produto }}
                                        {!! Form::text('produtos[]', $produto->id, ['class' => 'form-control mr-2 d-none']) !!}
                                    </label>
                                    {!! Form::text('comissoes[]', null, ['class' => 'regraComissao form-control mr-2']) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
