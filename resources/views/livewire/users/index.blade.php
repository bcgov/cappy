<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;


new class extends Component {


    public string $search = '';


}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Welcome to Cappy" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card title="Latest Updates" shadow>
        This is where the 4 most recently edited applications will be displayed.
    </x-card>
    <x-card title="Latest CVEs" shadow>
        This will display the 4 more recent CVEs to meet their severity thresholds.
    </x-card>
    <x-card title="Upcoming Decisions" shadow>
        This will display the next 4 applications that are due for a decision.
    </x-card>
    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
