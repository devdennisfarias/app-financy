@extends('layouts.app', ['activePage' => 'equipes', 'titlePage' => __('Editar de Equipes')])

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
                <strong>Ocorreu um Erro!</strong>
                <br><br>
                <ul>
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
                    <a href="{{ route('equipes.index') }}" class="btn btn-sm btn"><i class="material-icons">reply</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form id="form_lojas" method="post" action="{{ route('equipes.update', $equipe->id) }}" class="form-horizontal">
                            @method('PUT')
                            @csrf
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Formulário de Cadastro</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Equipe</label>
                                                    <input id="equipe" type="text" class="form-control" name="equipe" value="{{ $equipe->equipe }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select id="inputState" class="form-control" name="loja_id">
                                                        <option value="{{ $equipe->loja_id }}">{{ $equipe->loja->loja }}</option>
                                                        @foreach ($lojas as $loja)
                                                            @if ($loja->id != $equipe->loja->id)
                                                                <option value="{{ $loja->id }}">{{ $loja->loja }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-fill btn-success">Atualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--fim card-body-->

                            <!--<div class="card-footer">
                                                    
                                                </div>-->
                        </form>
                    </div>
                    <!--fim card-->
                </div>
            </div>
        </div>
        <!--container-fluid-->
    </div>
    <!--content-->
@endsection
