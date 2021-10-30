<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class HomeController extends Controller
{
    public function __invoke()
    {
        $eventos = Evento::where('activo', 1)->get();
        return view('home', compact('eventos'));
    }
}
