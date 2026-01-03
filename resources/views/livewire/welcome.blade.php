<div>
    <!-- HEADER -->
    <x-header title="Welcome to Cappy" separator progress-indicator>
       
    </x-header>

    <!-- TABLE  -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <x-card title="Latest Updates" shadow>
        This is where the 4 most recently edited applications will be displayed.
    </x-card>
    <x-card title="Latest CVEs" shadow>
        This will display the 4 more recent CVEs to meet their severity thresholds.
    </x-card>
    <x-card title="Upcoming Decisions" shadow>
        This will display the next 4 applications that are due for a decision.
    </x-card>
    <x-card title="Featured Application" shadow>
        This will display a randomly selected application with a screenshot and a short description.
    </x-card>
    <div class="col-span-2">
        @livewire('list-applications')
    </div>
</div>
   
    
</div>
