@section('title', 'Users — Admin')


<x-layout.dashboard>
    <section class="flex flex-col lg:flex-row w-full gap-6">
        <div class="w-full lg:w-80 lg:shrink-0 space-y-6">
            <div>
                <h1 class="text-2xl font-bold">Filter</h1>
                <p class="text-sm opacity-60">Filter by users records</p>
            </div>
            <form id="filter-form" method="GET" class="flex flex-col items-stretch gap-2">
                <x-forms.input type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Search Name or Email..." />

                <x-forms.select name="sort_by" icon="sort_by_alpha" onchange="this.form.submit()" :options="['name' => 'Sort by Name', 'created_at' => 'Sort by Date']"
                    :selected="request('sort_by', 'name')" />

                <x-forms.select name="per_page" icon="filter_list" :options="[5 => '5', 10 => '10', 25 => '25', 50 => '50']" :selected="request('per_page')"
                    placeholder="Filter by Per Page..." onchange="this.form.submit()" />

                <x-forms.button type="submit" variant="primary" size="full" icon="search">
                    Search
                </x-forms.button>
            </form>
        </div>

        <div class="flex flex-col gap-6 flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Users</h1>
                    <p class="text-sm opacity-60">Manage user accounts</p>
                </div>
                <div class="flex items-center gap-2">
                    <x-forms.select form="filter-form" onchange="this.form.submit()" name="sort" icon="swap_vert"
                        :iconOnly="true" tooltipPosition="tooltip-left" :options="['desc' => 'Descending', 'asc' => 'Ascending']" :selected="request('sort', 'desc')"
                        placeholder="Sort Order" />
                    <a href="{{ route('users.create') }}">
                        <x-forms.button type="button" variant="primary" size="md" icon="person_add">
                            Add User
                        </x-forms.button>
                    </a>
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
                            <th>Role</th>
                            <th>Employee</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr class="hover">
                                <th>{{ $users->firstItem() + $index }}</th>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div
                                                class="bg-primary text-primary-content w-8 rounded-full flex items-center justify-center">
                                                <span class="text-xs">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <span class="font-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->is_admin)
                                        <span class="badge badge-primary gap-1">Admin</span>
                                    @else
                                        <span class="badge badge-ghost gap-1">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->employee)
                                        <a href="{{ route('employees.show', $user->id) }}"
                                            class="link link-primary text-sm">Linked</a>
                                    @else
                                        <span class="text-sm opacity-40">Not linked</span>
                                    @endif
                                </td>
                                <td class="text-sm">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                                <td>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-ghost btn-xs">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-ghost btn-xs">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <x-forms.button variant="danger" size="xs" icon="delete"
                                                type="submit" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 opacity-50">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between gap-6 items-center">
                <x-navigation.paginator-summary :paginator="$users" />
                {{ $users->appends(request()->query())->onEachSide(3)->links() }}
            </div>
        </div>
    </section>
</x-layout.dashboard>
