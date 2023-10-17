<header class="w-full md:w-auto h-20 md:h-auto fixed top-0 left-0 flex justify-center items-center z-50">
    <div id="topHeader" class="w-full max-w-2xl flex flex-wrap items-center justify-between p-4 md:hidden">
        <a href="{{ route('index') }}" class="h-16 p-2 bg-white rounded-lg flex justify-center items-end gap-4 relative z-50">
            <img src="{{ asset('storage/data/mogmap_icon.png') }}" alt="icon" class="object-contain h-12">
            <img src="{{ asset('storage/data/mogmap_logo.png') }}" alt="mogmap" class="object-contain h-8 mb-1">
        </a>
        <div class="flex-wrap items-center relative z-50">
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 bg-white" aria-controls="mega-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full md:w-auto max-w-2xl">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                <li class="">
                    <a href="{{ route('index') }}" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="bi bi-house mr-2"></i>HOME
                    </a>
                </li>
                <li>
                    <a href="{{ route('foods_bond') }}" class="block px-4 py-2 hover:bg-gray-100">
                        <img src="{{ asset('storage/foods_bond/logo.png') }}" alt="Foods Bond">
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="leftHeader" class="fixed left-0 top-0 hidden md:flex flex-col justify-start items-center p-6 bg-white h-[100dvh] border-r gap-4">
        <a href="{{ route('index') }}" class="h-16 p-2 bg-white rounded-lg flex justify-center items-end gap-4">
            <img src="{{ asset('storage/data/mogmap_icon.png') }}" alt="icon" class="object-contain h-12">
            <img src="{{ asset('storage/data/mogmap_logo.png') }}" alt="mogmap" class="object-contain h-8 mb-1">
        </a>
        <div class="w-48 text-sm border border-gray-200 rounded-lg">
            <a href="/" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2">
                <i class="bi bi-house mr-2"></i>HOME
            </a>
        </div>
        <div class="w-48 text-sm border border-gray-200 rounded-lg">
            <a href="{{ route('foods_bond') }}" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2">
                <img src="{{ asset('storage/foods_bond/logo.png') }}" alt="Foods Bond">
            </a>
        </div>
    </div>
</header>
