<x-template title="フォローリスト" css="account.css">
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
            <div class="rounded-lg p-4 bg-white border border-gray-500">
                <div id="contentsContainer" class="flex flex-wrap justify-center items-center gap-6">

                </div>
            </div>
        </div>
    </main>
    <div class="hidden bg-yellow-50 border-yellow-300 p-4 rounded-lg gap-4 text-lg font-bold w-32 text-sm bg-green-100 border-green-500 text-green-500 hover:bg-green-500 hover:text-green-500 hover:border-green-100 transition duration-300 bg-pink-100 border-pink-500 text-pink-500 hover:bg-pink-500 hover:text-pink-100 hover:border-pink-100 group group-hover:text-pink-100"></div>
    @vite(['resources/js/account/followed.js'])
</x-template>
