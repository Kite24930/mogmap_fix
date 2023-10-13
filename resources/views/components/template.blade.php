<!DOCTYPE html>
<html lang="ja">
<x-head :title="$title">
    @if(isset($description))
        <meta name="description" content="{{ $description }}"/>
    @endif
    @if(isset($keyword))
        <meta name="keyword" content="{{ $keyword }}"/>
    @endif
    @vite(['resources/css/'.$css])
</x-head>
<body>
<x-header></x-header>
{{ $slot }}
<x-footer></x-footer>
</body>
</html>
