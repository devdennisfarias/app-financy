@extends('layouts.app', ['activePage' => 'minhas-propostas', 'titlePage' => __('Minhas Propostas')])

@section('content')
    @livewire('minhas-propostas-index')
@endsection
