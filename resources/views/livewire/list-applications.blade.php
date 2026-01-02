<?php
 
use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
 
new class extends Component {

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function headers() {
        return [
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'description', 'label' => 'Description', 'sortable' => false],
            ['key' => 'category', 'label' => 'Category', 'sortable' => true],
            ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
        ];
    }

    public function applications(): Collection
    {
        return Application::all();
    }
} 
?>

<x-table :headers="$this->headers()" :rows="$this->applications()" :sort-by="$this->sortBy" striped />
