<div>
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
                        <h2 style="color: #990412"><i class="fa fa-map-marker"></i>   Cuando?</h2>
                        @foreach ($evento->fechas() as $fecha)
                            <p> {{ utf8_encode(strftime("%A %d de %B", strtotime($fecha->fecha))) }}</p>
                        @endforeach
                        <h2 style="color: #990412"><i class="fa fa-map-marker"></i>   Duración</h2>
                        <p>{{ $evento->duracion()->minutos }} minutos</p>   
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6567.690907891331!2d-58.39183372246401!3d-34.60806930070792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sar!4v1635725127059!5m2!1sen!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
    
                        <li>
                            {{ $funcion->horario }} - 
                            @if ($disp == 0)
                                entradas agotadas     
                            @else
                                @if ($disp > $funcion->capacidad)   
                                    {{ $funcion->capacidad }} disponibles                     
                                @else
                                    {{ $disp }} disponibles      
                                @endif
                                @livewire('reserva-evento', ['evento'=>$evento, 'func_id'=>$funcion->func_id])
                            @endif
                            <br> 
                        </li>
                @endforeach
            </div>
        </div>
    
    </x-app-layout>
</div>
