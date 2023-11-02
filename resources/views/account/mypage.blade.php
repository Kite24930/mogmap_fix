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
        <div id="container" class="w-full min-h-[100dvh] md:p-6">
            <div id="contentsContainer" class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col items-center">
                <h2 class="text-2xl"><i class="bi bi-person-circle mr-2"></i><span id="userName"></span> さん</h2>
                <p>登録メールアドレス：<span id="userEmail"></span></p>
                <a href="{{ route('account.edit') }}" class="px-4 py-2 bg-yellow-100 border border-yellow-500 rounded text-yellow-500 text-sm my-2 hover:bg-yellow-500 hover:border-yellow-100 hover:text-yellow-100">アカウントを編集する</a>
                <div id="editorWrapper" class="">
                    <div id="editor" class="">

                    </div>
                    <x-primary-button id="informationUpdate">お知らせ更新</x-primary-button>
                </div>
            </div>
        </div>
    </main>
    <div class="hidden w-1/2 max-w-sm border-green-300 font-bold mb-2 gap-4 px-4 py-2 bg-yellow-100 border-yellow-50 text-yellow-500 hover:bg-yellow-500 hover:border-yellow-100 hover:text-yellow-100 bg-blue-100 border-blue-500 text-blue-500 hover:bg-blue-500 hover:border-blue-100 hover:text-blue-100 bg-pink-100 border-pink-500 text-pink-500 hover:bg-pink-500 hover:border-pink-100 hover:text-pink-100 transition duration-300 mb-4"></div>
    @vite(['resources/js/account/mypage.js'])
</x-template>
