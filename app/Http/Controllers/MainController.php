<?php

namespace App\Http\Controllers;

use App\Models\EventList;
use App\Models\Menu;
use App\Models\SameList;
use App\Models\SetUpList;
use App\Models\ShopList;
use Illuminate\Http\Request;

class MainController extends Controller
{
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
