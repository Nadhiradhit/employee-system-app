@section('title', 'Create User — Admin')

<x-layout.dashboard>
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" class="btn btn-ghost btn-sm btn-circle">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Create User</h1>
                <p class="text-sm opacity-60">Create a new user account</p>
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
                <form action="{{ route('users.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <x-forms.input name="name" label="Name" placeholder="Enter full name" type="text" required
                        :value="old('name', '')" />

                    <x-forms.input name="email" label="Email" placeholder="Enter email address" type="email" required
                        :value="old('email', '')" />

                    <x-forms.input name="password" label="Password" placeholder="Min 8 chars, A-z, 0-9, special"
                        type="password" required />

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="is_admin" value="1"
                                {{ old('is_admin') ? 'checked' : '' }} class="checkbox checkbox-primary" />
                            <span class="label-text">Grant admin privileges</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <a href="{{ route('users.index') }}" class="btn">Cancel</a>
                        <x-forms.button type="submit" variant="primary" size="md">
                            Create User
                        </x-forms.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.dashboard>
