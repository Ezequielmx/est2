<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evento;

class ShowEvento extends Component
{

    public $evento;

    public function mount(Evento $evento){
        $this->evento = $evento;
    }

    public function render()
    {
        return view('livewire.show-evento');
    }
}
