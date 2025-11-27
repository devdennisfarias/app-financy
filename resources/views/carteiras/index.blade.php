@extends('layouts.app', ['activePage' => 'carteiras', 'titlePage' => __('Carteira de Clientes')])

@section('content')
    @livewire('carteiras-index')
@endsection
