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
    public $usuario = null;
    public $tel = null;
    public $selectedFunc1 = null;
    public $selectedFunc2 = null;
    public $funciones1 = null;
    public $funciones2 = null;
    public $precio = 0;
    public $func_id;
    public $sobreventa;
    public $maxEntr;

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
        $this->sobreventa = Generale::First()->value('sobreventa');
        
        if (is_null($this->selectedFunc1)) {
            $this->selectedFunc1 = $this->evento->temas_func()->first()->func_id;
        }
        
    }

    public function updatedselectedFunc1($func1_id)
    {
        $this->funciones2 = $this->evento->temas_func()->where('func_id','!=',$func1_id);

        $func1 = $this->evento->temas_func()->where('func_id','=', $func1_id)->first();
        $disp_func1 = $func1->capacidad * (1 + $this->sobreventa/100)-($func1->cant_total);

        $this->maxEntr = min(7, $disp_func1);
        $this->entr_gral = min($this->entr_gral, $this->maxEntr);

        $this->selectedFunc2 = null;
        $this->precio = $this->evento->precio;

    }

    public function updatedselectedFunc2($func2_id)
    {
        if ($func2_id == null) {
            $this->precio = $this->evento->precio;
        }
        else{
            $func2 = $this->evento->temas_func()->where('func_id','=', $func2_id)->first();
            $disp_func2= $func2->capacidad * (1 + $this->sobreventa/100)-($func2->cant_total);
    
            $this->maxEntr = min($this->maxEntr, $disp_func2);
            $this->entr_gral = min($this->entr_gral, $this->maxEntr);
            $this->precio = $this->evento->precio_prom*2;

        }
    }


    public function save()
    {
        $this->validate();

        setlocale(LC_TIME, "spanish");
        
        $reserva = new Reserva();

        $reserva->codigo_res="123";
        $reserva->importe=$this->entr_gral * $this->precio;
        $reserva->usuario = $this->usuario;
        $reserva->telefono = $this->tel;
        $reserva->cant_adul = $this->entr_gral;
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

        

        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.reserva-evento', [
            'funciones' => $this->evento->temas_func()
        ]);
    }

    
}
