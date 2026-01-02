<?php

namespace App\Livewire;

use Illuminate\Support\Collection;

use Livewire\Component;
use Mary\Traits\Toast;

class Welcome extends Component
{
    use Toast;

    public string $search = '';
    public bool $drawer = false;



    public function render()
    {
        return view('livewire.welcome');
    }
}
