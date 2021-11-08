<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Configuracione;

class EventoController extends Controller
{
    public function show($evento_id){
        $sobreventa = Configuracione::First()->value('sobreventa');
        $evento = Evento::find($evento_id);
        return view('eventos.show', compact('evento', 'sobreventa'));
    }
}
