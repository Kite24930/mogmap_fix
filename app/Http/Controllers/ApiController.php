<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Costomer;
use App\Models\Follow;
use App\Models\FollowList;
use App\Models\ShopList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function accountVerification(Request $request) {
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
        $customer = Costomer::where('user_id', hash('sha256', $account->solt.$request->uid))->first();
        $data = [
            'status' => 'ok',
            'user_name' => $customer->user_name,
        ];
        if ($account->status == 3) {
            $shops = ShopList::where('shop_id', $customer->user_id)->get();
            $data['shops'] = $shops;
        }
        return response()->json($data);
    }

    public function followedGet(Request $request) {
        $account = Account::where('uid', hash('sha256', $request->uid))->first();
        $customer = Costomer::where('user_id', hash('sha256', $account->solt.$request->uid))->first();
        $followed = FollowList::where('user_id', $customer->user_id);
        $data = [
            'status' => 'ok',
            'followed' => $followed->orderBy('id', 'desc')->get(),
            'follow_shop_id' => $followed->pluck('shop_id')->toArray(),
        ];
        return response()->json($data);
    }

    public function followCheck(Request $request) {
        $account = Account::where('uid', hash('sha256', $request->user_id))->first();
        $follow = Follow::where('user_id', hash('sha256', $account->solt.$request->user_id))->where('shop_id', $request->shop_id)->first();
        if ($follow == null) {
            $data['status'] = 'unfollowing';
        } else {
            $data['status'] = 'following';
        }
        return response()->json($data);
    }

    public function follow(Request $request) {
        $account = Account::where('uid', hash('sha256', $request->user_id))->first();
        try {
            DB::beginTransaction();
            switch ($request->type) {
                case 'following':
                    Follow::create([
                        'user_id' => hash('sha256', $account->solt.$request->user_id),
                        'shop_id' => $request->shop_id,
                    ]);
                    $data['status'] = 'following';
                    break;
                case 'unfollowing':
                    $followed = Follow::where('user_id', hash('sha256', $account->solt.$request->user_id))->where('shop_id', $request->shop_id)->first();
                    $followed->delete();
                    $data['status'] = 'unfollowing';
                    break;
            }
            DB::commit();
            $data['msg'] = 'ok';
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => 'ng',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function accountName(Request $request) {
        try {
            DB::beginTransaction();
            $account = Account::where('uid', hash('sha256', $request->user_id))->first();
            $customer = Costomer::where('user_id', hash('sha256', $account->solt.$request->user_id))->first();
            $customer->update([
                'user_name' => $request->user_name,
            ]);
            DB::commit();
            return response()->json([
                'msg' => 'ok',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => 'ng',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
