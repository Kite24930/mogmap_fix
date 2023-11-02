<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Costomer;
use App\Models\Event;
use App\Models\Follow;
use App\Models\FollowList;
use App\Models\Information;
use App\Models\Place;
use App\Models\SetUp;
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
        if (isset($customer)) {
            $data = [
                'status' => 'ok',
                'user_name' => $customer->user_name,
            ];
            if ($account->status == 3) {
                $shops = ShopList::where('shop_id', $customer->user_id);
                $data['shops'] = $shops->get();
                $data['shop_id'] = $shops->pluck('id')->toArray();
            }
        } else {
            $data = [
                'status' => 'new',
            ];
        }
        if ($customer->user_id == '005de4d18b61fe36e14693cf32e923c8c96d61d3fa4a14019e250d671a9b94ce') {
            $data['admin'] = true;
            $data['information'] = Information::all();
        }
        return response()->json($data);
    }

    public function userNameUpdate(Request $request) {
        try {
            $account = Account::where('uid', hash('sha256', $request->uid))->first();
            $customer = Costomer::updateOrCreate(
                [
                    'user_id' => hash('sha256', $account->solt.$request->uid),
                ],
                [
                    'user_name' => $request->user_name,
                ]);
            return response()->json([
                'status' => 'ok',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ng',
                'error' => $e->getMessage(),
            ]);
        }
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

    public function setup_register(Request $request) {
        $request->validate([
            'shop_id' => 'required',
            'date' => 'required',
            'place_id' => 'required',
            'event_id' => 'nullable',
        ],
            [
            'shop_id.required' => '店舗IDがありません',
            'date.required' => '日付がありません',
            'place_id.required' => '場所がありません',
        ]);

        try {
            DB::beginTransaction();
            if ($request->place_id === 0) {
                $place_id = Place::create([
                    'place_name' => $request->place_name,
                    'address' => $request->address,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'status' => 1,
                ])->id;
            } else {
                $place_id = $request->place_id;
            }
            if ($request->event_id === -1) {
                $event_id = Event::create([
                    'event_name' => $request->event_name,
                    'event_date' => $request->date[0],
                    'event_place_num' => $place_id,
                ])->id;
            } else {
                $event_id = $request->event_id;
            }
            $results = [];
            if (isset($request->setup_id)) {
                foreach ($request->date as $date) {
                    $results[] = SetUp::find($request->setup_id)->update([
                        'shop_id' => $request->shop_id,
                        'date' => $date,
                        'place_id' => $place_id,
                        'event_id' => $event_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'comment' => $request->comment,
                        'status' => 1,
                    ]);
                }
            } else {
                foreach ($request->date as $date) {
                    $results[] = SetUp::create([
                        'shop_id' => $request->shop_id,
                        'date' => $date,
                        'place_id' => $place_id,
                        'event_id' => $event_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'comment' => $request->comment,
                        'status' => 1,
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'msg' => 'ok',
                'results' => $results,
                'request' => $request->all(),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => 'ng',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function setup_canceled(Request $request) {
        try {
            DB::beginTransaction();
            $setup = SetUp::find($request->setup_id);
            $setup->update([
                'status' => 0,
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

    public function setup_cancellation(Request $request) {
        try {
            DB::beginTransaction();
            $setup = SetUp::find($request->setup_id);
            $setup->update([
                'status' => 1,
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

    public function setup_deleted(Request $request) {
        try {
            DB::beginTransaction();
            $setup = SetUp::find($request->setup_id);
            $setup->delete();
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

    public function user_register(Request $request) {
        try {
            DB::beginTransaction();
            $solt = bin2hex(random_bytes(5));
            $account = Account::create([
                'uid' => hash('sha256', $request->uid),
                'solt' => $solt,
                'status' => 1,
            ]);
            $costomer = Costomer::create([
                'user_id' => hash('sha256', $solt.$request->uid),
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

    public function information_update(Request $request) {
        try {
            DB::beginTransaction();
            $information = Information::find(1);
            $information->update([
                'content' => $request->markdown,
                'date' => date('Y-m-d'),
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
