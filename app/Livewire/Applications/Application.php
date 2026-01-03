<?php

namespace App\Livewire\Applications;

use App\Models\Application as ApplicationModel;
use Livewire\Component;

class Application extends Component
{
    public ApplicationModel $application;

    public function mount(ApplicationModel $application)
    {
        $this->application = $application;
    }

    public function render()
    {
        return view('livewire.applications.application')
            ->layout('components.layouts.app');
    }
}
