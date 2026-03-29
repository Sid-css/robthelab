<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | RobtheLabStudios</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

@if (session('status'))
    <div style="color: #2ecc71; background: #e8f8f5; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem;">
        {{ session('status') }}
    </div>
@endif

<div class="auth-wrapper">

    <!-- LEFT BRAND SECTION -->
    <div class="brand-section">
        <img src="{{ asset('images/rtlzoom.jpg') }}" alt="RobtheLabStudios Logo">
        <h1>RobtheLabStudios</h1>
        <p>Visuals That Speak.</p>
    </div>


    <!-- RIGHT LOGIN SECTION -->
  <!-- RIGHT LOGIN SECTION -->
    <div class="login-section">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label>Email</label>
                <!-- Added value="{{ old('email') }}" so they don't have to retype it if they fail -->
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email here" required>
                
                <!-- Display Authentication Errors -->
                @error('email')
                    <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Enter Studio</button>

           <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
        </form>
    </div>

</div>

</body>
</html>


{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
