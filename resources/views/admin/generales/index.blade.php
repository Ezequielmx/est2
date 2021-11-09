@extends('adminlte::page')

@section('title','Configuraciones generales')

@section('content header')
    <h1>Lista de configuraciones generales</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Speach</th>
                        <th>Minutos</th>
                        <th>Precio</th>
                        <th>Precio Especial</th>
                        <th>Precio Promocion</th>
                        <th>Sobreventa</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($generales as $generale)
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    @endforeach
                </tbody>


            </table>
           
            <p>Bienvenido al manual de su reactor de fision lenta fisionador 52 </p>

        </div>
    </div>
@stop

