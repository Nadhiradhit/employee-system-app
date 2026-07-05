@section('title', 'Login Employee')


<x-layout.auth>
    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-md px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-start">Login Employee</h1>

        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <x-forms.input label="Email" name="email" placeholder="Enter your email" type="email" required
                value="{{ old('email') }}" />
            <x-forms.input label="Password" name="password" placeholder="Enter your password" type="password" required
                value="{{ old('password') }}" />
            <x-forms.button type="submit" variant="primary" size="md">
                Login
            </x-forms.button>
        </form>
    </div>
</x-layout.auth>
