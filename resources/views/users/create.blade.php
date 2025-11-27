@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Criar Usuário')])


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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <h5>Ocorreu um erro.</h5>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Formulário de Cadastro</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'users.store']) !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                {!! Form::label('name', 'Nome', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                {!! Form::label('email', 'E-mail', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                {!! Form::label('password', 'Senha', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                {!! Form::label('password', 'Confirmar Senha', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">                                                
                                                <div class="card-body">
                                                    <h4>Permissões</h4>
                                                    @foreach ($roles as $role)
                                                        <div>
                                                            <label>
                                                                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                                                                {{ $role->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('loja', 'Loja', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::select('loja', $lojas, null, ['class' => 'form-control', 'id' => 'lojaUser', 'placeholder' => 'Lojas']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('equipe', 'Equipe', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::select('equipe', ['' => 'Equipe'], null, ['class' => 'form-control', 'id' => 'equipeUser']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('regra', 'Regra de comissão', ['class' => 'bmd-label-floating']) !!}
                                                {!! Form::select('regra', $regras, $user->regra_id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione uma regra de comissão']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <button type="button" onclick="window.location='{{ route('users.index') }}'" class="btn btn-fill btn-danger float-right">Cancelar</button> -->

                                    {!! Form::submit('Cadastrar', ['class' => 'btn btn-fill btn-success mt-2 float-right']) !!}
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
    <!--content-->

@endsection
