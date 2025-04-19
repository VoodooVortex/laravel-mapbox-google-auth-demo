<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;

class MapLocation extends Component
{
    public $mapStyle = 'mapbox://styles/mapbox/streets-v11';
    public $zoom = 12;
    public $center = [100.5018, 13.7563]; // Bangkok coordinates
    public $mapboxToken;
    public $customColors = 'default';
    public $showPoi = true;

    public function mount()
    {
        $this->mapboxToken = env('MAPBOX_ACCESS_TOKEN');
    }

    public function updateMapStyle($style)
    {
        $this->mapStyle = $style;
    }

    public function updateCustomColors($colorScheme)
    {
        $this->customColors = $colorScheme;
    }

    public function togglePoi()
    {
        $this->showPoi = !$this->showPoi;
    }

    public function render()
    {
        return view('livewire.map-location');
    }
}
