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
                <form action="{{ route('shop.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $id }}">
                    <x-input-label><x-required />ショップ名</x-input-label>
                    @if(isset($shop->shop_name))
                        <x-text-input id="shop_name" name="shop_name" class="w-full max-w-md" value="{{ $shop->shop_name }}" />
                    @else
                        <x-text-input id="shop_name" name="shop_name" class="w-full max-w-md" value="" />
                    @endif
                    <x-input-error :messages="$errors->get('shop_name')" class="my-2" />
                    <x-input-label class="mt-4"><x-required />ジャンル</x-input-label>
                    <x-select-input id="genre_id" name="genre_id" class="w-full max-w-md">
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" @if(isset($shop->genre_id)) @if($genre->id === $shop->genre_id) selected @endif @endif>{{ $genre->genre_name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-text-input id="new_genre" name="new_genre" class="hidden w-full max-w-md" />
                    <x-input-error :messages="$errors->get('genre_id')" class="my-2" />
                    <x-input-label class="mt-4"><x-required />予約の可否</x-input-label>
                    @if(isset($shop->reserve))
                        <x-text-input id="reserve" name="reserve" class="w-full max-w-md" value="{{ $shop->reserve }}" placeholder="例：前日までにInstagramのDMより/予約不可、等" />
                    @else
                        <x-text-input id="reserve" name="reserve" class="w-full max-w-md" placeholder="例：前日までにInstagramのDMより/予約不可、等" />
                    @endif
                    <x-input-error :messages="$errors->get('reserve')" class="my-2" />
                    <x-input-label class="mt-4"><x-required />営業許可エリア</x-input-label>
                    <div class="border border-gray-300 rounded-md shadow-sm w-full max-w-md flex flex-wrap max-h-60 overflow-auto">
                        @foreach($prefectures as $prefecture)
                            <label class="my-1 mx-2">
                                @if(isset($shop->area) && str_contains($shop->area, $prefecture))
                                    <x-text-input type="checkbox" class="prefecture" value="{{ $prefecture }}" checked />
                                @else
                                    <x-text-input type="checkbox" class="prefecture" value="{{ $prefecture }}" />
                                @endif
                                {{ $prefecture }}
                            </label>
                        @endforeach
                    </div>
                    @if(isset($shop->area))
                        <input type="hidden" id="area" name="area" value="{{ $shop->area }}">
                    @else
                        <input type="hidden" id="area" name="area" value="">
                    @endif
                    <x-input-error :messages="$errors->get('area')" class="my-2" />
                    <x-input-label class="mt-4"><x-required />Instagram</x-input-label>
                    @if(isset($shop->instagram))
                        <x-text-input id="instagram" name="instagram" class="w-full max-w-md" value="{{ $shop->instagram }}" placeholder="URLではなく、IDのみ入力してください。" />
                    @else
                        <x-text-input id="instagram" name="instagram" class="w-full max-w-md" placeholder="URLではなく、IDのみ入力してください。" />
                    @endif
                    <x-input-error :messages="$errors->get('instagram')" class="my-2" />
                    <x-input-label class="mt-4"><x-any />Twitter</x-input-label>
                    @if(isset($shop->twitter))
                        <x-text-input id="twitter" name="twitter" class="w-full max-w-md" value="{{ $shop->twitter }}" placeholder="URLではなく、IDのみ入力してください。" />
                    @else
                        <x-text-input id="twitter" name="twitter" class="w-full max-w-md" placeholder="URLではなく、IDのみ入力してください。" />
                    @endif
                    <x-input-error :messages="$errors->get('twitter')" class="my-2" />
                    <x-input-label class="mt-4"><x-any />Facebook</x-input-label>
                    @if(isset($shop->facebook))
                        <x-text-input id="facebook" name="facebook" class="w-full max-w-md" value="{{ $shop->facebook }}" placeholder="URLではなく、IDのみ入力してください。" />
                    @else
                        <x-text-input id="facebook" name="facebook" class="w-full max-w-md" placeholder="URLではなく、IDのみ入力してください。" />
                    @endif
                    <x-input-error :messages="$errors->get('facebook')" class="my-2" />
                    <x-input-label class="mt-4"><x-required />TOP画像</x-input-label>
                    <x-text-input id="shop_img" name="shop_img" class="w-full max-w-md" type="file" accept="image/jpeg,image/png,image/gif" />
                    <div class="square w-full max-w-md mt-4">
                        @if(isset($shop->shop_img))
                            <img id="shop_img_preview" src="{{ asset('storage/shop/'.$shop->shop_img) }}" alt="" class="rounded-lg">
                        @else
                            <img id="shop_img_preview" src="https://placehold.jp/3d4070/ffffff/600x600.png?text=%E6%9C%AA%E8%A8%AD%E5%AE%9A" alt="" class="rounded-lg">
                        @endif
                    </div>
                    <x-input-error :messages="$errors->get('shop_img')" class="my-2" />
                    <div class="w-full flex flex-col md:flex-row justify-center items-center gap-4">
                        <div class="border border-gray-300 rounded-md p-4 mt-4">
                            <h3 class="text-lg font-semibold">PR①</h3>
                            <x-input-label class="mt-4">画像</x-input-label>
                            <x-text-input id="pr_img_1" name="pr_img_1" class="w-full max-w-sm mb-1" type="file" accept="image/jpeg,image/png,image/gif" />
                            <div class="img-container w-full max-w-sm">
                                @if(isset($shop->pr_img_1))
                                    <img id="pr_img_1_preview" src="{{ asset('storage/shop/'.$shop->pr_img_1) }}" alt="" class="rounded-lg">
                                @else
                                    <img id="pr_img_1_preview" src="https://placehold.jp/3d4070/ffffff/400x300.png?text=%E6%9C%AA%E8%A8%AD%E5%AE%9A" alt="" class="rounded-lg">
                                @endif
                            </div>
                            <x-input-error :messages="$errors->get('pr_img_1')" class="my-2" />
                            <x-input-label class="mt-4">PR文</x-input-label>
                            <x-textarea-input id="pr_txt_1" name="pr_txt_1" class="w-full max-w-sm" rows="8">@if(isset($shop->pr_txt_1)){{ $shop->pr_txt_1 }} @endif</x-textarea-input>
                            <x-input-error :messages="$errors->get('pr_txt_1')" class="my-2" />
                        </div>
                        <div class="border border-gray-300 rounded-md p-4 mt-4">
                            <h3 class="text-lg font-semibold">PR②</h3>
                            <x-input-label class="mt-4">画像</x-input-label>
                            <x-text-input id="pr_img_2" name="pr_img_2" class="w-full max-w-sm mb-1" type="file" accept="image/jpeg,image/png,image/gif" />
                            <div class="img-container w-full max-w-sm">
                                @if(isset($shop->pr_img_2))
                                    <img id="pr_img_2_preview" src="{{ asset('storage/shop/'.$shop->pr_img_2) }}" alt="" class="rounded-lg">
                                @else
                                    <img id="pr_img_2_preview" src="https://placehold.jp/3d4070/ffffff/400x300.png?text=%E6%9C%AA%E8%A8%AD%E5%AE%9A" alt="" class="rounded-lg">
                                @endif
                            </div>
                            <x-input-error :messages="$errors->get('pr_img_2')" class="my-2" />
                            <x-input-label class="mt-4">PR文</x-input-label>
                            <x-textarea-input id="pr_txt_2" name="pr_txt_2" class="w-full max-w-sm" rows="8">@if(isset($shop->pr_txt_2)){{ $shop->pr_txt_2 }} @endif</x-textarea-input>
                            <x-input-error :messages="$errors->get('pr_txt_2')" class="my-2" />
                        </div>
                        <div class="border border-gray-300 rounded-md p-4 mt-4">
                            <h3 class="text-lg font-semibold">PR③</h3>
                            <x-input-label class="mt-4">画像</x-input-label>
                            <x-text-input id="pr_img_3" name="pr_img_3" class="w-full max-w-sm mb-1" type="file" accept="image/jpeg,image/png,image/gif" />
                            <div class="img-container w-full max-w-sm">
                                @if(isset($shop->pr_img_3))
                                    <img id="pr_img_3_preview" src="{{ asset('storage/shop/'.$shop->pr_img_3) }}" alt="" class="rounded-lg">
                                @else
                                    <img id="pr_img_3_preview" src="https://placehold.jp/3d4070/ffffff/400x300.png?text=%E6%9C%AA%E8%A8%AD%E5%AE%9A" alt="" class="rounded-lg">
                                @endif
                            </div>
                            <x-input-error :messages="$errors->get('pr_img_3')" class="my-2" />
                            <x-input-label class="mt-4">PR文</x-input-label>
                            <x-textarea-input id="pr_txt_3" name="pr_txt_3" class="w-full max-w-sm" rows="8">@if(isset($shop->pr_txt_3)){{ $shop->pr_txt_3 }} @endif</x-textarea-input>
                            <x-input-error :messages="$errors->get('pr_txt_3')" class="my-2" />
                        </div>
                    </div>
                    <button id="submit" name="submit" class="fixed bottom-4 md:bottom-auto md:top-16 right-4 md:right-16 text-2xl px-4 py-2 bg-green-100 text-green-500 border border-green-500 rounded-lg ">保存する</button>
                </form>
            </div>
        </div>
    </main>
    <div class="hidden text-red-600 space-y-1"></div>
    <script>
        window.Laravel = {};
        window.Laravel.shop = @json($shop);
        console.log(Laravel.shop);
    </script>
    @vite(['resources/js/shop/shop-edit.js'])
</x-template>
