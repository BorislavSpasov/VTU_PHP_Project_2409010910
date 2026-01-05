<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">📝 Adoption Requests</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <input
                type="text"
                name="search"
                placeholder="Search applicant or dog..."
                value="{{ request('search') }}"
                class="border rounded px-3 py-2 w-64"
            >

            <select name="status" class="border rounded px-3 py-2">
                <option value="">All Statuses</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
            </select>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Filter
            </button>
        </form>

        {{-- Table --}}
        <table class="w-full table-auto border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Applicant</th>
                    <th class="border px-4 py-2">Dog</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($adoptions as $adoption)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $adoption->first_name }} {{ $adoption->last_name }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $adoption->dog->name }}
                        </td>

                        <td class="border px-4 py-2 font-semibold">
                            {{ ucfirst($adoption->status) }}
                        </td>

                        <td class="border px-4 py-2 flex gap-2">
                            {{-- View Modal --}}
                            <button
                                onclick="document.getElementById('modal-{{ $adoption->id }}').showModal()"
                                class="bg-blue-500 text-white px-2 py-1 rounded"
                            >
                                View
                            </button>

                            {{-- Approve / Reject --}}
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
                            @endif

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.adoptions.destroy', $adoption) }}"
                                  onsubmit="return confirm('Delete this request?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-gray-700 text-white px-2 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal --}}
                    <dialog id="modal-{{ $adoption->id }}" class="rounded p-6 w-96">
                        <h3 class="font-bold text-lg mb-2">
                            {{ $adoption->first_name }} {{ $adoption->last_name }}
                        </h3>

                        <p><strong>Email:</strong> {{ $adoption->email }}</p>
                        <p><strong>Phone:</strong> {{ $adoption->phone }}</p>

                        <hr class="my-3">

                        <p><strong>About:</strong></p>
                        <p class="text-sm mb-2">{{ $adoption->about }}</p>

                        <p><strong>Why adopt:</strong></p>
                        <p class="text-sm">{{ $adoption->reason }}</p>

                        <div class="mt-4 text-right">
                            <button
                                onclick="this.closest('dialog').close()"
                                class="bg-gray-500 text-white px-3 py-1 rounded"
                            >
                                Close
                            </button>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-600">
                            No adoption requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
