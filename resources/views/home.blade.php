@extends('layouts.plantilla')

@section('title', 'EVENTOS')

@section('content')
    @php
        setlocale(LC_TIME, "spanish");	
    @endphp 
    <h1>HOME EVENTOS</h1>

        <div class="row">
            @foreach ($eventos as $evento)
                @php
                    $img = $evento->imagen;
                @endphp             
                    <div class="col-md-6 col-lg-4">
                        <a class="deco-none" href="{{ route('evento.show', $evento->id) }}">
                        <div class="card" style="width:100%">
                            <img class="card-img-top" src={{ $evento->imagen }} alt="Card image" style="width:100%">
                            <div class="card-body">
                              <h4 class="card-title">{{ $evento->lugar }}</h4>
                                @foreach ($evento->fechas() as $fecha)
                                <li>
                                  {{ utf8_encode(strftime("%A %d de %B", strtotime($fecha->fecha))) }}
                                </li>
                                @endforeach
                              <p class="card-text">{{ $evento->speach }}</p>
                            </div>
                          </div>
                        </a>
                    </div>  
            @endforeach
        </div>
@endsection