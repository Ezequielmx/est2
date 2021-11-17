<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestPop extends Component
{
    public $open = false;
    public function render()
    {
        return view('livewire.test-pop');
    }
}
