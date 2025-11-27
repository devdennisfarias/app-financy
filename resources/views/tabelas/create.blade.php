@extends('layouts.app', ['activePage' => 'tabelas', 'titlePage' => __('Criar Tabela')])


@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('tabelas.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Criar Tabela</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'tabelas.store']) !!}                                        
                                        @include('tabelas.partials.form')
                                        <div class="col-md-12 text-right">
                                            <div class="form-group">                                                
                                                {!! Form::submit('Criar Tabela', ['class' => 'btn btn-success mt-2']) !!}
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
