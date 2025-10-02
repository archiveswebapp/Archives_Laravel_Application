<x-guest-layout>
    
    <div
        class="relative w-[28rem] sm:w-[32rem] bg-white/95 border-4 border-[#7e6853] rounded-lg p-8 shadow-lg"
        style="box-shadow: 0 8px 25px rgba(0,0,0,0.25);"
    >
        
        <div class="mb-6 text-center">
            <img
                src="{{ asset('images/ArchivesLogo.svg') }}"
                alt="Archives Logo"
                class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-[#b2987d] shadow-md"
            >
            <h2 class="mt-2 text-2xl font-bold text-[#4a3c31]">Welcome to Archives</h2>
            <p class="text-sm text-gray-600">Please log in to continue</p>
        </div>

      
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('error'))
            <div class="mb-4 font-medium text-sm text-red-600 bg-red-50 border border-red-200 rounded p-3">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded p-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    >
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-900 underline"
                       href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            @if (Route::has('register'))
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                            Register here
                        </a>
                    </p>
                </div>
            @endif
        </form>

        <!-- Divider -->
        <div class="mt-6 flex items-center justify-center">
            <hr class="w-full border-gray-300">
            <span class="px-3 text-gray-500 text-sm">or</span>
            <hr class="w-full border-gray-300">
        </div>

        <!-- Google Login -->
        <div class="mt-4">
            <a
                href="{{ route('google.redirect') }}"
                class="w-full flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 rounded shadow"
            >
                <img
                    src="https://www.svgrepo.com/show/475656/google-color.svg"
                    class="h-5 w-5 mr-2"
                    alt="Google Logo"
                >
                Sign in with Google
            </a>
        </div>
    </div>
</x-guest-layout>
