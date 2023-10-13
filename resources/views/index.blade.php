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
            <div class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col md:flex-row">
                <div id="map" class="w-full md:w-1/2 h-[60dvw] md:h-[600px] rounded-lg">

                </div>
                <div id="calendar">

                </div>
            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.set_ups = @json($set_ups);
        window.Laravel.date = @json($date);
        console.log(Laravel);
    </script>
    @vite(['resources/js/index.js'])
</x-template>
