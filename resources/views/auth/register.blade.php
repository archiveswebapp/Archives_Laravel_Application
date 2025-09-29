<x-guest-layout>
    <div
        class="relative z-10 w-[28rem] sm:w-[32rem] border-4 border-[#7e6853] rounded-lg shadow-lg p-8 bg-white/95"
        style="box-shadow: 0 8px 25px rgba(0,0,0,0.25);"
    >
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Branding / Logo -->
            <div class="mb-6 text-center">
                <img src="{{ asset('images/ArchivesLogo.svg') }}" alt="Archives Logo"
                     class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-[#c4a484] shadow-md">
                <h2 class="mt-2 text-2xl font-bold text-[#4a3c31]">Welcome to Archives</h2>
                <p class="text-sm text-gray-600">Please register to login</p>
            </div>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                              :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                              :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
