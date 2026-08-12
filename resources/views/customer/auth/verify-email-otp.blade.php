<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md rounded-2xl bg-white shadow-xl p-8">

        <div class="text-center">

            <h1 class="text-2xl font-bold text-gray-900">
                Enter Verification Code
            </h1>

            <p class="mt-3 text-gray-500">
                Please enter the 6-digit code sent to
            </p>

            <p class="font-semibold text-gray-800">
                {{ auth()->user()->email }}
            </p>

        </div>

        <form
            action="{{ route('verification.verify') }}"
            method="POST"
            class="mt-8 space-y-5">

            @csrf

            <div>

                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    placeholder="123456"
                    class="w-full rounded-xl border border-gray-300 py-4 text-center text-3xl tracking-[0.5em] focus:border-orange-500 focus:ring-orange-500">

                @error('otp')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <button
                class="w-full rounded-xl bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600 transition">

                Verify Email

            </button>

        </form>

        <form
            method="POST"
            action="{{ route('verification.resend') }}"
            class="mt-4">

            @csrf

            <button
                class="w-full rounded-xl border border-gray-300 py-3 hover:bg-gray-100 transition">

                Resend Code

            </button>

        </form>

        <a
            href="/verify-email"
            class="mt-5 block text-center text-sm text-gray-500 hover:text-orange-500">

            ← Back

        </a>

    </div>

</div>
