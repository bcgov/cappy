<div>
    <x-header title="{{ $application->name }}" separator />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4"> 
        
        <x-card title="Description" shadow separator>
            {{ $application->description }}
        </x-card>
        <x-card title="Usage" shadow separator>
            <div class="grid md:grid-cols-2 gap-4">
            <x-stat
                title="Daily Users"
                value="44"
                icon="o-users"
                tooltip="Estimated daily users"
                color="text-primary" />
            </div>
        </x-card>
        <x-card title="Support" shadow separator>

        </x-card>
        <x-card title="Financials" shadow separator>
            <div class="grid md:grid-cols-2 gap-4">
            <x-stat
                title="Total Coast"
                value="$1,342,764"
                icon="o-banknotes"
                tooltip="Estimated Total Cost of Ownership (TCO)"
                color="text-primary" />
            </div>
        </x-card>
        <x-card title="Architecture" shadow separator>
            
        </x-card>
        <x-card title="Lifecycle" shadow separator>
            
        </x-card>
    </div>
</div>
