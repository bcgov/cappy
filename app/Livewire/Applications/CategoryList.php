<?php

namespace App\Livewire\Applications;

use App\Models\Enums\ApplicationCategory;
use App\Models\Application;
use Livewire\Component;

class CategoryList extends Component
{
    public $category = ''; 
    public $categoryList = [];   
    
    public function mount($category)
        {
            $this->category = ApplicationCategory::from($category);
            $this->categoryList = Application::where('category', $category)->get();
        }
    public function render()
    {
       
        return view('livewire.applications.category-list')
            ->layout('components.layouts.app');
    }
}
