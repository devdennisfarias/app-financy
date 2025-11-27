@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Criar Permissão')])


@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Criar Permissão</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    {!! Form::open(['route' => 'roles.store']) !!}
                                        
                                        @include('roles.partials.form')

                                        {!! Form::submit('Criar Permissão', ['class' => 'btn btn-success mt-2']) !!}
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
