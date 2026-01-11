<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">🐶 Available Dogs for Adoption</h2>
    </x-slot>

    <div class="container-max">
        @if($dogs->isEmpty())
            <div class="text-gray-600">No dogs available for adoption at the moment.</div>
        @else
            <div class="dogs-grid">
                @foreach($dogs as $dog)
                    <div class="dog-card">
                        <img src="{{ $dog->image_url ? asset('storage/' . $dog->image_url) : asset('placeholder-dog.png') }}" alt="{{ $dog->name }}">
                        <div class="dog-info">
                            <h3>{{ $dog->name }}</h3>
                            <p>{{ $dog->breed }} • {{ $dog->age }} years • {{ ucfirst($dog->gender) }}</p>
                            @if($dog->description)
                                <p>{{ $dog->description }}</p>
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ route('dogs.show', $dog) }}" class="btn btn-blue">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
</x-app-layout>
