@section('title', 'Login Employee')

@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<x-layout.auth>
    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-md px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-start">Login Employee</h1>
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
