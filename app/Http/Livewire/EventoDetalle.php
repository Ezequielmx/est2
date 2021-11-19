<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evento;
use App\Models\Generale;

class EventoDetalle extends Component
{

    public function mount(Evento $evento){
        $this->sobreventa = Generale::First()->value('sobreventa');
        $this->evento = $evento;
    }

    public function render()
    {
        return view('livewire.evento-detalle');
    }
}
