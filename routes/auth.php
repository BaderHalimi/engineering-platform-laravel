<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\EmailVerificationCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailOtpMail;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/auth', function () {
    return view('customer.auth.auth');
})->name('auth');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    /*
    |--------------------------------------------------------------------------
    | هنا:
    | - أنشئ OTP
    | - خزنه في قاعدة البيانات
    | - أرسله إلى البريد
    |--------------------------------------------------------------------------
    */

    auth()->login($user);

    $request->session()->regenerate();

    return redirect()->route('verification.notice');
})->name('register');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! auth()->attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors([
                'email' => __('auth.failed'),
            ])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    if (auth()->user()->email_verified_at === null) {
        return redirect()->route('verification.notice');
    }

    return redirect()->intended(route('dashboard'));
})->name('login');

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get('/verify-email', function () {

    if (auth()->user()->email_verified_at) {
        return redirect()->route('dashboard');
    }

    return view('customer.auth.verify-email');
})->middleware('auth')->name('verification.notice');


/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', function () {
    return view('customer.auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors([
            'email' => __($status),
        ]);
})->middleware('guest')->name('password.email');

/*
|--------------------------------------------------------------------------
| Reset Password
|--------------------------------------------------------------------------
*/

Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('customer.auth.reset-password', [
        'token' => $token,
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset(
        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('auth')->with('status', __($status))
        : back()->withErrors([
            'email' => __($status),
        ]);
})->middleware('guest')->name('password.update');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::get('/logout', function (Request $request) {

    auth()->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('auth');
})->middleware('auth');





Route::post('/verify-email', function (Request $request) {

    $request->validate([
        'otp' => ['required', 'digits:6'],
    ]);

    $record = EmailVerificationCode::where(
        'user_id',
        auth()->id()
    )->first();

    if (!$record) {
        return response()->json([
            'success' => false,
            'message' => 'Verification code not found.'
        ], 404);
    }

    if ($record->expires_at->isPast()) {
        return response()->json([
            'success' => false,
            'message' => 'Verification code has expired.'
        ], 422);
    }

    if (!Hash::check($request->otp, $record->otp)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.'
        ], 422);
    }

    auth()->user()->update([
        'email_verified_at' => now(),
    ]);

    $record->delete();

    return response()->json([
        'success' => true,
        'message' => 'Email verified successfully.',
        'redirect' => route('dashboard'),
    ]);
})->middleware('auth')->name('verification.verify');


Route::post('/verify-email/resend', function () {

    $user = auth()->user();

    EmailVerificationCode::where('user_id', $user->id)->delete();

    $otp = random_int(100000, 999999);

    EmailVerificationCode::create([
        'user_id' => $user->id,
        'otp' => Hash::make($otp),
        'expires_at' => now()->addMinutes(10),
    ]);


    Mail::to($user->email)->send(
        new VerifyEmailOtpMail($otp)
    );

    return response()->json([
        'success' => true,
        'message' => 'Verification code sent successfully.',
    ]);
})->middleware('auth')->name('verification.resend');
Route::get('/verify-email', function () {

    if (auth()->user()->email_verified_at) {
        return redirect()->route('dashboard');
    }

    return view('customer.auth.verify-email');
})->middleware('auth')->name('verification.notice');
