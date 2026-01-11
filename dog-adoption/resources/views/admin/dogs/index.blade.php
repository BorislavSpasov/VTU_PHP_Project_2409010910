<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">🐾 Admin – Dog Manager</h2>
    </x-slot>

    <div class="admin-container">
        @if(session('success'))
            <div class="message-success">{{ session('success') }}</div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.dogs.store') }}" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-3">
            @csrf
            <input type="text" name="name" placeholder="Name" class="input-text md:col-span-2" required>
            <input type="text" name="breed" placeholder="Breed" class="input-text md:col-span-2" required>
            <input type="number" name="age" placeholder="Age" class="input-number md:col-span-1" required>
            <select name="gender" class="input-select md:col-span-1" required>
                <option value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <input type="file" name="image" class="input-file md:col-span-3" required>
            <textarea name="description" placeholder="Description (optional)" class="input-textarea md:col-span-6" rows="3"></textarea>
            <div class="md:col-span-6">
                <button class="button-add">Add Dog</button>
            </div>
        </form>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            @foreach($dogs as $dog)
                <div class="dog-card">
                    <img src="{{ asset('storage/' . $dog->image_url) }}" class="dog-image">
                    <div class="p-2">
                        <div class="dog-name">{{ $dog->name }} ({{ $dog->breed }})</div>
                        <div class="dog-details">{{ $dog->age }} years • {{ ucfirst($dog->gender) }}</div>
                        <div class="dog-description">{{ $dog->description }}</div>
                    </div>
                    <div class="dog-actions">
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
