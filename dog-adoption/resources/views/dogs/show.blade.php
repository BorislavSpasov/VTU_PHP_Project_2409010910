<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $dog->name }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <img src="{{ $dog->image_url ? asset('storage/' . $dog->image_url) : asset('placeholder-dog.png') }}" class="w-full h-96 object-cover rounded mb-4">

        <div class="text-gray-700">
            <p><strong>Breed:</strong> {{ $dog->breed }}</p>
            <p><strong>Age:</strong> {{ $dog->age }} years</p>
            <p><strong>Gender:</strong> {{ ucfirst($dog->gender) }}</p>
            <p><strong>Description:</strong> {{ $dog->description ?? 'No description' }}</p>
        </div>

        <div class="mt-4 flex gap-4">
            <a href="{{ route('dogs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Dogs</a>

            @auth
                @if(!$dog->is_adopted && !$dog->adoptions->where('user_id', auth()->id())->count())
                    <!-- Open Adoption Modal Button -->
                    <button onclick="document.getElementById('adoption-modal').showModal()"
                            class="bg-green-600 text-white px-4 py-2 rounded">
                        Request Adoption
                    </button>
                @elseif($dog->adoptions->where('user_id', auth()->id())->count())
                    <span class="text-gray-700 mt-2">You have already requested adoption for this dog.</span>
                @endif
            @endauth
        </div>
    </div>

    <!-- Adoption Modal -->
    @auth
    @if(!$dog->is_adopted && !$dog->adoptions->where('user_id', auth()->id())->count())
        <dialog id="adoption-modal" class="rounded p-6 w-full max-w-lg">
            <form method="POST" action="{{ route('adoptions.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="dog_id" value="{{ $dog->id }}">

                <h3 class="text-xl font-semibold mb-2">Adoption Request for {{ $dog->name }}</h3>

                <div class="grid grid-cols-2 gap-4">
                    <input name="first_name" placeholder="First Name" class="border p-2 w-full" required>
                    <input name="last_name" placeholder="Last Name" class="border p-2 w-full" required>
                </div>

                <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
                <input name="phone" placeholder="Phone Number" class="border p-2 w-full" required>

                <textarea name="about" placeholder="Tell us about yourself"
                    class="border p-2 w-full" rows="3" required></textarea>

                <textarea name="reason" placeholder="Why do you want to adopt this dog?"
                    class="border p-2 w-full" rows="3" required></textarea>

                <div class="flex justify-end gap-2 mt-2">
                    <button type="button" onclick="this.closest('dialog').close()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </form>
        </dialog>
    @endif
    @endauth

    <!-- Error / Success Messages -->
    <div class="max-w-3xl mx-auto p-6">
        @if ($errors->any())
            <div class="bg-red-100 p-3 rounded mb-4 text-red-700">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 p-3 rounded mb-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-yellow-100 p-3 rounded mb-4 text-yellow-700">
                {{ session('error') }}
            </div>
        @endif
    </div>
</x-app-layout>
