<div>
  <x-header title="{{$category->name}}" separator />

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4"> 
  @foreach ($categoryList as $application)
    <x-card title="{{$application->name}}" shadow>
        {{$application->description}}
      <x-slot:actions separator>
        <x-button label="View" class="btn-primary" link="/applications/{{$application->id}}" />
    </x-slot:actions>
    </x-card>
  @endforeach
  </div>
</div>
