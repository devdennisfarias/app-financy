<div class="row mt-3">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('nome', 'Nome', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
            @error('nome')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
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
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('qtd_vendas', 'Quantidade de Vendas', ['class' => 'bmd-label-floating']) !!}
            {!! Form::number('qtd_vendas', null, ['class' => 'form-control']) !!}
            @error('qtd_vendas')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::select('produto', $produtos, $meta->produto_id ?? null, ['class' => 'form-control', 'id' => 'produto', 'placeholder' => 'Selecione um Produto']) !!}
            @error('produto_id')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
</div>
