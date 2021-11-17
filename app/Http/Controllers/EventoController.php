<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Generale;

class EventoController extends Controller
{
    protected $listeners = ['render'];

    public function show($evento_id){
        $sobreventa = Generale::First()->value('sobreventa');
        $evento = Evento::find($evento_id);
        return view('eventos.show', compact('evento', 'sobreventa'));
    }
}
