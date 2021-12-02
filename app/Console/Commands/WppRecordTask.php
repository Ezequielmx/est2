<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WppRecordTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wpprecord:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservas = DB::select('SELECT res_uniq.id as reserva_id, lugar, usuario, telefono, codigo_res, importe, cant_adul, cant_esp, fun1.id as func1_id, fun1.titulo, fun1.fecha, fun1.horario, fun2.id as func2_id, fun2.titulo, fun2.fecha, fun2.horario FROM 
        (SELECT DISTINCT res.id, evt.lugar, res.usuario, res.telefono, res.codigo_res, res.importe, res.cant_adul, res.cant_esp FROM 
        reservas as res
        INNER JOIN funcione_reserva as funres on res.id = funres.reserva_id
        INNER JOIN funciones as fun ON fun.id = funres.funcione_id
        INNER JOIN temas as tem ON fun.tema_id = tem.id
        INNER JOIN eventos as evt ON fun.evento_id = evt.id
        WHERE evt.activo = 1 && res.wpprecord = 0  && fun.fecha = CURRENT_DATE()
        ORDER BY res.id  DESC) as res_uniq
        
        INNER JOIN (SELECT reserva_id, min(funres.funcione_id) as f1, MAX(funres.funcione_id) as f2 FROM
        funcione_reserva as funres
        GROUP By reserva_id) as funcs
        ON res_uniq.id = funcs.reserva_id
        
        INNER JOIN 
        (SELECT funciones.id, temas.titulo, funciones.fecha, funciones.horario FROM funciones INNER JOIN temas ON funciones.tema_id = temas.id) as 
        fun1 ON fun1.id = funcs.f1
        INNER JOIN (SELECT funciones.id, temas.titulo, funciones.fecha, funciones.horario FROM funciones INNER JOIN temas ON funciones.tema_id = temas.id) as 
        fun2 ON fun2.id = funcs.f2');

        foreach($reservas as $reserva)
        {
            logger($reserva->reserva_id);
            //Storage::append("archivo.txt", $reserva[0]->id);
        }


    }
}
