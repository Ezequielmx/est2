@extends('adminlte::page')

@section('title','Estrella del Plata')

@section('content')
    @php
        setlocale(LC_TIME, "spanish");
    @endphp	

    @if (session('info'))
    <div class="alert alert-success">
        <strong>{{ session('info') }}</strong>
    </div>
    @endif

    <h1 style="padding:7px"><i class="fas fa-ticket-alt"></i>&nbsp;&nbsp;Reservas</h1>
    <div class="card">

        <div class="card-header">
            <h2><b>{{ $funcione->evento->lugar }}</b></h2>
            <hr>
            <h2>{{ $funcione->tema->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcione->fecha))) }} - {{ strftime("%H:%M", strtotime($funcione->horario))}} hs.</h2>
           
            <a href="{{ route('admin.eventos.show', $funcione->evento) }}" class="btn btn-secondary">
                <div style='text-align:center;'><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Volver</div>  
            </a>    
        </div>    

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Código</th>
                        <th>Importe</th>
                        <th>Cantidad</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($funcione->reservas as $reserva) 
                    <tr>
                        <td>{{ $reserva->usuario }}</td>
                        <td>{{ $reserva->telefono }}</td>
                        <td>{{ $reserva->codigo_res }}</td>
                        <td>$ {{ $reserva->importe }}</td>
                        <td>{{ $reserva->cant_adul }}</td>
                        <td width="10px">
                            <form action="{{ route('admin.reservas.destroy', $reserva) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                    
                @endforeach 

            </table>
        </div>
    </div>

@stop

@section('css')

    <link rel="stylesheet" href="/css/admin.css">

@stop
