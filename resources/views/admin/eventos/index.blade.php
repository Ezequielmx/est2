@extends('adminlte::page')

@section('title','Estrella del Plata')

@section('content')

    @if (session('info'))
    <div class="alert alert-success">
        <strong>{{ session('info') }}</strong>
    </div>
    @endif

    <h1 style="padding:7px"><i class="fas fa-bullhorn"></i>&nbsp;&nbsp;Eventos</h1>
    <div class="card">

        <div class="card-header">
            <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">Agregar Evento</a>    
        </div>    

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Lugar</th>
                        <th>Direccion</th>
                        <th>Ubicacion</th>
                        <th>Speach</th>
                        <th>Precio</th>
                        <th>Precio Promo</th>
                        <th>Precio Seguro</th>
                        <th>Activo</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                @foreach ($eventos as $evento)
                    <tr>
                        <td>{{ $evento->id }}</td>
                        <td>{{ $evento->lugar }}</td>
                        <td>{{ $evento->direccion }}</td>
                        <td>{{ $evento->ubicacion }}</td>
                        <td>{{ $evento->speach }}</td>
                        <td>$ {{ $evento->precio }}</td>
                        <td>$ {{ $evento->precio_prom }}</td>
                        <td>$ {{ $evento->precio_seg }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes"
                                @if ($evento->activo)
                                    checked
                                @endif                                
                                 readonly="readonly">
                            </div>
                        </td>
                        <td width="10px">
                            <a class="btn btn-info btn-sm" href="{{ route('admin.eventos.show', $evento) }}">Funciones</a>
                        </td>
                        <td width="10px">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.eventos.edit', $evento) }}">Editar</a>
                        </td>
                        <td width="10px">
                            <form action="{{ route('admin.eventos.destroy', $evento) }}" method="POST">
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

@section('js')
    <script>
        $(document).ready(function(){
            $(':checkbox[readonly=readonly]').click(function(){
                return false;        
                });
        });
    </script>
@stop


