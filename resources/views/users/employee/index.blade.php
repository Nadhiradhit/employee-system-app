@section('title', 'Employees — Users')

<x-layout.dashboard>
    <section class="flex flex-col lg:flex-row w-full gap-6">
        <div class="w-full lg:w-80 lg:shrink-0 space-y-6">
            <div>
                <h1 class="text-2xl font-bold">Filter</h1>
                <p class="text-sm opacity-60">Filter by employee records</p>
            </div>
            <form id="filter-form" method="GET" class="flex flex-col items-stretch gap-2">
                <x-forms.input type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Search Email or ID..." />

                <x-forms.input type="text" name="department" value="{{ request('department') }}"
                    placeholder="Filter by Department..." />

                <x-forms.select name="sort_by" icon="sort_by_alpha" onchange="this.form.submit()" :options="['name' => 'Sort by Name', 'joining_date' => 'Sort by Date']"
                    :selected="request('sort_by', 'name')" />

                <x-forms.select name="status" icon="filter_list" :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="request('status')"
                    placeholder="All Statuses" onchange="this.form.submit()" />

                <x-forms.button type="submit" variant="primary" size="full" icon="search">
                    Search
                </x-forms.button>
            </form>
        </div>
        <div class="flex flex-col gap-6 flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Employees</h1>
                    <p class="text-sm opacity-60">Manage all employee records</p>
                </div>
                <div>
                    <x-forms.select form="filter-form" onchange="this.form.submit()" name="sort" icon="swap_vert"
                        tooltipPosition="tooltip-left" :options="['desc' => 'Descending', 'asc' => 'Ascending']" :selected="request('sort', 'desc')" placeholder="Sort Order" />
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

            @if (session('error'))
                <div role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

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

            <div class="flex justify-between gap-6 items-center">
                <x-navigation.paginator-summary :paginator="$employees" />
                {{ $employees->appends(request()->query())->onEachSide(3)->links() }}
            </div>
        </div>
    </section>
</x-layout.dashboard>
