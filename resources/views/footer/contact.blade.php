<x-template title="お問い合わせ" css="footer.css">
    <main class="flex flex-col justify-center items-start pt-20 md:pt-0 md:pl-[240px] min-h-[100dvh] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div id="container" class="w-full min-h-[100dvh] md:p-6">
            <div class="rounded-lg p-4 bg-white border border-gray-500">
                <h1 class="text-center text-4xl mb-8 pb-2 border-b border-gray-700">お問い合わせ</h1>
                <div class="text-center">
                    mogmapについてのお問い合わせは公式InstagramのDMからご連絡ください。
                    <br>
                    （※現在、キッチンカーの仲介・手配は行っておりません。ご了承ください。）
                </div>
                <div class="flex justify-center items-center my-4">
                    <a href="https://www.instagram.com/mogmap_official/" class="flex items-center px-4 py-2 border border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2 rounded">
                        <i class="bi bi-instagram mr-1 text-2xl"></i>mogmap_official
                    </a>
                </div>
                <div class="text-center">
                    その他、弊社へのお問い合わせは、弊社HPよりお問い合わせください。
                </div>
                <div class="flex justify-center items-center my-4">
                    <a href="https://www.mie-projectm.com/contact" class="flex items-center px-4 py-2 border border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-blue-700 focus:ring-2 rounded">
                        <i class="bi bi-house-heart mr-1 text-2xl"></i>株式会社プロジェクトM HP お問い合わせフォーム
                    </a>
                </div>
            </div>
        </div>
    </main>
    @vite(['resources/js/footer.js'])
</x-template>
