<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-200 fill-current h-9" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <div class="flex items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-300 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:text-white focus:outline-none">
                                    Menu Varian
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('makanan')">{{ __('Makanan') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('minuman')">{{ __('Minuman') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('kontak')" :active="request()->routeIs('kontak')">
                        {{ __('Kontak') }}
                 </x-nav-link>
                 <x-nav-link :href="route('api.kelompok')" :active="request()->routeIs('api.kelompok')">
                        {{ __('Kelompok') }}
                </x-nav-link>
{{-- 🔽 Dropdown API Kelompok --}}
<div class="flex items-center">
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-300 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:text-white focus:outline-none">
                API Kelompok
                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            {{-- 🧩 Daftar API Kelompok --}}
            <x-dropdown-link :href="route('kelompok1.index')">{{ __('Kelompok 1 - Web Rental Baju') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok2.index')">{{ __('Kelompok 2 - Web Tripnesia') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok3.index')">{{ __('Kelompok 3 - Gadget House') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok5.index')">{{ __('Kelompok 5 - Caffe Shop') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok6.index')">{{ __('Kelompok 6 - Reservasi') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok7.index')">{{ __('Kelompok 7 - Web SobatPromo') }}</x-dropdown-link>
            <x-dropdown-link :href="route('kelompok9.index')">{{ __('Kelompok 9 - JustBuy (Akun Game)') }}</x-dropdown-link>

        </x-slot>
    </x-dropdown>
</div>



                    <x-nav-link :href="route('pesanan.index')" :active="request()->routeIs('pesanan.index')">
                        {{ __('Lihat Pesanan') }}
                    </x-nav-link>

                    @if (Auth::check() && Auth::user()->role === 'admin')

                        <x-nav-link :href="route('barang.create')" :active="request()->routeIs('barang.create')">
                            {{ __('Tambah Menu') }}
                        </x-nav-link>
                        <x-nav-link :href="route('barang.index')" :active="request()->routeIs('barang.index')">
                            {{ __('Edit Menu') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-300 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:text-white focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('api.kelompok')" :active="request()->routeIs('api.kelompok')">
                {{ __('Kelompok') }}
            </x-responsive-nav-link>
        <div class="pt-3 mt-3 border-t border-gray-700">
        <div class="px-4 text-sm font-medium text-gray-400">API Kelompok</div>
            <x-responsive-nav-link :href="route('kelompok1.index')">{{ __('Kelompok 1 - Web Rental Baju') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok2.index')">{{ __('Kelompok 2 - Web Tripnesia') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok3.index')">{{ __('Kelompok 3 - Gadget House') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok5.index')">{{ __('Kelompok 5 - Caffe Shop') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok6.index')">{{ __('Kelompok 6 - Reservasi') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok7.index')">{{ __('Kelompok 7 - Web SobatPromo') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kelompok9.index')">{{ __('Kelompok 9 - JustBuy (Akun Game)') }}</x-responsive-nav-link>
        </div>

            <x-responsive-nav-link :href="route('makanan')" :active="request()->routeIs('makanan')">
                {{ __('Makanan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('minuman')" :active="request()->routeIs('minuman')">
                {{ __('Minuman') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kontak')" :active="request()->routeIs('kontak')">
                {{ __('Kontak') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pesanan.index')" :active="request()->routeIs('pesanan.index')">
                {{ __('Lihat Pesanan') }}
            </x-responsive-nav-link>

            @if (Auth::check() && Auth::user()->role === 'admin')
                <div class="pt-3 mt-3 border-t border-gray-600">
                    <div class="px-4 text-sm font-medium text-gray-400">Admin Menu</div>
                    <x-responsive-nav-link :href="route('barang.create')" :active="request()->routeIs('barang.create')">
                        {{ __('Tambah Menu') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('barang.index')" :active="request()->routeIs('barang.index')">
                        {{ __('Edit Menu') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="text-base font-medium text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
