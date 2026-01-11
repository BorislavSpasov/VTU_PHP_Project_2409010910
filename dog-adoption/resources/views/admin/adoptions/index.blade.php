<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">📝 Adoption Requests</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">

        @if(session('success'))
            <div class="flash-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flash-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" class="adoptions-actions mb-4">
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

            <button class="btn btn-view">
                Filter
            </button>
        </form>

        <table class="adoptions-table">
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Dog</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($adoptions as $adoption)
                    <tr>
                        <td>{{ $adoption->first_name }} {{ $adoption->last_name }}</td>
                        <td>{{ $adoption->dog->name }}</td>
                        <td>{{ ucfirst($adoption->status) }}</td>

                        <td class="adoptions-actions">
                            <button onclick="document.getElementById('modal-{{ $adoption->id }}').showModal()" class="btn btn-view">
                                View
                            </button>

                            @if($adoption->status === 'pending')
                                <form method="POST" action="{{ route('admin.adoptions.update', $adoption) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-approve">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('admin.adoptions.update', $adoption) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="btn btn-reject">Reject</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.adoptions.destroy', $adoption) }}" onsubmit="return confirm('Delete this request?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <dialog id="modal-{{ $adoption->id }}" class="adoption-modal">
                        <h3>{{ $adoption->first_name }} {{ $adoption->last_name }}</h3>
                        <p><strong>Email:</strong> {{ $adoption->email }}</p>
                        <p><strong>Phone:</strong> {{ $adoption->phone }}</p>
                        <hr>
                        <p><strong>About:</strong></p>
                        <p>{{ $adoption->about }}</p>
                        <p><strong>Why adopt:</strong></p>
                        <p>{{ $adoption->reason }}</p>
                        <div class="modal-footer">
                            <button onclick="this.closest('dialog').close()" class="btn btn-close">Close</button>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-600">No adoption requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
