<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evento;


class ReservaEvento extends Component
{
    public $evento;
    public $open = false;
    public $entr_gral = 1;

    public $selectedFunc1 = null;
    public $selectedFunc2 = null;
    public $funciones1 = null;
    public $funciones2 = null;
    public $precio = 0;
    public $func_id;

    public function mount(Evento $evento, int $func_id = null){
        $this->evento = $evento;
        $this->func_id = $func_id;
        $this->selectedFunc1 = $func_id;
        $this->precio = $this->evento->precio;
        if (is_null($this->selectedFunc1)) {
            $this->selectedFunc1 = $this->evento->temas_func()->first()->func_id;
        }
        
    }


    public function render()
    {
        return view('livewire.reserva-evento', [
            'funciones' => $this->evento->temas_func()
        ]);
    }

    public function updatedselectedFunc1($func1_id)
    {
        $this->funciones2 = $this->evento->temas_func()->where('func_id','!=',$func1_id);
    }

    public function updatedselectedFunc2($func2_id)
    {
        if ($func2_id == null) {
            $this->precio = $this->evento->precio;
        }
        else{
            $this->precio = $this->evento->precio_prom*2;
        }
    }

    
}
