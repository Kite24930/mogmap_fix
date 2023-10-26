<x-template title="アカウント編集" css="account.css">
    <div id="loading">
        <div class="wrapper">
            <div class="loading-circle"></div>
            <div class="loading-circle"></div>
            <div class="loading-circle"></div>
            <div class="loading-shadow"></div>
            <div class="loading-shadow"></div>
            <div class="loading-shadow"></div>
            <span class="text">Loading<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></span>
        </div>
    </div>
    @csrf
    <main class="flex flex-col justify-center items-start pt-20 md:pt-0 md:pl-[240px] min-h-[100dvh] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div id="container" class="w-full min-h-[100dvh] md:p-6">
            <div id="contentsContainer" class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col items-center">
                <h2 class="text-2xl"><i class="bi bi-person-circle mr-2"></i><span id="userName"></span> さん</h2>
                <div class="flex flex-col md:flex-row items-center p-4 border rounded-lg">
                    <x-input-label class="md:mr-2 text-left w-full md:w-auto">変更後のアカウント名</x-input-label>
                    <x-text-input id="accountName" class="" placeholder="変更後のアカウント名" />
                </div>
                <x-primary-button id="nameChangeBtn" class="mt-4 mb-8">アカウント名を変更する</x-primary-button>
                <p class="border-t pt-4 w-full text-center">登録メールアドレス：<span id="userEmail"></span></p>
                <div class="flex flex-col items-center border rounded-lg">
                    <div class="flex flex-col md:flex-row items-center p-4">
                        <x-input-label class="md:mr-2 text-left w-full md:w-auto">変更後のメールアドレス</x-input-label>
                        <x-text-input id="accountEmail" class="" placeholder="変更後のメールアドレス" type="email" />
                    </div>
                    <div class="flex flex-col md:flex-row items-center p-4">
                        <x-input-label class="md:mr-2 text-left w-full md:w-auto">変更後のメールアドレス（確認用）</x-input-label>
                        <x-text-input id="confirmEmail" class="" placeholder="変更後のメールアドレス" type="email" />
                    </div>
                    <div class="flex flex-col md:flex-row items-center p-4">
                        <x-input-label class="md:mr-2 text-left w-full md:w-auto">パスワード</x-input-label>
                        <x-text-input id="password" class="" placeholder="パスワード" type="password" />
                    </div>
                </div>
                <x-primary-button id="emailChangeBtn" class="mt-4">メールアドレスを変更する</x-primary-button>
            </div>
        </div>
    </main>
    <div class="hidden"></div>
    @vite(['resources/js/account/account-edit.js'])
</x-template>
