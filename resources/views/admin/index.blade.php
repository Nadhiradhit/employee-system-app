@section('title', 'Dashboard — Admin')
<x-layout.dashboard>
    <section class="flex flex-col lg:flex-row w-full gap-6">
        <div class="flex flex-col gap-6 flex-1 min-w-0">

            {{-- Weather Widget --}}
            <x-weather-widget />

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Employees</h1>
                    <p class="text-sm opacity-60">Manage all employee records</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Joining Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $index => $employee)
                            <tr class="hover">
                                <th>{{ $employees->firstItem() + $index }}</th>
                                <td class="font-semibold">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div
                                                class="bg-primary text-primary-content w-8 rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-xs">{{ strtoupper(substr($employee->user->name ?? '—', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <span class="font-semibold">{{ $employee->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>{{ $employee->user->email ?? '—' }}</td>
                                <td>{{ $employee->phone_number ?? '—' }}</td>
                                <td>{{ $employee->department ?? '—' }}</td>
                                <td>{{ $employee->joining_date?->format('d M Y') ?? '—' }}</td>
                                <td>
                                    @if ($employee->status === 'active')
                                        <span class="badge badge-success gap-1">Active</span>
                                    @else
                                        <span class="badge badge-error gap-1">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('employees.show', $employee->user_id) }}"
                                            class="btn btn-ghost btn-xs">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 opacity-50">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layout.dashboard>
