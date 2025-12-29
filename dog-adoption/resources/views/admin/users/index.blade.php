<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            👥 User Management
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Role</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="text-center">
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </td>
                        <td class="border p-2">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1 rounded text-white
                                        {{ $user->is_admin ? 'bg-red-500' : 'bg-green-500' }}">
                                        {{ $user->is_admin ? 'Demote' : 'Promote' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">You</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
