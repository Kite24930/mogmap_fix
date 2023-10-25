<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Costomer;
use App\Models\ShopList;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function accountVerification(Request $request) {
        $account = Account::where('uid', hash('sha256', $request->uid))->first();
        if ($account == null) {
            $account = Account::create([
                'uid' => hash('sha256', $request->uid),
                'solt' => bin2hex(random_bytes(5)),
                'status' => 1
            ]);
            return response()->json([
                'status' => 'new',
            ]);
        }
        $costomer = Costomer::where('user_id', hash('sha256', $account->solt.$request->uid))->first();
        $data = [
            'status' => 'ok',
            'user_name' => $costomer->user_name,
        ];
        if ($account->status == 3) {
            $shops = ShopList::where('shop_id', $costomer->user_id)->get();
            $data['shops'] = $shops;
        }
        return response()->json($data);
    }
}
