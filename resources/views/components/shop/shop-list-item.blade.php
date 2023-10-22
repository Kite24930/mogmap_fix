<div class="swiper-slide w-full max-w-xs md:max-w-md p-6 rounded-lg border border-cyan-400 bg-white">
    <div class="flex flex-col justify-center items-center">
        <p class="text-2xl font-bold mb-2">{{ $data->shop_name }}</p>
        <p class="text-xl mb-2">【{{ $data->genre_name }}】</p>
        <div class="img-container relative">
            <img src="{{ asset('storage/shop/'.$data->shop_img) }}" alt="{{ $data->shop_name }}" class="w-full h-full absolute top-0 left-0 rounded-lg border border-gray-400">
        </div>
        <x-instagram-item :instagram="$data->instagram" class="text-xl" />
        <x-shop-page-item :id="$data->id" class="text-xl" />
        <x-follow-item :id="$data->id" class="" />
    </div>
</div>
