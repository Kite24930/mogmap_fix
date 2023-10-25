<x-template title="{{ $shop->shop_name }}" css="shop/shop.css">
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
        <div id="container" class="w-full min-h-[100dvh] md:p-6 relative">
            <div id="followBtn" class="absolute top-2 left-2 w-14 h-14 bg-pink-50 flex justify-center items-center border rounded-full">
                <div class="spin-load-wrapper w-full h-full flex justify-center items-center">
                    <div class="spin-load text-pink-500"></div>
                </div>
{{--                <i class="bi bi-heart-arrow mr-1 text-pink-500"></i><i class="bi bi-heart text-pink-500"></i>--}}
{{--                <i class="bi bi-arrow-through-heart text-2xl text-pink-100"></i>--}}
            </div>
            <div class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col items-center">
                <div class="w-full flex flex-col md:flex-row justify-center md:justify-evenly items-center mb-4">
                    <div class="w-full max-w-md flex flex-col items-center justify-center">
                        <h1 class="text-6xl font-bold">{{ $shop->shop_name }}</h1>
                        <h2 class="text-xl my-2">【{{ $shop->genre_name }}】</h2>
                    </div>
                    <div class="square w-full max-w-md">
                        <img src="{{ asset('storage/shop/'.$shop->shop_img) }}" alt="{{ $shop->shop_name }}" class="rounded-lg">
                    </div>
                </div>
                <div class="border-b border-gray-200 w-full max-w-4xl">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        @if(isset($shop->pr_txt_1) || isset($shop->pr_txt_2) || isset($shop->pr_txt_3) || isset($shop->pr_img_1) || isset($shop->pr_img_2) || isset($shop->pr_img_3))
                            <li class="flex-grow flex-1" role="presentation">
                                <button class="w-full inline-block p-4 border-b-2 rounded-t-lg text-sm group text-green-800 hover:text-green-50 hover:bg-green-800" id="pr-tab" type="button" role="tab" aria-controls="pr" aria-selected="false" data-tabs-target="#pr">
                                    <span class="flex items-center justify-center group-hover:text-green-50">
                                        <i class="bi bi-megaphone mr-2 text-green-800 group-hover:text-green-50"></i>PR
                                    </span>
                                </button>
                            </li>
                        @endif
                        <li class="flex-grow flex-1" role="presentation">
                            <button class="w-full inline-block p-4 border-b-2 rounded-t-lg text-sm group text-green-800 hover:text-green-50 hover:bg-green-800" id="schedule-tab" type="button" role="tab" aria-controls="schedule" aria-selected="false" data-tabs-target="#schedule">
                                <span class="hidden md:flex justify-center items-center group-hover:text-green-50">
                                    <i class="bi bi-calendar-week mr-2 text-green-800 group-hover:text-green-50"></i>出店スケジュール
                                </span>
                                <span class="flex md:hidden justify-center items-center group-hover:text-green-50">
                                    <i class="bi bi-calendar-week mr-2 text-green-800 group-hover:text-green-50"></i>出店
                                </span>
                            </button>
                        </li>
                        <li class="flex-grow flex-1" role="presentation">
                            <button class="w-full inline-block p-4 border-b-2 rounded-t-lg text-sm group text-green-800 hover:text-green-50 hover:bg-green-800" id="profile-tab" type="button" role="tab" aria-controls="profile" aria-selected="false" data-tabs-target="#profile">
                                <span class="hidden md:flex justify-center items-center group-hover:text-green-50">
                                    <i class="bi bi-info-circle mr-2 text-green-800 group-hover:text-green-50"></i>基本情報
                                </span>
                                <span class="flex md:hidden justify-center items-center group-hover:text-green-50">
                                    <i class="bi bi-info-circle mr-2 text-green-800 group-hover:text-green-50"></i>info
                                </span>
                            </button>
                        </li>
                        @if(isset($menus) && count($menus) > 0)
                            <li class="flex-grow flex-1" role="presentation">
                                <button class="w-full inline-block p-4 border-b-2 rounded-t-lg text-sm group text-green-800 hover:text-green-50 hover:bg-green-800" id="menu-tab" type="button" role="tab" aria-controls="menu" aria-selected="false" data-tabs-target="#menu">
                                    <span class="flex items-center justify-center group-hover:text-green-50">
                                    <i class="bi bi-card-list mr-2 text-green-800 group-hover:text-green-50"></i>MENU
                                </span>
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
                <div id="myTabContent" class="w-full max-w-4xl">
                    @if(isset($shop->pr_txt_1) || isset($shop->pr_txt_2) || isset($shop->pr_txt_3) || isset($shop->pr_img_1) || isset($shop->pr_img_2) || isset($shop->pr_img_3))
                        <div class="hidden border-b border-r border-l border-gray-200 rounded-b-lg p-4 w-full" id="pr" role="tabpanel" aria-labelledby="pr-tab">
                            <div class="swiper cardSwiper w-full max-w-xl flex justify-center items-center mx-auto">
                                <div class="swiper-wrapper max-w-xl">
                                    @if(isset($shop->pr_txt_1) || isset($shop->pr_img_1))
                                        <div class="swiper-slide w-full max-w-xl bg-green-50 p-6 rounded-lg border border-green-300">
                                            @if(isset($shop->pr_img_1))
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/shop/'.$shop->pr_img_1) }}" alt="{{ $shop->shop_name }}" class="rounded-lg">
                                                </div>
                                            @endif
                                            @if(isset($shop->pr_txt_1))
                                                <p class="text-center mt-4">
                                                    {!! nl2br(e($shop->pr_txt_1)) !!}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                    @if(isset($shop->pr_txt_2) || isset($shop->pr_img_2))
                                        <div class="swiper-slide w-full max-w-xl bg-yellow-50 p-6 border border-yellow-300 rounded-lg">
                                            @if(isset($shop->pr_img_2))
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/shop/'.$shop->pr_img_2) }}" alt="{{ $shop->shop_name }}" class="rounded-lg">
                                                </div>
                                            @endif
                                            @if(isset($shop->pr_txt_2))
                                                <p class="text-center mt-4">
                                                    {!! nl2br(e($shop->pr_txt_2)) !!}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                    @if(isset($shop->pr_txt_3) || isset($shop->pr_img_3))
                                        <div class="swiper-slide w-full max-w-xl bg-pink-50 p-6 border border-pink-300 rounded-lg">
                                            @if(isset($shop->pr_img_3))
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/shop/'.$shop->pr_img_3) }}" alt="{{ $shop->shop_name }}" class="rounded-lg">
                                                </div>
                                            @endif
                                            @if(isset($shop->pr_txt_3))
                                                <p class="text-center mt-4">
                                                    {!! nl2br(e($shop->pr_txt_3)) !!}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    @endif
                    <div class="hidden border-b border-r border-l border-gray-200 rounded-b-lg p-4 w-full" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                        <div class="w-full flex justify-start md:justify-center items-center p-6">
                            <ol class="border-l border-gray-200">
                                @foreach($schedules as $schedule)
                                    <li class="mb-10 ml-6 relative">
                                        @if(isset($schedule->place_id))
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-yellow-200 rounded-full -left-9 ring-8 ring-white">
                                                <i class="bi bi-truck text-yellow-700"></i>
                                            </span>
                                            <time class="block pt-1 mb-1 text-sm font-normal leading-none">{{ date('m/d(D)', strtotime($schedule->date)) }} @if(isset($schedule->start_time)) {{ date('G:i', strtotime($schedule->start_time)) }}〜{{ date('G:i', strtotime($schedule->end_time)) }} @endif</time>
                                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{ $schedule->place_name }}</h3>
                                            <p class="mb-4 text-base font-normal text-gray-500">{{ $schedule->address }}</p>
                                            <a href="https://maps.apple.com/?q={{ $schedule->lat }},{{ $schedule->lng }}&z=16&t=satellite" class="map-open text-sm bg-green-100 text-green-800 font-medium px-2.5 py-0.5 rounded border  border-green-400 my-2">
                                                <i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く
                                            </a>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-pink-200 rounded-full -left-9 ring-8 ring-white">
                                                <i class="bi bi-chat-right-heart text-pink-700"></i>
                                            </span>
                                            <time class="block pt-1 mb-1 text-sm font-normal leading-none">{{ date('m/d(D)', strtotime($schedule->date)) }} @if(isset($schedule->start_time)) {{ date('G:i', strtotime($schedule->start_time)) }}〜{{ date('G:i', strtotime($schedule->end_time)) }} @endif</time>
                                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{ $schedule->event_name }}</h3>
                                            <h4>in {{ $schedule->event_place_name }}</h4>
                                            <p class="mb-4 text-base font-normal text-gray-500">{{ $schedule->event_address }}</p>
                                            <a href="https://maps.apple.com/?q={{ $schedule->event_lat }},{{ $schedule->event_lng }}&z=16&t=satellite" class="map-open text-sm bg-green-100 text-green-800 font-medium px-2.5 py-0.5 rounded border  border-green-400 my-2">
                                                <i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <div class="hidden border-b border-r border-l border-gray-200 rounded-b-lg p-4 w-full" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="w-full flex justify-center items-center p-4">
                            <div class="w-full md:max-w-md">
                                <div class="w-full border-b border-gray-200 p-4">
                                    <i class="bi bi-truck mr-2"></i>ショップ名：{{ $shop->shop_name }}
                                </div>
                                <div class="w-full border-b border-gray-200 p-4">
                                    <i class="bi bi-list-stars mr-2"></i>ジャンル：{{ $shop->genre_name }}
                                </div>
                                <div class="w-full border-b border-gray-200 p-4">
                                    <i class="bi bi-globe-asia-australia mr-2"></i>営業エリア：{{ $shop->area }}
                                </div>
                                <div class="w-full border-b border-gray-200 p-4">
                                    <i class="bi bi-list-check mr-2"></i>予約について：{{ $shop->reserve }}
                                </div>
                                <div class="w-full border-b border-gray-200 p-4">
                                    <i class="bi bi-instagram mr-2"></i>Instagram：<a href="https://www.instagram.com/{{ $shop->instagram }}/" class="underline">{{ $shop->instagram }}</a>
                                </div>
                                @if(isset($shop->homepage))
                                    <div class="w-full border-b border-gray-200 p-4">
                                        <i class="bi bi-house mr-2"></i>HP：<a href="{{ $shop->homepage }}" class="underline">{{ $shop->homepage }}</a>
                                    </div>
                                @endif
                                @if(isset($shop->twitter))
                                    <div class="w-full border-b border-gray-200 p-4">
                                        <i class="bi bi-twitter mr-2"></i>X(旧Twitter)：<a href="https://twitter.com/{{ $shop->twitter }}/" class="underline">{{ $shop->twitter }}</a>
                                    </div>
                                @endif
                                @if(isset($shop->facebook))
                                    <div class="w-full border-b border-gray-200 p-4">
                                        <i class="bi bi-facebook mr-2"></i>facebook：<a href="https://www.facebook.com/{{ $shop->facebook }}?locale=ja_JP/" class="underline">{{ $shop->facebook }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(isset($menus) && count($menus) > 0)
                        <div class="hidden border-b border-r border-l border-gray-200 rounded-b-lg p-4 w-full" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                            <div class="w-full max-w-2xl mx-auto flex justify-center items-center">
                                <table class="w-full">
                                    <tbody>
                                        @foreach($menus as $menu)
                                            @if($menu->menu_price === 0)
                                                <tr class="border-b border-gray-200 bg-yellow-100">
                                                    <td class="p-4 text-lg font-semibold" colspan="2">
                                                        {{ $menu->menu_name }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-4 pl-4">
                                                        {{ $menu->menu_name }}
                                                    </td>
                                                    <td class="w-20 p-4 text-sm text-right">
                                                        {{ $menu->menu_price }}円
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <div class="hidden bg-green-100 bg-green-500 text-green-800 text-green-50"></div>
    <script>
        window.Laravel = {};
        window.Laravel.shop = @json($shop);
        window.Laravel.menus = @json($menus);
        window.Laravel.schedules = @json($schedules);
        console.log(Laravel);
    </script>
    @vite(['resources/js/shop/shop.js'])
</x-template>
