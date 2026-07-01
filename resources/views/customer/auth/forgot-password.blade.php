
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md rounded-2xl bg-white shadow-xl p-8">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">
                Forgot Password
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Enter your email address and we'll send you a password reset link.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500">

                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                class="w-full rounded-xl bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600 transition">
                Send Reset Link
            </button>

            <div class="text-center">
                <a href="{{ route('auth') }}"
                   class="text-sm text-gray-500 hover:text-orange-500">
                    Back to Login
                </a>
            </div>

        </form>

    </div>

</div>
