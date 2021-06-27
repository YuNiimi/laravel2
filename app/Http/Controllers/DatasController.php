<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Datas;
use \App\Models\Slots;
use \App\Models\Stores;
use Illuminate\Support\Facades\DB;

class DatasController extends Controller
{
    public function index(){
        // 店舗データを返す
        $datas = DB::table('datas')->get();
        return view('datas.index',['datas' => $datas]);
    }

    

}
