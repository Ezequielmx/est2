<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    public function show($evento_id){
        $evento = Evento::find($evento_id);
        return view('eventos.show', compact('evento'));
    }
}
