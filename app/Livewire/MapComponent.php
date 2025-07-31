<?php

namespace App\Livewire;

use Livewire\Component;

class MapComponent extends Component
{
    public array $locations = [];

    public function mount()
    {
        $this->locations = [
            [
                'lat' => 33.5138,
                'lng' => 36.2765,
                'name' => 'Center A',
                'description' => 'Main HQ',
            ],
            [
                'lat' => 33.5145,
                'lng' => 36.2800,
                'name' => 'Center B',
                'description' => 'Branch Office',
            ],
            [
                'lat' => 33.5190,
                'lng' => 36.2800,
                'name' => 'Center B',
                'description' => 'Branch Office',
            ],
            [
                'lat' => 33.5115,
                'lng' => 36.2800,
                'name' => 'Center B',
                'description' => 'Branch Office',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.map-component')->layout('layouts.app');
    }
}
