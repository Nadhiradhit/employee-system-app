@section('title', 'Edit Employee — Admin')

<x-layout.dashboard>
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm btn-circle">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Employee</h1>
                <p class="text-sm opacity-60">{{ $employee->user->name ?? 'Unknown User' }}</p>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div role="alert" class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <div class="card bg-base-100 border border-base-content/5">
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->user_id) }}" method="POST"
                    class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')

                    {{-- Read-only user info --}}
                    <div class="flex flex-col gap-1">
                        <span class="label">Linked User</span>
                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content w-10 rounded-full">
                                    <span class="text-sm">{{ strtoupper(substr($employee->user->name ?? '?', 0, 1)) }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $employee->user->name ?? '—' }}</p>
                                <p class="text-sm opacity-60">{{ $employee->user->email ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <x-forms.input name="phone_number" label="Phone" placeholder="e.g. +62812345678" type="text"
                        required :value="old('phone_number', $employee->phone_number ?? '')" />

                    <x-forms.input name="department" label="Department" placeholder="e.g. Engineering" type="text"
                        required :value="old('department', $employee->department ?? '')" />

                    <x-forms.input name="joining_date" label="Joining Date" type="date" required
                        :value="old('joining_date', $employee->joining_date?->format('Y-m-d') ?? '')" />

                    <x-forms.select name="status" label="Status"
                        :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="old('status', $employee->status)" required />

                    <div class="flex justify-end gap-2 mt-4">
                        <a href="{{ route('employees.index') }}" class="btn">Cancel</a>
                        <x-forms.button type="submit" variant="primary" size="md">
                            Update Employee
                        </x-forms.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.dashboard>
