<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">{{ $dog->name }}</h2>
    </x-slot>

    <div class="dog-show-container">
        <img src="{{ $dog->image_url ? asset('storage/' . $dog->image_url) : asset('placeholder-dog.png') }}" class="dog-show-image" alt="{{ $dog->name }}">

        <div class="dog-show-info">
            <p><strong>Breed:</strong> {{ $dog->breed }}</p>
            <p><strong>Age:</strong> {{ $dog->age }} years</p>
            <p><strong>Gender:</strong> {{ ucfirst($dog->gender) }}</p>
            <p><strong>Description:</strong> {{ $dog->description ?? 'No description' }}</p>
        </div>

        <div class="dog-show-buttons">
            <a href="{{ route('dogs.index') }}" class="btn btn-gray">Back to Dogs</a>

            @auth
                @if(!$dog->is_adopted && !$dog->adoptions->where('user_id', auth()->id())->count())
                    <button onclick="document.getElementById('adoption-modal').showModal()" class="btn btn-green">
                        Request Adoption
                    </button>
                @elseif($dog->adoptions->where('user_id', auth()->id())->count())
                    <span class="text-gray-700 mt-2">You have already requested adoption for this dog.</span>
                @endif
            @endauth
        </div>
    </div>

    @auth
    @if(!$dog->is_adopted && !$dog->adoptions->where('user_id', auth()->id())->count())
        <dialog id="adoption-modal" class="adoption-modal">
            <form method="POST" action="{{ route('adoptions.store') }}" class="adoption-form">
                @csrf
                <input type="hidden" name="dog_id" value="{{ $dog->id }}">

                <h3 class="adoption-title">Adoption Request for {{ $dog->name }}</h3>

                <div class="adoption-grid">
                    <input name="first_name" placeholder="First Name" required>
                    <input name="last_name" placeholder="Last Name" required>
                </div>

                <input type="email" name="email" placeholder="Email" required>
                <input name="phone" placeholder="Phone Number" required>

                <textarea name="about" placeholder="Tell us about yourself" rows="3" required></textarea>
                <textarea name="reason" placeholder="Why do you want to adopt this dog?" rows="3" required></textarea>

                <div class="dialog-buttons">
                    <button type="button" class="btn btn-gray" onclick="this.closest('dialog').close()">Cancel</button>
                    <button type="submit" class="btn btn-green">Submit</button>
                </div>
            </form>
        </dialog>
    @endif
    @endauth

    <div class="dog-show-messages">
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
