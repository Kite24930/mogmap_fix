<header class="w-full md:w-auto h-20 md:h-auto fixed top-0 left-0 flex justify-center items-center z-50">
    <div id="topHeader" class="w-full max-w-2xl flex flex-wrap items-center justify-between p-4 md:hidden">
        <a href="{{ route('index') }}" class="h-16 p-2 bg-white rounded-lg flex justify-center items-end gap-4 relative z-50">
            <img src="{{ asset('storage/data/mogmap_icon.png') }}" alt="icon" class="object-contain h-12">
            <img src="{{ asset('storage/data/mogmap_logo.png') }}" alt="mogmap" class="object-contain h-8 mb-1">
        </a>
        <div class="flex flex-wrap items-center justify-center relative gap-4 z-50">
            <button id="spLoginBtn" data-dropdown-toggle="spLoginContainer" class="account-btn inline-flex items-center w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 bg-white text-center">
                <div class="spin-load-wrapper w-full h-full flex justify-center items-center">
                    <div class="spin-load text-pink-500"></div>
                </div>
            </button>
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 bg-white" aria-controls="mega-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <div id="spLoginContainer" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full md:w-auto max-w-2xl">
            <form id="spLogin" class="w-full px-4 py-2 border-b border-gray-200" aria-labelledby="spLoginBtn">
                <x-input-label for="spLoginEmail">Email</x-input-label>
                <x-text-input id="spLoginEmail" class="w-full text-sm" type="email" />
                <x-input-label for="spLoginPassword">Password</x-input-label>
                <x-text-input id="spLoginPassword" class="w-full text-sm" type="password" />
                <div class="flex justify-center items-center py-2">
                    <x-primary-button type="button" data-target-email="spLoginEmail" data-target-password="spLoginPassword" class="login-btn">ログイン</x-primary-button>
                </div>
                <div class="flex justify-center items-center py-2 gap-4">
                    <a href="{{ route('password.reset') }}" class="underline">パスワードの再設定はこちら</a>
                    <a href="{{ route('firebase.register') }}" class="underline">新規登録はこちら</a>
                </div>
            </form>
        </div>
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full md:w-auto max-w-2xl">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                <li class="border-b">
                    <a href="{{ route('index') }}" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="bi bi-house mr-2"></i>HOME
                    </a>
                </li>
                <li class="border-b">
                    <a href="{{ route('shop.list') }}" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="bi bi-shop mr-2"></i>ショップ一覧
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
        <div id="accordion-collapse" data-accordion="collapse" class="w-48 text-sm border border-gray-200 rounded-lg">
            <div id="accordion-collapse-heading-1">
                <button id="pcLoginBtn" class="account-btn block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2 text-left" type="button" data-accordion-target="#pcLogin" aria-expanded="false" aria-controls="pcLogin">
                    <div class="spin-load-wrapper w-full h-full flex justify-center items-center">
                        <div class="spin-load text-pink-500"></div>
                    </div>
                </button>
            </div>
            <form id="pcLogin" class="hidden w-full px-4 py-2 border-b border-gray-200" aria-labelledby="accordion-collapse-heading-1">

            </form>
        </div>
        <div class="w-48 text-sm border border-gray-200 rounded-lg">
            <a href="{{ route('index') }}" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2">
                <i class="bi bi-house mr-2"></i>HOME
            </a>
            <a href="{{ route('shop.list') }}" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2">
                <i class="bi bi-shop mr-2"></i>ショップ一覧
            </a>
        </div>
        <div class="w-48 text-sm border border-gray-200 rounded-lg">
            <a href="{{ route('foods_bond') }}" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2">
                <img src="{{ asset('storage/foods_bond/logo.png') }}" alt="Foods Bond">
            </a>
        </div>
    </div>
</header>
