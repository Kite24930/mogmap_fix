<x-template title="Food's Bond 〜食がつなぐキズナ〜" css="foods_bond.css">
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
    <main class="flex flex-col justify-center items-start pt-20 md:pt-0 md:pl-[240px] min-h-[100dvh] @switch(date('m')) @case(1)winter @break @case(2)winter @break @case(3)spring @break @case(4)spring @break @case(5)spring @break @case(6)summer @break @case(7)summer @break @case(8)summer @break @case(9)autumn @break @case(10)autumn @break @case(11)autumn @break @case(12)winter @break @endswitch">
        <div class="flex flex-col md:flex-row justify-center items-center p-4">
            <img src="{{ asset('storage/foods_bond/logo.png') }}" alt="Food's Bond" class="w-full md:w-1/2 rounded-lg">
            <div class="w-full md:w-1/2 p-4">
                <div class="w-full bg-white p-4 rounded-lg">
                    <p class="text-lg">三重大学 キッチンカー企画</p>
                    <p class="text-xl font-bold">Food's Bond 〜食がつなぐキズナ〜</p>
                    <p>2022年後期から始まった三重大学 キッチンカー企画！</p>
                    <p>2024年も引き続き開催！毎月第2週火曜日・木曜日に教職支援センター前と三翠ホール前にキッチンカーがやってくる！！！</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col w-full justify-center items-center p-4 gap-6">
            <div id="October" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">October</p>
                <hr>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="w-full md:w-1/2 p-4">
                        <img src="{{ asset('storage/foods_bond/October.png') }}" alt="October" class="w-full rounded-lg">
                        <p class="text-xs text-gray-400 md:hidden">長押しすると画像を保存できます</p>
                    </div>
                    <div class="flex flex-col justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(20)" targetDate="10/3(Tue)" appeal="ホットドッグ🌭" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(16)" targetDate="10/5(Thu)" appeal="大豆ミートからあげ🍗" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(22)" targetDate="10/17(Tue)" appeal="ブルドポークサンド🥪&米粉チュロス" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(19)" targetDate="10/19(Thu)" appeal="カラフルだんご🍡" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(17)" targetDate="10/31(Tue)" appeal="きゅうりタコス🥒" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="Nano." shopImg="nano.JPG" instagram="n.ano_cafe_kc" targetDate="10/3(Tue)" appeal="からあげ🍗&ソフトクリーム🍦" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="honey hug" shopImg="honey_hug.png" instagram="honey_hug.566" targetDate="10/5(Thu)" appeal="くまさんパフェ🍨" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(18)" targetDate="10/17(Tue)" appeal="花束みたいなクレープ💐" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(53)" targetDate="10/19(Thu)" appeal="はちみつカステラ🍯" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(35)" targetDate="10/31(Tue)" appeal="キューバサンド🥪" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="November" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">November</p>
                <hr>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="w-full md:w-1/2 p-4">
                        <img src="{{ asset('storage/foods_bond/November.png') }}" alt="October" class="w-full rounded-lg">
                        <p class="text-xs text-gray-400 md:hidden">長押しすると画像を保存できます</p>
                    </div>
                    <div class="flex flex-col justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(36)" targetDate="11/2(Thu)" appeal="クレープ🐈" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(9)" targetDate="11/14(Tue)" appeal="佐世保バーガー🍔" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(21)" targetDate="11/16(Thu)" appeal="ピタパンアイス🍨" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="クラッフェ" shopImg="kuraffe.JPG" instagram="kitchenkuraffe" targetDate="11/28(Tue)" appeal="だし巻きバーガー🥚" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(45)" targetDate="11/30(Thu)" appeal="ロコモコ&りんご飴🍎" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="小春や" shopImg="koharuya.JPG" instagram="ko_ha_ru_ya" targetDate="11/2(Thu)" appeal="わらび餅🍡" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(11)" targetDate="11/14(Tue)" appeal="キーマカレー🍛" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="次男の焼きおにぎり" shopImg="tsugio.JPG" instagram="tsugio_no_yakionigiri" targetDate="11/16(Thu)" appeal="焼きおにぎり🍙" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="Lansen" shopImg="lansen.jpg" instagram="kitchenbus.lansen" targetDate="11/28(Tue)" appeal="ハンバーガー🍔" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(14)" targetDate="11/30(Thu)" appeal="コロッケ🥔" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="December" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">December</p>
                <hr>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="w-full md:w-1/2 p-4">
                        <img src="{{ asset('storage/foods_bond/December.png') }}" alt="October" class="w-full rounded-lg">
                        <p class="text-xs text-gray-400 md:hidden">長押しすると画像を保存できます</p>
                    </div>
                    <div class="flex flex-col justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(21)" targetDate="12/12(Tue)" appeal="ピタパンアイス🍨" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(17)" targetDate="12/14(Thu)" appeal="きゅうりタコス🥒" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="petit kitchen" shopImg="petit_kitchen.JPG" instagram="petit.kitchen_" targetDate="12/12(Tue)" appeal="牛すじ煮込み🐮" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(38)" targetDate="12/14(Thu)" appeal="ピッツァ🍕" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="January" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">January</p>
                <p class="text-lg">1月で今年度のキッチンカー企画は終了となります！今年度もたくさんのご来場ありがとうございました！</p>
                <hr>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="w-full md:w-1/2 p-4">
                        <img src="{{ asset('storage/foods_bond/January.png') }}" alt="October" class="w-full rounded-lg">
                        <p class="text-xs text-gray-400 md:hidden">長押しすると画像を保存できます</p>
                    </div>
                    <div class="flex flex-col justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(31)" targetDate="1/23(Tue)" appeal="ソフトクリーム🍦" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(9)" targetDate="1/25(Thu)" appeal="佐世保バーガー🍔" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(18)" targetDate="1/23(Tue)" appeal="クレープ💐" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(53)" targetDate="1/25(Thu)" appeal="はちみつカステラ🍯" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="April" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">April</p>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="flex flex-col md:flex-row justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(36)" targetDate="4/16(Tue)" appeal="クレープ🐈" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="小春や" shopImg="koharuya.JPG" instagram="ko_ha_ru_ya" targetDate="4/18(Thu)" appeal="わらび餅🍡" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(34)" targetDate="4/16(Tue)" appeal="キンパ🇰🇷" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="朱さん" shopImg="shusan.jpeg" instagram="red_foodtruck_shu" targetDate="4/18(Thu)" appeal="中国家庭料理🇨🇳" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="May" class="hidden flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">May</p>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="flex flex-col md:flex-row justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="honey hug" shopImg="honey_hug.png" instagram="honey_hug.566" targetDate="5/7(Tue)" appeal="くまさんパフェ🍨" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(14)" targetDate="5/9(Thu)" appeal="コロッケ🥔" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="明家キンパ" shopImg="myonga_kimpa.jpg" instagram="m.k_kimbap" targetDate="5/7(Tue)" appeal="韓国料理🇰🇷" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(45)" targetDate="5/9(Thu)" appeal="ロコモコ&りんご飴🍎" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="June" class="flex flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">June</p>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="flex flex-col md:flex-row justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="クラッフェ" shopImg="kuraffe.JPG" instagram="kitchenkuraffe" targetDate="6/4(Tue)" appeal="だし巻きバーガー🥚" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(21)" targetDate="6/6(Thu)" appeal="ピタパンアイス🍨" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="Nano." shopImg="nano.JPG" instagram="n.ano_cafe_kc" targetDate="6/4(Tue)" appeal="からあげ🍗&ソフトクリーム🍦" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(35)" targetDate="6/6(Thu)" appeal="キューバサンド🥪" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="July" class="flex flex-col w-full justify-center items-center bg-white rounded-lg border border-blue-900">
                <p class="text-6xl font-bold ja-display-font">July</p>
                <div class="flex flex-col md:flex-row w-full justify-evenly items-center p-0 md:p-4">
                    <div class="flex flex-col md:flex-row justify-center items-center max-w-full md:max-w-[50%] p-4 gap-4">
                        <div class="edu-center flex flex-col items-center p-4 bg-pink-200 border border-pink-400 rounded-lg w-full">
                            <p class="text-xl font-bold mb-2">教職支援センター前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="Nageia" shopImg="nageia.jpeg" instagram="nageia_trailer" targetDate="7/9(Tue)" appeal="モンブランソフト" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="クッピーラムネカフェ" shopImg="kuppyramune.jpeg" instagram="kuppyramune.cafe" targetDate="7/11(Thu)" appeal="クッピーラムネ🥤" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="sansui-hole flex flex-col items-center w-full p-4 bg-green-200 border border-green-400 rounded-lg">
                            <p class="text-2xl font-bold mb-2">三翠ホール前</p>
                            <div class="swiper flipSwiper max-w-full md:max-w-[350px]">
                                <div class="swiper-wrapper w-full">
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.visiter-card shopName="Lbe" shopImg="Lbe.jpg" instagram="lbe_397" targetDate="7/9(Tue)" appeal="ホットドッグ🌭" />
                                    </div>
                                    <div class="swiper-slide p-4 bg-white rounded-lg border border-blue-900">
                                        <x-foods_bond.shop-card :data="$shop_lists->find(17)" targetDate="7/11(Thu)" appeal="きゅうりタコス🥒" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @vite(['resources/js/foods_bond.js'])
</x-template>
