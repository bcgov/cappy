<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function show($id)
    {
        $data['application'] = Application::findOrFail($id);

        return view('livewire.applications.application', $data);
    }

    public function category($category) {
        $data['applications'] = Application::where('category', $category)->get();

        
    }
}
