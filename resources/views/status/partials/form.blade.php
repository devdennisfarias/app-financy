<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('status', 'Status', ['class' => 'bmd-label-floating']) !!}
            {!! Form::text('status', null, ['class' => 'form-control']) !!}
            @error('name')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::select('status_tipo', $status_tipos, $status->status_tipo_id ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>  
</div>
