@extends('layouts.plantilla')

@section('title', 'EVENTOS')

@section('content')
    <h1>HOME EVENTOS</h1>

    <div class="container mx-auto">
        <x-alert1 />
    </div>

    @foreach ($eventos as $evento)
        <li>
            <a href="{{ route('evento.show', $evento->id) }}">{{ $evento->lugar}}
            </a>
        </li>
    @endforeach
@endsection