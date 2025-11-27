<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('cod', 'COD', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('cod', null, ['class' => 'form-control']) !!}
            @error('cod')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('prazo', 'Prazo', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('prazo', null, ['class' => 'form-control']) !!}
            @error('prazo')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('coeficiente', 'Coeficiente', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('coeficiente', null, ['class' => 'form-control']) !!}
            @error('coeficiente')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('taxa', 'Taxa', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('taxa', null, ['class' => 'form-control']) !!}
            @error('taxa')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('vigencia', 'Vigência', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('vigencia', null, ['class' => 'form-control']) !!}
            @error('vigencia')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
</div>
