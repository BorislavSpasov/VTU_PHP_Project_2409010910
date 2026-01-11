<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function index(Request $request)
    {
        $adoptions = Adoption::with('dog', 'user')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhereHas('dog', function ($dogQuery) use ($request) {
                        $dogQuery->where('name', 'like', "%{$request->search}%");
                    });
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();

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
        $validated = $request->validate([
            'dog_id'     => 'required|exists:dogs,id',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:20',
            'about'      => 'required|string|min:20',
            'reason'     => 'required|string|min:20',
        ]);

        if (Adoption::where('user_id', Auth::id())
                    ->where('dog_id', $validated['dog_id'])
                    ->exists()) {
            return back()->with('error', 'You have already requested this dog.');
        }

        Adoption::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Adoption request submitted.');
    }

    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

        return back()->with('success', 'Adoption request removed.');
    }

    
}
