@extends('layouts.app', ['activePage' => 'regras', 'titlePage' => __('Editar Regras de Comissão')])


@section('content')

    <div class="content">

        @if (session('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('info') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

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
                            <h4 class="card-title ">Editar Regra</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::model($regra, ['route' => ['regras.update', $regra], 'method' => 'put']) !!}
                                    @include('regras.partials.form')
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <div class="form-group">
                                                <button type="button" onclick="window.location='{{ route('regras.index') }}'" class="btn btn-fill btn-danger mt-2">Cancelar</button>                                                    
                                                {!! Form::submit('Atualizar Regra', ['class' => 'btn btn-success mt-2']) !!}
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
