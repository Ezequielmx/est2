<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestMap extends Component
{
    public $ubicacion;
    
    public function render()
    {
        return view('livewire.test-map');
    }
}
