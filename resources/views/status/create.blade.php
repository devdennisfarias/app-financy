@extends('layouts.app', ['activePage' => 'status', 'titlePage' => __('Criar Status')])


@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('status.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Criar Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    {!! Form::open(['route' => 'status.store']) !!}
                                        
                                        @include('status.partials.form')

                                        {!! Form::submit('Criar Status', ['class' => 'btn btn-success mt-2']) !!}
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
