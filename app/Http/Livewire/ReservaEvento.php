<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evento;
use App\Models\Reserva;
use App\Services\SaveResSheet;
use App\Models\Generale;

class ReservaEvento extends Component
{
    public $evento;

    public $open = false;
    public $entr_gral = 1;
    public $entr_seg = 0;
    public $usuario = null;
    public $tel = null;
    public $selectedFunc1 = null;
    public $selectedFunc2 = null;
    public $temaFunc1 = null;
    public $funciones1 = null;
    public $precio = 0;
    public $precio_seg = 0;
    public $func_id;
    public $sobreventa;
    public $maxEntr;
    public $cant_funciones=1;

    protected $rules = [
        'usuario' => 'required|min:3',
        'tel' => 'required|digits:10'
    ];

    public function mount(Evento $evento, int $func_id = null){
        $this->maxEntr = 10;
        $this->evento = $evento;
        $this->func_id = $func_id;
        $this->selectedFunc1 = $func_id;
        $this->precio = $this->evento->precio;
        $this->precio_seg = $this->evento->precio_seg;
        $this->sobreventa = Generale::First()->value('sobreventa');
        
        if (is_null($this->selectedFunc1)) {
            $funciones = $this->evento->temas_func();
            foreach( $funciones as $funcion)
            {
                if ($funcion->capacidad * (1 + $this->sobreventa/100)-($funcion->cant_total) > 0)
                {
                    $this->selectedFunc1 = $funcion->func_id;
                    break;
                }
            } 
        }
        

        $func1 = $this->evento->temas_func()->where('func_id','=', $this->selectedFunc1)->first();
        $this->temaFunc1 = $func1->id;
        $disp_func1 = $func1->capacidad * (1 + $this->sobreventa/100)-($func1->cant_total);

        $this->maxEntr = max(0 , min(10, $disp_func1));
        
    }

    public function updatedselectedFunc1($func1_id)
    {
        $func1 = $this->evento->temas_func()->where('func_id','=', $func1_id)->first();
        $this->temaFunc1 = $func1->id;
        $disp_func1 = $func1->capacidad * (1 + $this->sobreventa/100)-($func1->cant_total);

        $this->maxEntr = max(0 , min(10, $disp_func1));
        $this->entr_gral = max(0 , min($this->entr_gral, $this->maxEntr));

        $this->selectedFunc2 = null;
        $this->precio = $this->evento->precio;
        $this->cant_funciones=1;

    }

    public function updatedselectedFunc2($func2_id)
    {
        if ($func2_id == null) {
            $this->precio = $this->evento->precio;
            $this->cant_funciones=1;
        }
        else{
            $func2 = $this->evento->temas_func()->where('func_id','=', $func2_id)->first();
            $disp_func2= $func2->capacidad * (1 + $this->sobreventa/100)-($func2->cant_total);
    
            $this->maxEntr = max(0 ,min($this->maxEntr, $disp_func2));
            $this->entr_gral = max(0 ,min($this->entr_gral, $this->maxEntr));
            $this->precio = $this->evento->precio_prom;
            $this->cant_funciones=2;
        }
    }

    public function updated()
    {
        if ( ($this->entr_gral + $this->entr_seg) > $this->maxEntr) {
            $this->entr_seg = max(0 ,$this->maxEntr - $this->entr_gral);
        }
    }


    public function save()
    {
        $this->validate();

        setlocale(LC_TIME, "spanish");
        
        $reserva = new Reserva();

        $reserva->codigo_res="123";
        $reserva->importe=$this->entr_gral * $this->precio * $this->cant_funciones + $this->entr_seg * $this->precio_seg * $this->cant_funciones;
        $reserva->usuario = $this->usuario;
        $reserva->telefono = $this->tel;
        $reserva->cant_adul = $this->entr_gral;
        $reserva->cant_esp = $this->entr_seg;
        $reserva->wppconf = '0';
        $reserva->wpprecord = '0';

        $reserva->save();
        $reserva->codigo_res=str_pad($reserva->id, 4 ,"0", STR_PAD_LEFT);
        $reserva->save();

        $reserva->funciones()->attach($this->selectedFunc1);

        if (!is_null($this->selectedFunc2)) {
            $reserva->funciones()->attach($this->selectedFunc2);
        }

        $mensaje = 'Tu reseva ya está registrada.<br> Código de reserva: <b>' . str_pad($reserva->id, 4 ,"0", STR_PAD_LEFT) . 
        '</b><br>Recibirás todos los detalles por WhatsApp. <br> <b>Te esperamos!</b>'; 

        $this->emit('alert', $mensaje);

        $this->reset(['open', 'usuario', 'tel', 'maxEntr']);


        $resSheet = new SaveResSheet($reserva, $this->evento, $this->selectedFunc1, $this->selectedFunc2);
       
        
        $resSheet->save();

        $resSheet->wppConf();

        

        
    }

    public function render()
    {
        return view('livewire.reserva-evento', [
            'funciones' => $this->evento->temas_func(),
            'temaFunc1'=> $this->temaFunc1
        ]);
    }

    
}
