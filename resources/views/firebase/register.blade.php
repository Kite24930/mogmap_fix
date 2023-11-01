<x-template title="マイページ" css="account.css">
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
        <div id="container" class="w-full min-h-[100dvh] md:p-6 flex justify-center items-center">
            <div id="contentsContainer" class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col items-center w-full max-w-xl">
                <h1 class="text-2xl font-bold border-b pb-4 w-full text-center border-gray-700">新規会員登録</h1>
                <x-input-label class="w-full text-left pl-2 mt-3">ユーザー名(氏名ではなくシステムで使う名前です)</x-input-label>
                <x-text-input id="user_name" name="user_name" class="w-full" placeholder="ユーザー名" />
                <x-input-label class="w-full text-left pl-2 mt-3">メールアドレス</x-input-label>
                <x-text-input id="email" name="email" class="w-full" placeholder="メールアドレス" type="email" />
                <x-input-label class="w-full text-left pl-2 mt-3">パスワード</x-input-label>
                <x-text-input id="password" name="password" class="w-full" placeholder="パスワード" type="password" />
                <x-input-label class="w-full text-left pl-2 mt-3">パスワード(確認用)</x-input-label>
                <x-text-input id="password_confirm" name="password_confirm" class="w-full" placeholder="パスワード(確認用)" type="password" />
                <x-primary-button id="register_button" name="register_button" class="mt-3" type="button">
                    新規登録
                </x-primary-button>
            </div>
        </div>
    </main>
    <div class="hidden w-1/2 max-w-sm border-green-300 font-bold mb-2 gap-4 px-4 py-2 bg-yellow-100 border-yellow-50 text-yellow-500 hover:bg-yellow-500 hover:border-yellow-100 hover:text-yellow-100 bg-blue-100 border-blue-500 text-blue-500 hover:bg-blue-500 hover:border-blue-100 hover:text-blue-100 bg-pink-100 border-pink-500 text-pink-500 hover:bg-pink-500 hover:border-pink-100 hover:text-pink-100 transition duration-300 mb-4"></div>
    @vite(['resources/js/firebase/register.js'])
</x-template>
