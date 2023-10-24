<footer class="w-full md:pl-[240px] pt-3 pb-6 border-t border-gray-700">
    <div class="w-full flex flex-col justify-center items-center">
        <div class="w-full flex flex-col md:flex-row justify-center items-center md:justify-between px-4 pb-6 md:pb-0 gap-6">
            <a href="https://www.mie-projectm.com" class="flex items-center">
                <img src="{{ asset('storage/data/projectm_logo.png') }}" alt="Project M, Inc." class="w-12 h-12 object-contain">
                株式会社プロジェクトM
            </a>
            <div>
                <ul class="flex flex-wrap flex-col md:flex-row items-center gap-6">
                    <li>
                        <a href="{{ route('terms') }}">利用規約</a>
                    </li>
                    <li>
                        <a href="{{ route('policy') }}">プライバシーポリシー</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">お問い合わせ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ja-display-font">
            &copy; 2022-{{ date('Y') }} Project M, Inc. All Rights Reserved.
        </div>
    </div>
</footer>
