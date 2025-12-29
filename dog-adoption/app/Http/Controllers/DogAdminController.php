<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DogAdminController extends Controller
{
    public function index()
    {
        $dogs = Dog::latest()->get();
        return view('admin.dogs.index', compact('dogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048', // 2MB max
        ]);

        $path = $request->file('image')->store('dogs', 'public');

        Dog::create([
            'name' => $request->name,
            'breed' => $request->breed,
            'age' => $request->age,
            'gender' => $request->gender,
            'description' => $request->description,
            'image_url' => $path,
            'is_adopted' => false,
        ]);

        return back()->with('success', 'Dog added successfully.');
    }

    public function edit(Dog $dog)
    {
        return view('admin.dogs.edit', compact('dog'));
    }

    public function update(Request $request, Dog $dog)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $dog->fill($request->only(['name', 'breed', 'age', 'gender', 'description']));

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($dog->image_url);
            $dog->image_url = $request->file('image')->store('dogs', 'public');
        }

        $dog->save();

        return redirect()->route('admin.dogs.index')->with('success', 'Dog updated successfully.');
    }

    public function destroy(Dog $dog)
    {
        Storage::disk('public')->delete($dog->image_url);
        $dog->delete();

        return back()->with('success', 'Dog deleted successfully.');
    }
}
