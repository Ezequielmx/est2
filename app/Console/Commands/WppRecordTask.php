<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mike4ip\ChatApi;

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
        setlocale(LC_TIME, "spanish");
        
        $reservas = DB::select('SELECT res_uniq.id as reserva_id, lugar, direccion, usuario, telefono, codigo_res, importe, cant_adul, cant_esp, 
        fun1.id as func1_id, fun1.titulo f1_titulo, fun1.fecha as f1_fecha, fun1.horario as f1_horario, fun2.id as func2_id, fun2.titulo as f2_titulo, fun2.fecha as f2_fecha, fun2.horario as f2_horario FROM 
        (SELECT DISTINCT res.id, evt.lugar, evt.direccion, res.usuario, res.telefono, res.codigo_res, res.importe, res.cant_adul, res.cant_esp FROM 
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

        $api = new ChatApi(
            'yb7lq7jpotu31kgq', // Chat-Api.com token
            'https://api.chat-api.com/instance361534' // Chat-Api.com API url
        );

        foreach($reservas as $reserva)
        {
            $cel = "549". $reserva->telefono;
        
            $mens = "*Hola $reserva->usuario*. Hoy está el *Planetario Móvil* en ";
            $mens .= "*$reserva->lugar!!* ($reserva->direccion). Te reenviamos los datos de tu reserva para que los tengas a mano: \n";
            $mens .= "CODIGO DE RESERVA: *$reserva->codigo_res*\n";
            $mens .= "Cantidad de Entradas: *$reserva->cant_adul*\n";
            $mens .= "Seguro (niños entre 1 y 2 años ó CUD): *$reserva->cant_esp*\n";
            $mens .= "----------------\n";

            if ($reserva->func2_id != $reserva->func1_id) {
                $mens .= "Funciones: \n";
                $mens .= "* *" . $reserva->f1_titulo. " - " . utf8_encode(strftime("%A %d de %B", strtotime($reserva->f1_fecha))). " a las " . strftime("%H:%M", strtotime($reserva->f1_horario)) . " hs.*\n";
                $mens .= "* *" . $reserva->f2_titulo. " - " . utf8_encode(strftime("%A %d de %B", strtotime($reserva->f2_fecha))). " a las " . strftime("%H:%M", strtotime($reserva->f2_horario)) . " hs.*\n";
            }
            else
            {
                $mens .= "Funcion: \n";
                $mens .= "* *" . $reserva->f1_titulo. " - " . utf8_encode(strftime("%A %d de %B", strtotime($reserva->f1_fecha))). " a las " . strftime("%H:%M", strtotime($reserva->f1_horario)) . " hs.*\n";
            }
            $mens .= "-Duración de cada función: *35minutos*-\n";
            $mens .= "----------------\n";
            $mens .= "Importe Total: *$". $reserva->importe . "*\n";
            $mens .= "----------------\n";
            $mens .= "*". "¿Cómo y cuándo se retiran las entradas?" . "*\n";
            $mens .= "Tenés que estar 30 min antes para asegurar tu lugar y abonar la entrada en el lugar del evento. *Si no llegás las entradas pasan a disponibilidad*\n\n";
            $mens .= "*Medios de pago? | Solo en efectivo*\n\n";
            $mens .= "Por favor sino vas al evento, avísanos, así la reserva se la damos a otra persona que si quiera ir!\n\nLa reserva de entradas es *un compromiso de asistencia  al evento*. Pedimos por favor, que no nos fallen. *Gracias!*";

            //logger($cel . " - " . $mens);

            if ($api->sendPhoneMessage($cel, $mens) == true)
            {
                $resbd = DB::table('reservas')
                        ->where('id', $reserva->reserva_id)
                        ->update(['wpprecord' => 1]);
            } 
        }


    }
}
