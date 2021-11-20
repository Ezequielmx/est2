<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Reserva;
use App\Models\Funcione;
use App\Models\Tema;
use App\Services\GoogleSheet;


class ReservaController extends Controller
{
    public function create($evento_id, $func_id = null){
        $evento = Evento::find($evento_id);
        return view('reservas.create', ['evento' => $evento, 'func_id' => $func_id]);
    }

    public function store(Request $request){

        setlocale(LC_TIME, "spanish");

        $evt = Evento::find($request->evento_id);
        
        $reserva = new Reserva();

        $precio = 0;

        $reserva->codigo_res="ASD1234";

        if ($request->funcion2 == null) {
            $precio = $evt->precio;
        }
        else{
            $precio = $evt->precio_prom * 2;
        }

        $reserva->importe=$request->cant_adul * $precio;

        $reserva->usuario = $request->usuario;
        $reserva->telefono = $request->telefono;
        $reserva->cant_adul = $request->cant_adul;
        $reserva->wppconf = '0';
        $reserva->wpprecord = '0';

        $reserva->save();

        $reserva->funciones()->attach($request->funcion1);
    
        if (!is_null($request->funcion2)) {
            $reserva->funciones()->attach($request->funcion2);
        }

        //PARA SHEETS
        $func1 = Funcione::find($request->funcion1);
        $tema1 = Tema::find($func1->tema_id);

        $values = [[
            $evt->id, $evt->lugar, 
            $request->funcion1, 
            $tema1->titulo, 
            $func1->fecha, 
            $func1->horario, 
            str_pad($reserva->id, 4 ,"0", STR_PAD_LEFT), 
            $reserva->usuario, 
            $reserva->telefono,
            $reserva->cant_adul,
            $reserva->importe,
            $func1->capacidad 
        ]];

        if (!is_null($request->funcion2)) {
            $func2 = Funcione::find($request->funcion2);
            $tema2 = Tema::find($func2->tema_id);
            $data2 = [
                $evt->id, 
                $evt->lugar, 
                $request->funcion1, 
                $tema2->titulo, 
                $func2->fecha, 
                $func2->horario, 
                str_pad($reserva->id, 4 ,"0", STR_PAD_LEFT), 
                $reserva->usuario, 
                $reserva->telefono,
                $reserva->cant_adul,
                $reserva->importe,
                $func2->capacidad 
            ];

            array_push($values, $data2);
        }


        //return $values;
        $sheet = new GoogleSheet;

        $sheet->saveDataToSheet($values);

        
        //----------------------------------------------ENVIO WPP --------------------------------------------------
        $token = 'yb7lq7jpotu31kgq';
        $instanceId = '361534';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/message?token='.$token;
        $name = $reserva->usuario;
        $cel = "549". $reserva->telefono;
        
        $mens = "*Hola " . $reserva->usuario . "*\n";
        $mens .= "Esta confirmada tu reserva para el Planetario Móvil en *".  $evt->lugar ."* \n";
        $mens .= "CODIGO DE RESERVA: *" . str_pad($reserva->id, 4 ,"0", STR_PAD_LEFT) . "*\n";
        $mens .= "Cantidad de Entradas: *". $reserva->cant_adul . "*\n";
        $mens .= "----------------\n";
        if (!is_null($request->funcion2)) {
            $mens .= "Funciones: \n";
            $mens .= "* *" . $tema1->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($func1->fecha))). " a las " . strftime("%H:%M", strtotime($func1->horario)) . " hs.*\n";
            $mens .= "* *" . $tema2->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($func2->fecha))). " a las " . strftime("%H:%M", strtotime($func2->horario)) . " hs.*\n";
        }
        else
        {
            $mens .= "Funcion: \n";
            $mens .= "* *" . $tema1->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($func1->fecha))). " a las " . strftime("%H:%M", strtotime($func1->horario)) . " hs.*\n";
        }
        $mens .= "----------------\n";
        $mens .= "Importe Total: *$". $reserva->importe . "*\n";
        
        $data = [
            'phone' => $cel, // Receivers phone
            'body' => $mens, // Message
            ];
            $json = json_encode($data); // Encode data to JSON
            // URL for request POST /message

            // Make a POST request
            $options = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json
                ]
            ]);
        // Send a request
        //MANDA WPP - VER TRY-CATCH para Manejar excepcion
        
        $result = file_get_contents($url, false, $options); 

        //---------------------------------------------- FIN ENVIO WPP --------------------------------------------------


    }
}
