@extends('layouts.plantilla')

@section('title', 'EVENTOS')

@section('content')
    <h1>HOME EVENTOS</h1>

    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($eventos as $evento)
                @php
                    $img = $evento->imagen;
                @endphp
                    <a href="{{ route('evento.show', $evento->id) }}">    
                        <x-card img="{{ $img }}">
                            <x-slot name='titulo'>
                                {{ $evento->lugar }}
                            </x-slot>
                            {{ $evento->speach }}
                            @foreach ($evento->fechas() as $fecha)
                                <li>
                                    {{ $fecha->fecha }}
                                </li>
                            @endforeach
                        </x-card>
                    </a>   
            @endforeach
        </div>
    </div>
@endsection