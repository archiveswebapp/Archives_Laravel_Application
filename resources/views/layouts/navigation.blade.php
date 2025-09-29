<nav x-data="{ open: false }" class="border-b border-gray-100 bg-[#c8b8b2]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="block mr-6">
                    <img
                        src="{{ asset('images/ArchivesLogo.svg') }}"
                        alt="Archives Logo"
                        class="h-10 w-10 rounded-full object-cover"
                    >
                </a>
            </div>

            <!-- Center: Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-nav-link>

                <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    {{ __('Categories') }}
                </x-nav-link>

                <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                    {{ __('Cart') }}
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if ($cartCount)
                        <span class="ml-1 inline-flex items-center justify-center text-xs px-2 py-0.5 rounded-full bg-indigo-600 text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </x-nav-link>
            </div>

            <!-- Right: Auth / User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-800 hover:text-gray-900 focus:outline-none transition"
                                type="button"
                            >
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-stone-700 text-white text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.188l3.71-3.96a.75.75 0 111.08 1.04l-4.24 4.53a.75.75 0 01-1.08 0l-4.24-4.53a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-black hover:text-gray-700">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    class="text-red-600 hover:text-red-800"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                >
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-800 hover:text-gray-900">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm text-indigo-700 hover:text-indigo-900">{{ __('Register') }}</a>
                        @endif
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-black/10 focus:outline-none focus:bg-black/10 transition"
                    aria-label="Toggle navigation"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background-color:#f0d8b4;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                {{ __('Cart') }}
                @php $cartCount = count(session('cart', [])); @endphp
                @if ($cartCount)
                    <span class="ml-1 inline-flex items-center justify-center text-xs px-2 py-0.5 rounded-full bg-indigo-600 text-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </x-responsive-nav-link>
            
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-600">{{ auth()->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            @guest
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</nav>
