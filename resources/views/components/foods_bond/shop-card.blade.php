<p class="text-xl text-gray-400">{{ $targetDate }}</p>
<div class="flex flex-col justify-center items-center mt-2">
    <p class="text-2xl font-bold">{{ $data->shop_name }}</p>
    <p class="text-sm">{{ $appeal }}</p>
    <img src="{{ asset('storage/shop/'.$data->shop_img) }}" alt="{{ $data->shop_name }}" class="w-40 h-40 object-cover border border-gray-400 rounded-l">
    <a href="https://www.instagram.com/{{ $data->instagram }}" class="text-sm bg-pink-100 text-pink-800 font-medium px-2.5 py-0.5 rounded border border-pink-400 my-2">
        <i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram
    </a>
    <a href="{{ route('shop', $data->id) }}" class="text-sm bg-yellow-100 text-yellow-800 font-medium px-2.5 py-0.5 rounded border border-yellow-300 mb-2">
        <i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ
    </a>
</div>
