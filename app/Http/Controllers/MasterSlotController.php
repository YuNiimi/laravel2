<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Datas;
use \App\Models\Slots;
use \App\Models\Stores;
use Illuminate\Support\Facades\DB;

class MasterSlotController extends Controller
{
    /*public function index(){
        // 店舗データを返す
        $stores = DB::table('stores')->get();
        return view('master.store.index',['datas' => $stores]);
    }*/

    public function edit($store_id){
        $slots = DB::table('slots')->where("store_id",$store_id)->get();
        return view('master.slot.edit',['datas' => $slots,"store" => $store_id]);
    }

    public function slotcreate(Request $request){
        $slot = new Slots;
        $slot->store_id=$request->input('store_id');
        $slot->sis=$request->input('code');
        $slot->name=$request->input('name');
        $slot->name_encode=$request->input('name_encode');
        
        $slot->save();
        return redirect('master/store/'.$request->input('store_id'));
    }

}
