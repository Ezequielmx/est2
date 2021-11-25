@extends('adminlte::page')

@section('title','Estrella del Plata')

@section('content')
    <h1>Configuraciones Generales</h1>
    <div class="card">
        <div class="card-body">
            {!! Form::model($generale, ['route' =>['admin.generales.create'], 'files' => true, 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('speach', 'Speach general') !!}
                {!! Form::textarea('speach', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Speach General']) !!}
            
                @error('speach')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('minutos', 'Duración (minutos)') !!}
                        {!! Form::number('minutos', null, ['class' => 'form-control', 'placeholder' => 'Seleccione Duración']) !!}

                        @error('minutos')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('sobreventa', 'Sobreventa (porcentaje)') !!}
                        {!! Form::number('sobreventa', null, ['class' => 'form-control', 'placeholder' => 'Seleccione porcentaje de sobreventa']) !!}

                        @error('sobreventa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="col">

                    <div class="form-group">
                        {!! Form::label('precio', 'Precio General') !!}
                        {!! Form::number('precio', null, ['class' => 'form-control', 'placeholder' => 'Seleccione Precio General']) !!}

                        @error('precio')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('precio_prom', 'Precio Promocional (2 eventos)') !!}
                        {!! Form::number('precio_prom', null, ['class' => 'form-control', 'placeholder' => 'Seleccione Precio Promocional']) !!}

                        @error('precio_prom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="image-wrapper">
                    <img id="imagen_gral" src="{{ Storage::url($generale->imagen) }}" alt="">
                </div>

                {!! Form::label('imagen', 'Imagen generica de Evento') !!}
                {!! Form::file('imagen', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
                <p>Selecciona una imagen. Medida recomendada:  1250 x 320 pixeles.</p>

                @error('imagen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>

                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop

@section('css')
    <style>
        .image-wrapper{
            position: relative;
            padding-bottom: 25%;
        }

        .image-wrapper img{
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }


    </style>
@stop

@section('js')
    <script>
        document.getElementById("imagen").addEventListener('change', cambiarImagen);

            function cambiarImagen(event){
                var file = event.target.files[0];

                var reader = new FileReader();
                reader.onload = (event) => {
                    document.getElementById("imagen_gral").setAttribute('src', event.target.result);
                };

                reader.readAsDataURL(file);
            }
    </script>
    

@stop