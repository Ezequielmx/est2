<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function show($evento_id){
        return view('eventos.show', compact('evento_id'));
    }
}
