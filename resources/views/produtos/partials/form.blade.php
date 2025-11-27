<div class="row mt-3">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('produto', 'Produto', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('produto', null, ['class' => 'form-control']) !!}
            @error('produto')
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
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Tabelas</h4>
                @foreach ($tabelas as $tabela)
                    <div class="form-group">
                        <label class="bmd-label-floating">
                            {!! Form::checkbox('tabelas[]', $tabela->id, null, ['class' => 'mr-2']) !!}
                            {{ $tabela->nome }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
