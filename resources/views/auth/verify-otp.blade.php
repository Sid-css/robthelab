<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('We have sent a 6-digit OTP to your email: ') }} <strong>{{ session('reset_email') }}</strong>
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <!-- VERIFY OTP FORM -->
    <form method="POST" action="{{ route('password.verify.otp.submit') }}">
        @csrf
        <div>
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus placeholder="123456" maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify OTP') }}
            </x-primary-button>
        </div>
    </form>

    <!-- RESEND OTP FORM -->
    <div class="mt-6 border-t pt-4">
<form method="POST" action="{{ route('password.email.otp') }}">
    @csrf
    <input type="hidden" name="email" value="{{ session('reset_email') }}">
    <button type="submit" class="underline text-sm text-indigo-600 hover:text-indigo-900 ml-2">
        Resend OTP
    </button>
</form>
    </div>
</x-guest-layout>