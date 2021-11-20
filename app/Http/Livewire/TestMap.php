<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestMap extends Component
{
    public $direccion;
    
    public function render()
    {
        return view('livewire.test-map');
    }
}
