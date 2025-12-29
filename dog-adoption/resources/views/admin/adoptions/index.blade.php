<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">📝 Adoption Requests</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">User</th>
                    <th class="border px-4 py-2">Dog</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($adoptions as $adoption)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $adoption->user->name }}</td>
                        <td class="border px-4 py-2">{{ $adoption->dog->name }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($adoption->status) }}</td>
                        <td class="border px-4 py-2 flex justify-center gap-2">
                            @if($adoption->status === 'pending')
                                <form method="POST" action="{{ route('admin.adoptions.update', $adoption) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.adoptions.update', $adoption) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="bg-red-500 text-white px-2 py-1 rounded">Reject</button>
                                </form>
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
