<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evento extends Model
{
    use HasFactory;

    public function funciones(){
        return $this->hasMany('App\Models\Funcione');
    }

    public function temas_func(){
        $func_ent = DB::table('funcione_reserva')
        ->join('reservas', 'reservas.id', '=', 'funcione_reserva.reserva_id')
        //->select('funcione_reserva.funcione_id', 'cant_adul')
        ->select('funcione_reserva.funcione_id', DB::raw('SUM(cant_adul) + SUM(cant_esp)as cant_total'))
        ->groupBy('funcione_reserva.funcione_id')
        ;

        $temas_funcs = DB::table('eventos')
            ->join('funciones', 'eventos.id', '=', 'funciones.evento_id')
            ->join('temas', 'funciones.tema_id', '=', 'temas.id')
            ->select('temas.id', 'temas.titulo', 'temas.descripcion', 'temas.imagen', 'temas.video', 'temas.duracion', 'fecha', 'horario', 'capacidad', 'cant_total')
            ->orderBy('temas.id')->orderBy('fecha')->orderBy('horario')
            ->where('eventos.id', '=', $this->id)
            ->joinSub($func_ent, 'func_ent', function ($join) {
                $join->on('funciones.id', '=', 'func_ent.funcione_id');})
            ->get()
            ;
        return $temas_funcs;

    }

    public function test(){
        $func_ent = DB::table('funcione_reserva')
        ->join('reservas', 'reservas.id', '=', 'funcione_reserva.reserva_id')
        //->select('funcione_reserva.funcione_id', 'cant_adul')
        ->select('funcione_reserva.funcione_id', DB::raw('SUM(cant_adul) + SUM(cant_esp)as cant_total'))
        ->groupBy('funcione_reserva.funcione_id')
        ->get()
        ;

        return $func_ent;
    }
}