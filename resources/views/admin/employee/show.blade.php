@section('title', 'Employee Detail — Admin')

<x-layout.dashboard>
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm btn-circle">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Employee Detail</h1>
                    <p class="text-sm opacity-60">{{ $employee->user->name ?? 'Unknown User' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 justify-end">
                <a href="{{ route('employees.edit', $employee->user_id) }}" class="btn btn-primary btn-sm">
                    <span class="material-symbols-outlined text-base">edit</span>
                    Edit
                </a>
                <form action="{{ route('employees.destroy', $employee->user_id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <x-forms.button type="submit" variant="danger" size="sm" icon="delete" />
                </form>
            </div>
        </div>


        @if (session('success'))
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif


        <div class="card bg-base-100 border border-base-content/5">
            <div class="card-body">
                <div class="flex flex-col gap-6">

                    <div class="flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div
                                class="bg-primary text-primary-content w-16 rounded-full flex items-center justify-center">
                                <span class="text-xl">{{ strtoupper(substr($employee->user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ $employee->user->name ?? '—' }}</h2>
                            <p class="text-sm opacity-60">{{ $employee->user->email ?? '—' }}</p>
                            <div class="mt-2 sm:hidden">
                                @if ($employee->status === 'active')
                                    <span class="badge badge-success badge-lg gap-1">Active</span>
                                @else
                                    <span class="badge badge-error badge-lg gap-1">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-auto hidden sm:block">
                            @if ($employee->status === 'active')
                                <span class="badge badge-success badge-lg gap-1">Active</span>
                            @else
                                <span class="badge badge-error badge-lg gap-1">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="divider my-0"></div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">Phone Number</span>
                            <span>{{ $employee->phone_number ?? '—' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">Department</span>
                            <span>{{ $employee->department ?? '—' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">Joining Date</span>
                            <span>{{ $employee->joining_date?->format('d M Y') ?? '—' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold opacity-50">User ID</span>
                            <span class="font-mono text-xs">{{ $employee->user_id }}</span>
                        </div>
                    </div>

                    <div class="divider my-0"></div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm opacity-50">
                        <div>
                            <span class="font-semibold">Created:</span>
                            {{ $employee->created_at?->format('d M Y, H:i') ?? '—' }}
                        </div>
                        <div>
                            <span class="font-semibold">Updated:</span>
                            {{ $employee->updated_at?->format('d M Y, H:i') ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
