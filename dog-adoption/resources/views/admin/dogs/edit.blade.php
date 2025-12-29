<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">✏️ Edit Dog</h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">

        <img src="{{ asset('storage/' . $dog->image_url) }}" class="w-full rounded mb-4">

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.dogs.update', $dog) }}">
            @csrf
            @method('PATCH')

            <label class="block mb-2 font-semibold">Name</label>
            <input type="text" name="name" value="{{ $dog->name }}" class="border p-2 w-full mb-4" required>

            <label class="block mb-2 font-semibold">Breed</label>
            <input type="text" name="breed" value="{{ $dog->breed }}" class="border p-2 w-full mb-4" required>

            <label class="block mb-2 font-semibold">Age</label>
            <input type="number" name="age" value="{{ $dog->age }}" class="border p-2 w-full mb-4" required>

            <label class="block mb-2 font-semibold">Gender</label>
            <select name="gender" class="border p-2 w-full mb-4" required>
                <option value="male" {{ $dog->gender === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $dog->gender === 'female' ? 'selected' : '' }}>Female</option>
            </select>

            <label class="block mb-2 font-semibold">Description</label>
            <textarea name="description" class="border p-2 w-full mb-4">{{ $dog->description }}</textarea>

            <label class="block mb-2 font-semibold">Replace Image (optional)</label>
            <input type="file" name="image" class="border p-2 w-full mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
