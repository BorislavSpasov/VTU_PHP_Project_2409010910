<?php

namespace App\Http\Controllers;

use App\Models\Dog;

class DogController extends Controller
{
    // Display all dogs
    public function index()
    {
        $dogs = Dog::where('is_adopted', false)->latest()->get();
        return view('dogs.index', compact('dogs'));
    }

    // show individual dog details
    public function show(Dog $dog)
    {
        return view('dogs.show', compact('dog'));
    }
}
