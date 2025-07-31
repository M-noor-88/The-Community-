<?php

namespace App\Livewire\Map;

use Livewire\Component;

class MapDynamicComponent extends Component
{
    public array $locations = [];

    public function mount(array $locations = [])
    {
        $this->locations = $locations;
    }


    public function render()
    {
        return view('livewire.map.map-dynamic-component')->layout('layouts.app');
    }
}
