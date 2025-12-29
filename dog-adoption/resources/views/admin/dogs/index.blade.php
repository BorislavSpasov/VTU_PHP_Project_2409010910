<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">🐾 Admin – Dog Manager</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.dogs.store') }}" class="mb-6">
            @csrf
            <div class="flex flex-col md:flex-row gap-2">
                <input type="text" name="name" placeholder="Name" class="border p-2 flex-1" required>
                <input type="text" name="breed" placeholder="Breed" class="border p-2 flex-1" required>
                <input type="number" name="age" placeholder="Age" class="border p-2 w-24" required>
                <select name="gender" class="border p-2 w-32" required>
                    <option value="">Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <input type="file" name="image" class="border p-2" required>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Add Dog</button>
            </div>
        </form>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            @foreach($dogs as $dog)
                <div class="relative border rounded overflow-hidden">
                    <img src="{{ asset('storage/' . $dog->image_url) }}" class="w-full h-40 object-cover">
                    <div class="p-2">
                        <div class="font-semibold">{{ $dog->name }} ({{ $dog->breed }})</div>
                        <div class="text-sm text-gray-600">{{ $dog->age }} years • {{ ucfirst($dog->gender) }}</div>
                        <div class="text-xs text-gray-500">{{ $dog->description }}</div>
                    </div>
                    <div class="flex justify-between p-2">
                        <a href="{{ route('admin.dogs.edit', $dog) }}" class="text-blue-600">Edit</a>
                        <form method="POST" action="{{ route('admin.dogs.destroy', $dog) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
