@extends('layouts.plantilla')

@section('title', 'EVENTO')

@section('content')

<h1>EVENTO: {{ $evento->lugar }}</h1>
<li>Ubicacion: {{ $evento->ubicacion }}</li>
<li>Direccion: {{ $evento->direccion }}</li>
<li>Speach: {{ $evento->speach }}</li>
<li>Precio: {{ $evento->precio }}</li>
<li>Precio Especial: {{ $evento->precio_esp }}</li>
<li>Precio Promocional: {{ $evento->precio_prom }}</li>
<li>Imagen: {{ $evento->imagen }}</li>

    <br><br>
    @php
       $tema=0;
       $fecha=0;
    @endphp 
    @foreach ( $evento->temas_func() as $funcion)
        @if ($funcion->id != $tema)
            <h2>
                {{ $funcion->titulo }}
                @php
                    $tema =  $funcion->id;
                    $fecha=0;
                @endphp     
            </h2>
        @endif
        @if ($funcion->fecha != $fecha)
            <h3>
                {{ $funcion->fecha }}
                @php
                    $fecha = $funcion->fecha
                @endphp
            </h3>
        @endif
        <li>
            {{ $funcion->horario }} - {{ $funcion->capacidad }} - {{ $funcion->cant_total }}
        </li>
    @endforeach
@endsection
