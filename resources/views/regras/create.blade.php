@extends('layouts.app', ['activePage' => 'regras', 'titlePage' => __('Criar Regra de comissão')])


@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('regras.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Criar Regra</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'regras.store']) !!}                                        
                                        @include('regras.partials.form')
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <button type="button" onclick="window.location='{{ route('regras.index') }}'" class="btn btn-fill btn-danger mt-2">Cancelar</button>                                                    
                                                    {!! Form::submit('Criar Regra', ['class' => 'btn btn-success mt-2']) !!}
                                                </div>
                                            </div>
                                        </div>                                        
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <!--fim card-body-->
                            <!--<div class="card-footer"></div>-->
                        </div>
                    </div>
                    <!--fim card-->
                </div>
            </div>
        </div>
        <!--container-fluid-->
    </div>

@endsection
