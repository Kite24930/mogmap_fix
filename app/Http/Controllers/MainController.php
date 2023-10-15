<?php

namespace App\Http\Controllers;

use App\Models\EventList;
use App\Models\SameList;
use App\Models\SetUpList;
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
}
