
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md rounded-2xl bg-white shadow-xl p-8">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">
                Reset Password
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Create a new password for your account.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    required
                    readonly
                    class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    New Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500">

                @error('password')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500">
            </div>

            <button
                class="w-full rounded-xl bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600 transition">
                Reset Password
            </button>

        </form>

    </div>

</div>
