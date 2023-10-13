<?php

namespace App\Http\Controllers;

use App\Models\SetUpList;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $data = [
            'set_ups' => SetUpList::whereDate('date', '>', date('Y-m-d'))->get(),
        ];
        return view('index', $data);
    }
}
