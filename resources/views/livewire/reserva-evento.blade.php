<div>
    
    <x-jet-danger-button wire:click="$set('open', true)">
        Reservar Entradas
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">

       <x-slot name='title'>
           <h3 style="color: #d30b1d"><b> Reserva de Entradas - {{ $evento->lugar }} </b></h3>
           <hr style="color: #d30b1d; border-top: 4px solid;">
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
                    <b><label for="usuario" class="form-label">Tu Nombre:</label></b>
                    <input type="text" class="form-control" placeholder="Tu nombre" name="usuario" required wire:model="usuario">
                    <x-jet-input-error for="usuario"/> 
                </div>
                <div class="col">
                    <b><label for="telefono" class="form-label">Celular:</label></b>
                    <input type="cel" class="form-control" name="telefono" placeholder="Sin 0 y sin 15 Ej: 1160208707" pattern="[0-9]{10}" required wire:model="tel">
                    <x-jet-input-error for="tel"/> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <b><label for="funcion1">Selecciona la primer función</label></b>
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
            <p style="color: #e4414f; margin-bottom:0px;">Si sacás entradas para dos funciones <b>tenés  descuento!</b>
                Pagás el <b>precio promocional de ${{ $evento->precio_prom }} </b>cada entrada!</p>
            <div class="row">
                <div class="col">
                    <b><label for="funcion2">Selecciona la segunda función (opcional)</label></b>
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
                    <b><label for="cant_adul">Cantidad de Entradas Generales-Adultos - $ {{ $precio }}c/u:</label></b>
                    <input type="number" class="form-control" name="cant_adul" min="1" max={{ $maxEntr }} value="1" wire:model="entr_gral">
                </div>
                <div class="col">
                    <b><label for="cant_men">Cantidad de Entradas Niños menores de 3 años - $ {{ $evento->precio_seg }}c/u::</label></b>
                    <input type="number" class="form-control" name="cant_men" min="0" max={{ $maxEntr }} value="1" wire:model="entr_seg">
                </div>
                <div class="col"><br>
                    <span style="text-align: right"><h3>Total: <b>  {{'$ ' .  number_format($entr_gral * $precio * $cant_funciones + $entr_seg * $evento->precio_seg) }}</b></h3></span>
                </div>
                {{ $func1->id }}
                {{ $func1->cant_total }}
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
