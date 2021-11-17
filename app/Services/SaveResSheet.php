<?php

namespace App\Services;
use App\Services\GoogleSheet;
use App\Models\Reserva;
use App\Models\Evento;
use App\Models\Funcione;
use App\Models\Tema;


class SaveResSheet{

    public $evento;
    public $reserva;
    public $selectedFunc1;
    public $selectedFunc2;
    public $func1;
    public $tema1;
    public $func2;
    public $tema2;

    public function __construct(Reserva $reserva, Evento $evento, int $selectedFunc1, int $selectedFunc2 = null)
    {   
        $this->reserva = $reserva;
        $this->evento = $evento;
        $this->selectedFunc1 = $selectedFunc1;
        $this->selectedFunc2 = $selectedFunc2;
    }

    public function save()
    {
        $this->func1 = Funcione::find($this->selectedFunc1);
        $this->tema1 = Tema::find($this->func1->tema_id);

        $values = [[
            $this->evento ->id, $this->evento ->lugar, 
            $this->selectedFunc1, 
            $this->tema1->titulo, 
            $this->func1->fecha, 
            $this->func1->horario, 
            str_pad($this->reserva->id, 4 ,"0", STR_PAD_LEFT), 
            $this->reserva->usuario, 
            $this->reserva->telefono,
            $this->reserva->cant_adul,
            $this->reserva->importe,
            $this->func1->capacidad 
        ]];

        if (!is_null($this->selectedFunc2)) {
            $this->func2 = Funcione::find($this->selectedFunc2);
            $this->tema2 = Tema::find($this->func2->tema_id);
            $data2 = [
                $this->evento ->id, 
                $this->evento ->lugar, 
                $this->selectedFunc2, 
                $this->tema2->titulo, 
                $this->func2->fecha, 
                $this->func2->horario, 
                str_pad($this->reserva->id, 4 ,"0", STR_PAD_LEFT), 
                $this->reserva->usuario, 
                $this->reserva->telefono,
                $this->reserva->cant_adul,
                $this->reserva->importe,
                $this->func2->capacidad 
            ];

            array_push($values, $data2);
        }


        //return $values;
        $sheet = new GoogleSheet;

        $sheet->saveDataToSheet($values);
    }

    public function wppConf()
    {
        $token = config( key:'chatapi.chat_api_token');
        $instanceId = config( key:'chatapi.chat_api_instance_id');

        $url = 'https://api.chat-api.com/instance'.$instanceId.'/message?token='.$token;
        $cel = "549". $this->reserva->telefono;
        
        $mens = "*Hola " . $this->reserva->usuario . "*\n";
        $mens .= "Esta confirmada tu reserva para el Planetario Móvil en *".  $this->evento->lugar ."* \n";
        $mens .= "CODIGO DE RESERVA: *" . str_pad($this->reserva->id, 4 ,"0", STR_PAD_LEFT) . "*\n";
        $mens .= "Cantidad de Entradas: *". $this->reserva->cant_adul . "*\n";
        $mens .= "----------------\n";
        if (!is_null($this->func2)) {
            $mens .= "Funciones: \n";
            $mens .= "* *" . $this->tema1->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($this->func1->fecha))). " a las " . strftime("%H:%M", strtotime($this->func1->horario)) . " hs.*\n";
            $mens .= "* *" . $this->tema2->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($this->func2->fecha))). " a las " . strftime("%H:%M", strtotime($this->func2->horario)) . " hs.*\n";
        }
        else
        {
            $mens .= "Funcion: \n";
            $mens .= "* *" . $this->tema1->titulo . " - " . utf8_encode(strftime("%A %d de %B", strtotime($this->func1->fecha))). " a las " . strftime("%H:%M", strtotime($this->func1->horario)) . " hs.*\n";
        }
        $mens .= "----------------\n";
        $mens .= "Importe Total: *$". $this->reserva->importe . "*\n";
        
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

    }

}