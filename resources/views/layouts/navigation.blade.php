{{-- 🌐 Sidebar Navigation (versi kiri) --}}
<aside class="fixed left-0 top-0 h-full w-64 bg-white dark:bg-slate-900 border-r border-gray-200 dark:border-slate-700 shadow-md flex flex-col justify-between z-50">

    {{-- 🔷 Logo dan Brand --}}
    <div>
        <div class="flex items-center gap-2 px-5 h-16 border-b border-gray-200 dark:border-slate-700">
            <x-application-logo class="h-8 w-auto text-indigo-600" />
            <span class="text-lg font-bold text-gray-800 dark:text-gray-100">Stockify</span>
        </div>

        {{-- 🔹 Menu Utama --}}
        <nav class="flex flex-col mt-4 space-y-1 font-medium">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 px-5 py-3 rounded-md hover:bg-indigo-50 dark:hover:bg-slate-800 transition {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-600 dark:bg-slate-800 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="fa-solid fa-chart-line w-5 text-indigo-500"></i> Dashboard
            </a>

            <a href="{{ route('products.index') }}"
                class="flex items-center gap-2 px-5 py-3 rounded-md hover:bg-indigo-50 dark:hover:bg-slate-800 transition {{ request()->routeIs('products.*') ? 'bg-indigo-100 text-indigo-600 dark:bg-slate-800 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="fa-solid fa-box-open w-5 text-indigo-500"></i> Produk
            </a>

            <a href="{{ route('categories.index') }}"
                class="flex items-center gap-2 px-5 py-3 rounded-md hover:bg-indigo-50 dark:hover:bg-slate-800 transition {{ request()->routeIs('categories.*') ? 'bg-indigo-100 text-indigo-600 dark:bg-slate-800 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="fa-solid fa-layer-group w-5 text-indigo-500"></i> Kategori
            </a>

            <a href="{{ route('suppliers.index') }}"
                class="flex items-center gap-2 px-5 py-3 rounded-md hover:bg-indigo-50 dark:hover:bg-slate-800 transition {{ request()->routeIs('suppliers.*') ? 'bg-indigo-100 text-indigo-600 dark:bg-slate-800 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="fa-solid fa-truck-field w-5 text-indigo-500"></i> Supplier
            </a>
        </nav>
    </div>

    {{-- 👤 Profil & Logout --}}
    <div class="border-t border-gray-200 dark:border-slate-700 p-4">
        <div class="relative group">
            <button class="flex items-center justify-between w-full text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition">
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366F1&color=fff"
                        class="h-8 w-8 rounded-full border border-gray-300 dark:border-slate-600">
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <i class="fa-solid fa-chevron-up text-sm"></i>
            </button>

            {{-- Dropdown --}}
            <div class="hidden group-hover:block absolute bottom-12 left-0 right-0 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg py-2">
                <a href="{{ route('profile.edit') }}" 
                   class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <i class="fa-regular fa-user mr-2 text-indigo-500"></i> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                        <i class="fa-solid fa-right-from-bracket mr-2 text-red-500"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

{{-- 💡 Font Awesome untuk ikon --}}
<script src="https://kit.fontawesome.com/4b3b2c2d79.js" crossorigin="anonymous"></script>
