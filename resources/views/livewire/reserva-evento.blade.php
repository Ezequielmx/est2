<div>
    
    <x-jet-danger-button wire:click="$set('open', true)">
        Reservar Entradas
    </x-jet-danger-button>


    <x-jet-dialog-modal wire:model="open">

       <x-slot name='title'>
           RESERVA {{ $evento->lugar }} 
       </x-slot>

       <x-slot name='content'>
        @php
            setlocale(LC_TIME, "spanish");	
        @endphp 
        <form action="{{ route('reserva.store') }}" method="POST">
            @csrf
            <input type="text" class="form-control" name="evento_id" value="{{ $evento->id }}" readonly hidden>
            <div class="row">
                <div class="col">
                    <label for="usuario" class="form-label">Tu Nombre:</label>
                    <input type="text" class="form-control" placeholder="Tu nombre" name="usuario" required>
                </div>
                <div class="col">
                    <label for="telefono" class="form-label">Celular:</label>
                    <input type="cel" class="form-control" name="telefono" placeholder="Sin 0 y sin 15 Ej: 1160208707" pattern="[0-9]{10}" required>
                </div>
            </div>
            <br>
    
            <div class="row">
                <div class="col">
                    <label for="funcion1">Selecciona la función 1</label>
                    <select class="form-control" name="funcion1" wire:model="selectedFunc1">
                        @foreach ( $funciones as $funcion)
                            @if ($funcion->func_id == $func_id )
                                <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>    
                            @endif
                            
                        @endforeach
                        @foreach ( $funciones as $funcion)
                        @if ($funcion->func_id != $func_id )
                            <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>    
                        @endif
                        
                        @endforeach
                    </select>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col">
                    <label for="funcion2">Selecciona la segunda función</label>
                    <select class="form-control" name="funcion2" wire:model="selectedFunc2">
                        <option value="" >------------------------------</option>
                        @foreach ( $funciones as $funcion)
                            <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <br>
    
            <div class="row">
                <div class="col">
                    <label for="cant_adul">Entradas:</label>
                    <input type="number" class="form-control" name="cant_adul" min="1" value="1" wire:model="entr_gral">
                </div>
                <div class="col"><br>
                    <span style="text-align: right"><h3>Total: <b>  {{'$ ' .  number_format($entr_gral * $precio) }}</b></h3></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>

        </form>
        </x-slot>

        <x-slot name='footer'>
                
        </x-slot>
    </x-jet-dialog-modal>
</div>
