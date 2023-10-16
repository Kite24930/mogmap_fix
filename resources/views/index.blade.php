<x-template title="mogmap" css="index.css">
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
    <main class="flex justify-center items-start pt-20 md:pt-0 md:pl-[240px] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div id="container" class="w-full min-h-[100dvh] md:p-6">
            <div class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col md:flex-row justify-between relative">
                <div class="w-full md:w-1/2 h-[60vh] md:h-[600px]">
                    <div>
                        <ul id="tabs" class="flex flex-wrap justify-between gap-2 text-sm font-medium text-center" data-tabs-toggle="#tabContents" role="tablist">
                            <li class="flex-grow" role="presentation">
                                <button id="map-tab" class="inline-block p-2 border-b-2 rounded-t-lg w-full tab-btn active" data-tabs-target="#map" type="button" role="tab" aria-controls="map" aria-selected="true">
                                    <i class="bi bi-pin-map"></i>マップ表示
                                </button>
                            </li>
                            <li class="flex-grow" role="presentation">
                                <button id="map-tab" class="inline-block p-2 border-b-2 rounded-t-lg w-full tab-btn" data-tabs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">
                                    <i class="bi bi-list-ul"></i>リスト表示
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div id="tabContents" class="w-full h-[calc(60vh-38px)] md:h-[calc(600px-38px)]">
                        <div id="map" class="w-full h-full rounded-lg relative z-30">

                        </div>
                        <div id="list" class="w-full h-full rounded-lg relative z-30 flex flex-col flex-nowrap gap-2 p-2 border border-gray-400 overflow-auto" data-simplebar>

                        </div>
                    </div>
                </div>
                <div id="calendar" class="w-full md:w-1/2 p-4 md:p-0 md:pl-4">

                </div>
            </div>
        </div>
    </main>
    <div class="hidden bg-yellow-100 text-yellow-800 border-yellow-300 bg-green-100 text-green-800 border-green-400 bg-pink-100 border-pink-400 text-pink-800 px-2.5 py-0.5 my-2 mb-2 pb-3 pr-3 md:pb-0 md:pr-0 text-gray-500 shadow bottom-4 right-4 gap-4 items-start justify-between ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 top-16 left-1/4 -translate-x-1/2 text-yellow-300 bg-pink-100 border-cyan-400 text-xs md:flex-row"></div>
    <script>
        window.Laravel = {};
        window.Laravel.set_ups = @json($set_ups);
        window.Laravel.date = @json($date);
        window.Laravel.events = @json($events);
        window.Laravel.same_lists = @json($same_lists);
        // console.log(Laravel);
    </script>
    @vite(['resources/js/index.js'])
</x-template>
