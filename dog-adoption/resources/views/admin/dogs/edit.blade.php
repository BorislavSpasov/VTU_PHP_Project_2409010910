<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">✏️ Edit Dog</h2>
    </x-slot>

    <div class="edit-container">
        <img src="{{ asset('storage/' . $dog->image_url) }}" class="dog-image">

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.dogs.update', $dog) }}">
            @csrf
            @method('PATCH')

            <label>Name</label>
            <input type="text" name="name" value="{{ $dog->name }}" class="input-text" required>

            <label>Breed</label>
            <input type="text" name="breed" value="{{ $dog->breed }}" class="input-text" required>

            <label>Age</label>
            <input type="number" name="age" value="{{ $dog->age }}" class="input-number" required>

            <label>Gender</label>
            <select name="gender" class="input-select" required>
                <option value="male" {{ $dog->gender === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $dog->gender === 'female' ? 'selected' : '' }}>Female</option>
            </select>

            <label>Description</label>
            <textarea name="description" class="input-textarea">{{ $dog->description }}</textarea>

            <label>Replace Image (optional)</label>
            <input type="file" name="image" class="input-file">

            <button class="button-save">Save</button>
        </form>
    </div>
</x-app-layout>
