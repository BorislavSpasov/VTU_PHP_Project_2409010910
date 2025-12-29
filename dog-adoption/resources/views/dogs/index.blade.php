<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">🐶 Available Dogs for Adoption</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        @if($dogs->isEmpty())
            <div class="text-gray-600">No dogs available for adoption at the moment.</div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($dogs as $dog)
                    <div class="border rounded overflow-hidden shadow hover:shadow-lg transition">
                        <img src="{{ $dog->image_url ? asset('storage/' . $dog->image_url) : asset('placeholder-dog.png') }}" class="w-full h-48 object-cover">

                        <div class="p-4">
                            <h3 class="font-semibold text-lg">{{ $dog->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $dog->breed }} • {{ $dog->age }} years • {{ ucfirst($dog->gender) }}</p>
                            @if($dog->description)
                                <p class="mt-2 text-gray-700 text-sm">{{ $dog->description }}</p>
                            @endif
                        </div>

                        <div class="p-4">
                            <a href="{{ route('dogs.show', $dog) }}" class="bg-blue-500 text-white px-3 py-1 rounded">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
