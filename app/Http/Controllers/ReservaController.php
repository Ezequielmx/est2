<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function create($evento_id){
        $evento = Evento::find($evento_id);
        return view('reservas.create', compact('evento'));
    }

    public function store(Request $request){
        
        $reserva = new Reserva();

        $reserva->codigo_res="ASD1234";
        $reserva->importe='1000';

        $reserva->usuario = $request->usuario;
        $reserva->telefono = $request->telefono;
        $reserva->cant_adul = $request->cant_adul;
        $reserva->cant_esp = $request->cant_esp;
        $reserva->wppconf = '0';
        $reserva->wpprecord = '0';

        //$reserva->save();

        //$reserva->funciones()->attach($request->funcion1);

        $lala = $request->funcion2;
        
        return $lala;




    }
}
