<div {{ $attributes->merge(["class" => "bg-pink-50 text-pink-500 font-medium px-2.5 py-0.5 border border-pink-300 rounded follow load cursor-pointer w-44 h-8 text-center"]) }} data-target="{{ $id }}">
{{--    <i class="bi bi-heart-arrow text-pink-500 mr-1"></i><i class="bi bi-heart-fill text-pink-500 mr-2"></i>フォローする--}}
    <div class="spin-load-wrapper w-full h-full flex justify-center items-center">
        <div class="spin-load text-pink-500"></div>
    </div>
</div>
