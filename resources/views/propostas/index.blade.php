@extends('layouts.app', ['activePage' => 'propostas', 'titlePage' => __('Lista de propostas')])

@section('content')
	@livewire('propostas-index')
@endsection