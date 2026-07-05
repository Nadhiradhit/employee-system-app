@section('title', 'User Detail — Admin')

<x-layout.dashboard>
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        <div class="flex flex-col sm:flex-row gap-2 sm:items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('users.index') }}" class="btn btn-ghost btn-sm btn-circle">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">User Detail</h1>
                    <p class="text-sm opacity-60">{{ $user->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 justify-end">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                    <span class="material-symbols-outlined text-base">edit</span>
                    Edit
                </a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <x-forms.button type="submit" variant="danger" size="sm" icon="delete" />
                </form>
            </div>
        </div>

        <div class="card bg-base-100 border border-base-content/5">
            <div class="card-body">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div
                                class="bg-primary text-primary-content w-16 rounded-full flex items-center justify-center">
                                <span class="text-xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                            <p class="text-sm opacity-60">{{ $user->email }}</p>
                        </div>
                        <div class="ml-auto">
                            @if ($user->is_admin)
                                <span class="badge badge-primary badge-lg gap-1">Admin</span>
                            @else
                                <span class="badge badge-ghost badge-lg gap-1">User</span>
                            @endif
                        </div>
                    </div>

                    <div class="divider my-0"></div>

                    {{-- Employee Link --}}
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-semibold opacity-50">Employee Record</span>
                        @if ($user->employee)
                            <a href="{{ route('employees.show', $user->id) }}" class="link link-primary">
                                {{ $user->employee->department ?? 'View employee record' }} —
                                {{ $user->employee->status === 'active' ? '✓ Active' : '✗ Inactive' }}
                            </a>
                        @else
                            <div class="flex items-center gap-3">
                                <span class="opacity-40">No employee record linked</span>
                                <a href="{{ route('employees.create') }}" class="btn btn-primary btn-xs">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                    Create Employee
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="divider my-0"></div>

                    {{-- Details --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">User ID</span>
                            <span class="font-mono text-xs">{{ $user->id }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">Email Verified</span>
                            <span>{{ $user->email_verified_at?->format('d M Y, H:i') ?? 'Not verified' }}</span>
                        </div>
                    </div>

                    <div class="divider my-0"></div>

                    {{-- Timestamps --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm opacity-50">
                        <div>
                            <span class="font-semibold">Created:</span>
                            {{ $user->created_at?->format('d M Y, H:i') ?? '—' }}
                        </div>
                        <div>
                            <span class="font-semibold">Updated:</span>
                            {{ $user->updated_at?->format('d M Y, H:i') ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
