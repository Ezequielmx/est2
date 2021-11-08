<div>
    <form action="{{ route('reserva.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col">
                <label for="usuario" class="form-label">Tu Nombre:</label>
                <input type="text" class="form-control" placeholder="Tu nombre" name="usuario">
            </div>
            <div class="col">
                <label for="telefono" class="form-label">Celular:</label>
                <input type="cel" class="form-control" name="telefono" placeholder="Sin 0 y sin 15 Ej: 1160208707" pattern="[0-9]{10}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="funcion1">Selecciona la función 1</label>
                <select class="form-control" name="funcion1">
                    @foreach ( $evento->temas_func() as $funcion)
                        <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="funcion2">Selecciona la segunda función</label>
                <select class="form-control" name="funcion2">
                    <option value="-1">------------------------------</option>
                    @foreach ( $evento->temas_func() as $funcion)
                        <option value="{{ $funcion->func_id }}">{{ $funcion->titulo }} - {{ utf8_encode(strftime("%A %d de %B", strtotime($funcion->fecha))) }} - {{ $funcion->horario }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="row">
            <div class="col">
                <label for="cant_adul">Entradas Mayores - ${{ $evento->precio }}:</label>
                <input type="number" class="form-control" name="cant_adul" min="1" value="1">
            </div>

            <div class="col">
                <label for="cant_esp">Entradas Niños - ${{ $evento->precio }}:</label>
                <input type="number" class="form-control" name="cant_esp" min="1" value="1">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>