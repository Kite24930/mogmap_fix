<x-template title="出展情報編集" css="account.css">
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
    <input type="hidden" id="shop_id" value="{{ $id }}">
    <main class="flex flex-col justify-center items-start pt-20 md:pt-0 md:pl-[240px] min-h-[100dvh] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div id="container" class="w-full min-h-[100dvh] md:p-6">
            @if(isset($success))
                <div class="bg-green-100 border border-green-500 text-green-500 px-4 py-2 rounded-lg mb-4">
                    {{ $success }}
                </div>
            @endif
            @if(isset($error))
                <div class="bg-red-100 border border-red-500 text-red-500 px-4 py-2 rounded-lg mb-4">
                    {{ $error }}
                </div>
            @endif
            <div id="contentsContainer" class="rounded-lg p-4 bg-white border border-gray-500 flex flex-col items-start w-full">
                <div id="accordion-collapse" data-accordion="collapse" class="w-full max-w-xl mx-auto">
                    <h2 id="accordion-collapse-heading-2">
                        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 bg-gray-100 rounded-t-lg" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
                            <span>登録リスト</span>
                            <i class="bi bi-plus text-2xl"></i>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-2" class="hidden transition duration-300 h-[60dvh] overflow-auto" aria-labelledby="accordion-collapse-heading-2">
                        <div class="p-5 border rounded-b-lg border-gray-200">
                            <div id="detailed-pricing" class="w-full overflow-x-auto">
                                <div class="overflow-hidden min-w-max">
                                    <div class="flex flex-col justify-between items-center w-full">
                                        @foreach($setup_lists as $setup)
                                            @if($setup->status === 1)
                                                @if($setup->event_id === null)
                                                    <div class="flex flex-col md:flex-row justify-between items-center p-2 text-sm text-gray-700 border-b border-gray-200 gap-2 w-full">
                                                @else
                                                    <div class="flex flex-col md:flex-row justify-between items-center p-2 text-sm text-gray-700 border-b border-gray-200 gap-2 w-full bg-green-100">
                                                @endif
                                            @else
                                                <div class="flex flex-col md:flex-row justify-between items-center p-2 text-sm text-gray-700 border-b border-gray-200 gap-2 w-full bg-blue-100">
                                            @endif
                                                <div>
                                                    {{ $setup->date }}
                                                </div>
                                                <div>
                                                    @if(isset($setup->event_id))
                                                        {{ $setup->event_name }}
                                                    @endif
                                                    {{ $setup->place_name }}
                                                </div>
                                                <div class="flex gap-2 items-center">
                                                    <x-primary-button type="button" data-setup-id="{{ $setup->id }}" class="schedule-edit">編集</x-primary-button>
                                                    @if($setup->status !== 0)
                                                        <x-primary-button type="button" data-setup-id="{{ $setup->id }}" class="schedule-canceled">中止</x-primary-button>
                                                    @else
                                                        <x-primary-button type="button" data-setup-id="{{ $setup->id }}" class="schedule-cancellation">中止解除</x-primary-button>
                                                    @endif
                                                    <x-primary-button type="button" data-setup-id="{{ $setup->id }}" class="schedule-delete">削除</x-primary-button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('setup.register', $id) }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl flex justify-center items-center my-4 mx-auto py-4 px-0 md:p-4 border rounded-lg">
                    @csrf
                    <div class="w-full max-w-4xl py-4 px-2 md:p-4 flex flex-col items-center">
                        <div id="calendar" class="w-full h-[100dvw] md:h-auto border py-4 px-2 md:p-4 rounded-lg max-w-xl">

                        </div>
                        <div id="time" class="py-4 flex flex-col items-center gap-2 p-4 rounded-lg border w-full max-w-xl">
                            <div>
                                <div>
                                    <label>
                                        <x-text-input type="checkbox" id="multipleDate" />
                                        複数日時選択
                                    </label>
                                </div>
                                <div class="py-4 border rounded-lg">
                                    <p class="text-sm text-gray-500 text-left underline pl-2">選択された日付</p>
                                    <ul id="selectDate" class="list-disc pt-2 px-8">

                                    </ul>
                                </div>
                            </div>
                            <div>
                                <x-text-input id="start_time" type="time" value="10:00" />
                                <span class="text-2xl mx-2">〜</span>
                                <x-text-input id="end_time" type="time" value="15:00" />
                            </div>
                            <div>
                                <label>
                                    <x-text-input id="notDecided" type="checkbox" />
                                    時間未定
                                </label>
                            </div>
                        </div>
                        <div class="py-4 flex flex-col items-center gap-2 p-4 rounded-lg border w-full max-w-xl">
                            <div id="eventSelect" class="flex flex-col items-center gap-2 w-full">
                                <label>
                                    <x-text-input type="checkbox" id="eventValid" />
                                    イベント出店
                                </label>
                                <select id="event" class="hidden border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    <option class="hidden">イベントを選択してください</option>
                                    <option value="-1">新規作成</option>
                                    @foreach($event_lists as $event)
                                        <option value="{{ $event->event_id }}">{{ $event->event_date }}{{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                                <x-text-input id="newEvent" class="w-full hidden" placeholder="イベント名" />
                            </div>
                            <div class="flex flex-col items-center gap-2 w-full">
                                <x-input-label class="text-left w-full">出店場所</x-input-label>
                                <div class="flex w-full gap-2">
                                    <x-text-input id="placeSearch" placeholder="検索" class="w-full" list="placeList" type="search" />
                                    <x-primary-button id="placeSearchBtn" type="button" class="w-auto text-center">検索</x-primary-button>
                                </div>
                                <datalist id="placeList">
                                    @foreach($places as $place)
                                        <option value="{{ $place->place_name }}"></option>
                                    @endforeach
                                </datalist>
                                <x-text-input id="place_id" type="hidden" />
                                <x-input-label class="w-full text-left">住所(都道府県から)</x-input-label>
                                <div class="flex w-full gap-2">
                                    <x-text-input id="address" class="w-full bg-gray-100 text-gray-700" placeholder="住所" readonly />
                                    <x-primary-button id="addressSearchBtn" type="button" class="w-auto text-center hidden">検索</x-primary-button>
                                </div>
                                <div id="candidate" class="w-full hidden">
                                    <x-input-label class="w-full text-left">候補リスト</x-input-label>
                                    <div id="candidateList" class="flex flex-col items-start gap-1">
                                        <div class="px-2.5 py-0.5 bg-red-100 border border-red-500 rounded candidate" data-place-id="258">goofy skate park</div>
                                        <div class="px-2.5 py-0.5 bg-red-100 border border-red-500 rounded candidate" data-place-id="258">goofy skate park</div>
                                        <div class="px-2.5 py-0.5 bg-red-100 border border-red-500 rounded candidate" data-place-id="258">goofy skate park</div>
                                    </div>
                                </div>
                                <div id="locationCheck" class="hidden">
                                    <div class="text-sm">
                                        登録されていない場所になりますので、マップ上でピンの位置を確認してください。
                                        <br>
                                        ピンの位置が正しくない場合は、ドラッグして移動してください。
                                    </div>
                                </div>
                                <div id="map" class="w-[30rem] max-w-[100%] h-[30rem] max-h-[100%] rounded-lg">

                                </div>
                            </div>
                            <x-input-label class="w-full text-left">コメント</x-input-label>
                            <x-text-input id="comment" name="comment" class="w-full" placeholder="コメント" />
                        </div>
                        <button id="submit" name="submit" type="button" class="text-2xl px-4 py-2 bg-green-100 text-green-500 border border-green-500 rounded-lg mt-4">登録する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <div class="hidden text-red-600 space-y-1"></div>
    <script>
        window.Laravel = {};
        window.Laravel.shop_id = @json($id);
        window.Laravel.setup_lists = @json($setup_lists);
        window.Laravel.event_lists = @json($event_lists);
        window.Laravel.favorite_lists = @json($favorite_lists);
        window.Laravel.places = @json($places);
        window.Laravel.setup_id = 0;
        window.Laravel.location = {};
        window.Laravel.location.lat = null;
        window.Laravel.location.lng = null;
        console.log(Laravel);
    </script>
    @vite(['resources/js/shop/shop-setup.js'])
</x-template>
