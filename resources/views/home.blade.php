@extends('layouts.plantilla')

@section('title', 'EVENTOS')

@section('content')
    <h1>HOME EVENTOS</h1>

    @foreach ($eventos as $evento)
        <li>
            <a href="{{ route('evento.show', $evento->id) }}">{{ $evento->lugar}}
            </a>
        </li>
    @endforeach
@endsection