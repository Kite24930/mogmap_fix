<x-template title="ショップ一覧" css="shop/shop-list.css">
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
    <main class="flex flex-col justify-center items-start pt-20 md:pt-0 md:pl-[240px] min-h-[100dvh] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div id="container" class="w-full min-h-[100dvh] md:p-6 flex justify-center items-start md:items-center pt-10 md:pt-0">
            <div class="swiper shopSwiper">
                <div class="swiper-wrapper">
                    @foreach($shop_lists as $shop)
                        <x-shop.shop-list-item :data="$shop" />
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next bg-white rounded-full p-8 border border-gray-400"></div>
                <div class="swiper-button-prev bg-white rounded-full p-8 border border-gray-400"></div>
            </div>
        </div>
    </main>
    <div class="hidden bg-pink-500 hover:bg-pink-500 hover:bg-pink-100 hover:text-pink-500 bg-pink-100 hover:text-pink-100"></div>
    <script>
        window.Laravel = {};
        window.Laravel.shop_lists = @json($shop_lists);
        console.log(Laravel);
    </script>
    @vite(['resources/js/shop/shop-list.js'])
</x-template>
