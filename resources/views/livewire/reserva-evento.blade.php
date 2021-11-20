<div>
    
    <x-jet-danger-button wire:click="$set('open', true)">
        Reservar Entradas
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">

       <x-slot name='title'>
           <h3>Reserva de Entradas - {{ $evento->lugar }} </h3>
       </x-slot>

       <x-slot name='content'>
        @php
            setlocale(LC_TIME, "spanish");	
        @endphp 
        <form>
            @csrf
            <input type="text" class="form-control" name="evento_id" value="{{ $evento->id }}" readonly hidden>
            <div class="row">
                <div class="col">
                    <label for="usuario" class="form-label">Tu Nombre:</label>
                    <input type="text" class="form-control" placeholder="Tu nombre" name="usuario" required wire:model="usuario">
                    <x-jet-input-error for="usuario"/> 
                </div>
                <div class="col">
                    <label for="telefono" class="form-label">Celular:</label>
                    <input type="cel" class="form-control" name="telefono" placeholder="Sin 0 y sin 15 Ej: 1160208707" pattern="[0-9]{10}" required wire:model="tel">
                    <x-jet-input-error for="tel"/> 
                </div>
            </div>
            <br>
    
            <div class="row">
                <div class="col">
                    <label for="funcion1">Selecciona la función 1</label>
                    <select class="form-control" name="funcion1" wire:model="selectedFunc1">
                        @foreach ($funciones as $funcion)
                            @if ($funcion->func_id == $func_id )
                                <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>    
                            @endif
                            
                        @endforeach
                        @foreach ( $funciones as $funcion)
                        @if ($funcion->func_id != $func_id && ($funcion->capacidad * (1 + $sobreventa/100))-($funcion->cant_total)) >0)
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
                        @foreach ( $funciones as $funcion2)
                            @if ($funcion2->func_id !=  $selectedFunc1 && ($funcion2->capacidad * (1 + $sobreventa/100))-($funcion2->cant_total)) >0)
                                <option value="{{ $funcion2->func_id }}">{{ $funcion2->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion2->fecha))) }} - {{ $funcion2->horario }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <br>
    
            <div class="row">
                <div class="col">
                    <label for="cant_adul">Entradas:</label>
                    <input type="number" class="form-control" name="cant_adul" min="1" max={{ $maxEntr }} value="1" wire:model="entr_gral">
                </div>
                <div class="col"><br>
                    <span style="text-align: right"><h3>Total: <b>  {{'$ ' .  number_format($entr_gral * $precio) }}</b></h3></span>
                </div>
            </div>

            

        </form>
        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save">
                Reservar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
