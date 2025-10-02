<x-guest-layout>
    
    <div
        class="w-[26rem] sm:w-[30rem] border-4 border-[#7e6853] rounded-lg bg-white/95 shadow-lg p-8 text-center"
        style="box-shadow: 0 8px 25px rgba(0,0,0,0.2);"
    >
        <!-- Logo -->
        <img
            src="{{ asset('images/ArchivesLogo.svg') }}"
            alt="Archives Logo"
            class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-[#c4a484] shadow-md"
        >

        <!-- Heading -->
        <h2 class="mt-5 text-2xl font-bold text-[#4a3c31]">Verify Your Email</h2>

        <!-- Description -->
        <p class="mt-3 text-sm text-stone-600 leading-relaxed">
            We’ve sent a verification link to your email.
            Click the link to activate your account.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <!-- Actions -->
        <div class="mt-8 space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="text-sm text-stone-600 hover:text-stone-900 underline"
                >
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <p class="mt-6 text-xs text-stone-400">
            Didn’t get the email? Check your spam folder or click the button above.
        </p>
    </div>
</x-guest-layout>
