@extends('layouts.app', ['activePage' => 'clientes', 'titlePage' => __('Clientes')])

@section('content')
    @livewire('clientes-index')
@endsection
