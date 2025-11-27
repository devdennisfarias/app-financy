@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Gerenciar Usuários')])


@section('content')
    @livewire('users-index')
@endsection
