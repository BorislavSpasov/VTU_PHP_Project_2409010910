<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
        public function index()
    {
        $adoptions = Adoption::with('dog', 'user')->latest()->get();
        return view('admin.adoptions.index', compact('adoptions'));
    }

    public function update(Request $request, Adoption $adoption)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $adoption->status = $request->status;
        $adoption->save();

        if ($request->status === 'approved') {
            $dog = $adoption->dog;
            $dog->is_adopted = true;
            $dog->save();
        }

        return back()->with('success', 'Adoption status updated.');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
        ]);

        $dog = Dog::findOrFail($request->dog_id);

        // Prevent multiple requests by same user
        if (Adoption::where('user_id', Auth::id())->where('dog_id', $dog->id)->exists()) {
            return back()->with('error', 'You have already requested this dog.');
        }

        Adoption::create([
            'user_id' => Auth::id(),
            'dog_id' => $dog->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Adoption request submitted.');
    }
    
}
