<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>mogmap リニューアルのお知らせ</title>
    @vite(['resources/css/welcome.css'])
</head>
<body>
<main class="w-[100dvw] h-[100dvh] flex flex-col justify-center items-center">
    <img src="{{ asset('storage/data/logoText.png') }}" alt="mogmap" class="max-w-[550px] p-4 w-full">
    <div id="container" class="p-4 m-4 max-w-[600px] rounded-lg">
        <h1 class="md:text-3xl text-2xl font-bold underline">mogmapからのお知らせ</h1>
        <div class="p-4">
            <p>日頃より、mogmapをご利用いただきありがとうございます。</p>
            <p>10/12(木)に発生致しましたmogmapサーバーに対して、サイバー攻撃が行われました。</p>
            <p>この事態を受け、mogmapチームとして、セキュリティ面の強化も含め、現システムを廃止し、新システムへの移行を行う運びとなりました。</p>
            <p>ご利用いただいております皆様には大変ご迷惑をおかけいたしまして、誠に申し訳ありません。</p>
            <p>新システム開発には少なくとも数週間かかる見込みとなっております。</p>
        </div>
    </div>
</main>
    @vite(['resources/js/welcome.js'])
</body>
</html>
