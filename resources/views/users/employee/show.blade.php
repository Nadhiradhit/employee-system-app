@section('title', 'Employee Detail')

<x-layout.dashboard>
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">

        <div class="flex items-center gap-4">
            <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm btn-circle">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Employee Detail</h1>
                <p class="text-sm opacity-60">{{ $employee->user->name ?? 'Unknown User' }}</p>
            </div>
        </div>


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
                        </div>
                        <div class="ml-auto">
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
