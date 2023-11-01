<?php

namespace App\Http\Controllers;

use App\Models\EventList;
use App\Models\FavoriteList;
use App\Models\Genre;
use App\Models\Menu;
use App\Models\Place;
use App\Models\SameList;
use App\Models\SetUpList;
use App\Models\Shop;
use App\Models\ShopList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class MainController extends Controller
{
    public $prefectures = [
        '北海道',
        '青森県',
        '岩手県',
        '宮城県',
        '秋田県',
        '山形県',
        '福島県',
        '茨城県',
        '栃木県',
        '群馬県',
        '埼玉県',
        '千葉県',
        '東京都',
        '神奈川県',
        '新潟県',
        '富山県',
        '石川県',
        '福井県',
        '山梨県',
        '長野県',
        '岐阜県',
        '静岡県',
        '愛知県',
        '三重県',
        '滋賀県',
        '京都府',
        '大阪府',
        '兵庫県',
        '奈良県',
        '和歌山県',
        '鳥取県',
        '島根県',
        '岡山県',
        '広島県',
        '山口県',
        '徳島県',
        '香川県',
        '愛媛県',
        '高知県',
        '福岡県',
        '佐賀県',
        '長崎県',
        '熊本県',
        '大分県',
        '宮崎県',
        '鹿児島県',
        '沖縄県',
    ];

    public function index(Request $request)
    {
        $data = [
            'set_ups' => SetUpList::whereDate('date', '>=', date('Y-m-d'))->orderBy('date')->get(),
            'events' => EventList::whereDate('event_date', '>=', date('Y-m-d'))->orderBy('event_date')->get(),
            'same_lists' => SameList::whereDate('date', '>=', date('Y-m-d'))->where('count', '>', 1)->orderBy('date')->get()
        ];
        if ($request->has('date')) {
            $data['date'] = $request->date;
        } else {
            $data['date'] = date('Y-m-d');
        }
        return view('index', $data);
    }

    public function foods_bond()
    {
        $data = [
            'shop_lists' => ShopList::all(),
        ];
        return view('foods_bond.foods_bond', $data);
    }

    public function shop_list()
    {
        $data = [
            'shop_lists' => ShopList::where('status', 1)->get(),
        ];
        return view('shop.shop-list', $data);
    }

    public function shop($id)
    {
        $data = [
            'shop' => ShopList::find($id),
            'menus' => Menu::where('shop_id', $id)->get(),
            'schedules' => SetUpList::where('shop_id', $id)->whereDate('date', '>=', date('Y-m-d'))->orderBy('date')->get(),
        ];
        return view('shop.shop', $data);
    }

    public function mypage() {
        $data = [
            'csrf_token' => csrf_token(),
        ];
        return view('account.mypage', $data);
    }

    public function account_edit() {
        $data = [
            'csrf_token' => csrf_token(),
        ];
        return view('account.account-edit', $data);
    }

    public function followed() {
        $data = [
            'csrf_token' => csrf_token(),
        ];
        return view('account.followed', $data);
    }

    public function shop_edit(Request $request, $id) {
        $data = [
            'id' => $id,
            'shop' => ShopList::find($id),
            'menus' => Menu::where('shop_id', $id)->orderBy('menu_id')->get(),
            'genres' => Genre::all(),
            'prefectures' => $this->prefectures,
            'csrf_token' => csrf_token(),
        ];
        if ($request->session()->has('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        if ($request->session()->has('error')) {
            $data['error'] = $request->session()->get('error');
            $request->session()->forget('error');
        }
        return view('shop.shop-edit', $data);
    }

    public function shop_update(Request $request) {
        $shop = Shop::find($request->id);
        $shop_img_validation = 'required|file|mimes:jpeg,png,jpg,gif';
        if ($shop->shop_img !== null) {
            $shop_img_validation = 'nullable|file|mimes:jpeg,png,jpg,gif';
        }
        $request->validate([
            'id' => 'required',
            'shop_name' => 'required',
            'genre_id' => 'required',
            'area' => 'required',
            'reserve' => 'required',
            'instagram' => 'required',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'shop_img' => $shop_img_validation,
            'pr_img_1' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'pr_img_2' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'pr_img_3' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'pr_txt_1' => 'nullable',
            'pr_txt_2' => 'nullable',
            'pr_txt_3' => 'nullable',
        ],
        [
            'id.required' => '不正なアクセスです',
            'shop_name.required' => '店舗名を入力してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'area.required' => 'エリアを選択してください',
            'reserve.required' => '予約方法を選択してください',
            'instagram.required' => 'Instagramを入力してください',
            'shop_img.required' => '店舗画像を選択してください',
            'shop_img.mimes' => '店舗画像はjpeg,png,jpg,gifのいずれかの形式でアップロードしてください',
            'pr_img_1.mimes' => 'PR画像1はjpeg,png,jpg,gifのいずれかの形式でアップロードしてください',
            'pr_img_2.mimes' => 'PR画像2はjpeg,png,jpg,gifのいずれかの形式でアップロードしてください',
            'pr_img_3.mimes' => 'PR画像3はjpeg,png,jpg,gifのいずれかの形式でアップロードしてください',
        ]);
        function img_save($file, $column, $shop_id, $shop_hash_id, $shop_num, $index, $width = 800) {
            $saveFile = InterventionImage::make($file);
            $saveFile->encode('jpg');
            $saveFile->orientate();
            $saveFile->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $fileName = $shop_hash_id.'-00'.$shop_num.'-'.$index.'.jpg';
            $filePath = storage_path('app/public/shop/'.$fileName);
            $saveFile->save($filePath);
            $targetFile = InterventionImage::make($filePath);
            $limitSize = 200000;
            if ($targetFile->filesize() > $limitSize) {
                img_save($file, $column, $shop_id, $shop_hash_id, $shop_num, $index, $width - 100);
            }
            $target = Shop::find($shop_id);
            if ($target !== null) {
                if ($target->$column !== null) {
                    if (Storage::disk('public')->exists('shop/'.$target->$column) && $target->$column !== $fileName) {
                        Storage::disk('public')->delete('shop/'.$target->$column);
                    }
                }
            }
            return $fileName;
        }

        $files = [
            'shop_img',
            'pr_img_1',
            'pr_img_2',
            'pr_img_3',
        ];
        $insertData = [
            'shop_name' => $request->shop_name,
            'genre_id' => $request->genre_id,
            'reserve' => $request->reserve,
            'area' => $request->area,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'pr_txt_1' => $request->pr_txt_1,
            'pr_txt_2' => $request->pr_txt_2,
            'pr_txt_3' => $request->pr_txt_3,
        ];
        try {
            DB::beginTransaction();
            $fileName = [
                'shop_img' => null,
                'pr_img_1' => null,
                'pr_img_2' => null,
                'pr_img_3' => null,
            ];
            $shop_hash_id = $shop->shop_hash_id;
            $shop_num = $shop->shop_num;
            foreach ($files as $index => $file) {
                if ($request->file($file) !== null) {
                    $fileName[$file] = img_save($request->file($file), $file, $request->id, $shop_hash_id, $shop_num, $index);
                } else {
                    $fileName[$file] = $shop->$file;
                }
            }
            $insertData['shop_img'] = $fileName['shop_img'];
            $insertData['pr_img_1'] = $fileName['pr_img_1'];
            $insertData['pr_img_2'] = $fileName['pr_img_2'];
            $insertData['pr_img_3'] = $fileName['pr_img_3'];
            Shop::updateOrCreate(['id' => $request->id], $insertData);
            Menu::where('shop_id', $request->id)->delete();
            for ($i = 0; $i < $request->menu_count + 1; $i++) {
                if ($request->{'menu_'.$i} !== null) {
                    Menu::create([
                        'shop_id' => $request->id,
                        'menu_id' => $i,
                        'menu_name' => $request->{'menu_'.$i},
                        'menu_price' => $request->{'price_'.$i},
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('shop.edit', ['id' => $request->id])->with('success', '店舗情報を更新しました');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '店舗情報の更新に失敗しました|'.$e->getMessage());
        }
    }

    public function shop_setup($id, Request $request) {
        $data = [
            'id' => $id,
            'setup_lists' => SetUpList::where('shop_id', $id)->whereDate('date', '>=', date('Y-m-d'))->orderBy('date')->get(),
            'event_lists' => EventList::whereDate('event_date', '>=', date('Y-m-d'))->orderBy('event_date')->get(),
            'favorite_lists' => FavoriteList::where('shop_id', $id)->get(),
            'places' => Place::where('status', 1)->get(),
            'csrf_token' => csrf_token(),
        ];
        if ($request->session()->has('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        if ($request->session()->has('error')) {
            $data['error'] = $request->session()->get('error');
            $request->session()->forget('error');
        }
        return view('shop.shop-setup', $data);
    }

    public function register()
    {
        return view('firebase.register');
    }

    public function terms() {
        return view('footer.terms');
    }

    public function policy() {
        return view('footer.policy');
    }

    public function contact() {
        return view('footer.contact');
    }
}
