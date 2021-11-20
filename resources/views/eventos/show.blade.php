<x-app-layout>
    @php
    setlocale(LC_TIME, "spanish");	
    $tema=0;
    $fecha=0;
    @endphp 

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div 
            class="mt-4 rounded enc-evt"
            style="background-image: url({{ $evento->imagen }}); ">
            <div class="row p-3 text-white" >
                <div class="col-md-6 col-lg-4">
                    <h1 class="respneg fgr">{{ $evento->lugar }}</h1>
                    <p class="respneg">
                        {{ $evento->speach }}
                    </p>
                    
                    <span class="badge bg-danger" style="font-size:1.1em">Entrada Gral: ${{ $evento->precio }}</span>
                </div>
                <div class="col-md-6 col-lg-4 recbco">
                    <h2 style="color: #990412"><i class="fa fa-map-marker"></i>   Donde?</h2>
                    <p>{{ $evento->direccion }}</p>   
                    <h2 style="color: #990412"><i class="fa fa-calendar"></i>   Cuando?</h2>
                    @foreach ($evento->fechas() as $fecha)
                        <p> {{ utf8_encode(strftime("%A %d de %B", strtotime($fecha->fecha))) }}</p>
                    @endforeach
                    <h2 style="color: #990412"><i class="fa fa-clock-o"></i>   Duración</h2>
                    <p>{{ $evento->duracion()->minutos }} minutos</p>   
                </div>
                <div class="col-md-6 col-lg-4">
                    <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBF4E4xSn_YB3mYUTLP54iHedi4Mng4SDA&q={{ $evento->ubicacion }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <br>
            @livewire('reserva-evento', ['evento'=>$evento])  
        <br>
        <h2>Funciones</h2>
        <div class="row mt-4" >
            <div>
            @foreach ( $evento->temas_func() as $funcion)

                    @if ($funcion->id != $tema)
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card" style="width:100%">
                                <img class="card-img-top" src={{ $funcion->imagen }} alt="Card image" style="width:100%">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $funcion->titulo }} </h4>
                                    <p class="card-text">{{ $funcion->descripcion }} </p>
                                </div>
                            </div>
                            @php
                                $tema =  $funcion->id;
                                $fecha=0;
                            @endphp     
                    @endif

                    @if ($funcion->fecha != $fecha)
                        <br>
                        <h3>
                            <i class="fa fa-calendar" aria-hidden="true"></i> {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }}
                        </h3>
                        @php
                            $fecha = $funcion->fecha
                        @endphp
                        
                    @endif
                    @php
                        $disp = ($funcion->capacidad * (1 + $sobreventa/100))-($funcion->cant_total)
                    @endphp


                    <div class="flexh">
                        <div class="hor">
                            <span class="txthor">{{ strftime("%H:%M", strtotime($funcion->horario))}} hs.</span> 
                            @if ($disp > 0)
                                {{ min($disp, rand(10,25)) }} disponibles 
                            @endif
                        </div>
                        <div class="btnres">
                            @if ($disp > 0)
                                @livewire('reserva-evento', ['evento'=>$evento, 'func_id'=>$funcion->func_id])
                            @else
                                Entradas agotadas 
                            @endif
                        </div>
                    </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
