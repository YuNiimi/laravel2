<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade as GoutteFacade;
use Goutte\Client;
use \App\Models\Datas;
use \App\Models\Slots;
use \App\Models\Stores;
use Illuminate\Support\Facades\DB;

class ScrapingController extends Controller
{

    /**
     * ScrapingController
     * 店舗idとStoresリストを受け取ってから
     *  
     * 
     */
    /*public function index111()
    {

        //scraping　パラメータ
        $base_URL = 'https://p-tora.com/toukai/hall/index.html?no=';
        $crawler = GoutteFacade::request('GET', $base_URL.$store_id);
        $client = new Client();
        $form = $crawler->filter('form#item_form')->form();

        $store_id = '12328';
        $item_name = '%A5%DE%A5%A4%A5%B8%A5%E3%A5%B0%A5%E9%A1%BC%AD%B7KD';
        $form['item_name'] = $item_name;


        // testURL
        // 'https://www.amazon.co.jp/gp/s/ref=amb_link_1?ie=UTF8&field-enc-merchantbin=AN1VRQENFRJN5%7CA1RJCHJCQT9WV5&field-launch-date=30x-0x&node=2494234051&pf_rd_m=AN1VRQENFRJN5&pf_rd_s=merchandised-search-left-4&pf_rd_r=6CWTB56SQ1GK6RA30VVV&pf_rd_r=6CWTB56SQ1GK6RA30VVV&pf_rd_t=101&pf_rd_p=f72beb25-a5bc-4658-9aa6-7d92f73c2c8b&pf_rd_p=f72beb25-a5bc-4658-9aa6-7d92f73c2c8b&pf_rd_i=637394'
        // nmk_kisyu=%25E3%2582%25B0%25E3%2583%25AC%25E3%2583%25BC%25E3%2583%2588%25E3%2582%25AD%25E3%2583%25B3%25E3%2582%25B0%25E3%2583%258F%25E3%2583%258A%25E3%2583%258F%25E3%2583%258A-30

        //scraping実行
        $crawler = $client->submit($form);
        $html = $crawler->html();
        $table = $crawler->filter('table tr')->each(function($element){
            echo $element->text()."\n";
        });
        //filter,合成計算

        dd($html);
    }*/

    public function index11()
    {
        // testURL
        // nmk_kisyu=%25E3%2582%25B0%25E3%2583%25AC%25E3%2583%25BC%25E3%2583%2588%25E3%2582%25AD%25E3%2583%25B3%25E3%2582%25B0%25E3%2583%258F%25E3%2583%258A%25E3%2583%258F%25E3%2583%258A-30
        $crawler = GoutteFacade::request('GET', 'https://p-tora.com/toukai/hall/index.html?no=12328');
        $store_id = '12328';
        
        $client = new Client();

        // $form = $crawler->filter('#form')->first()->form();
        $form = $crawler->filter('form#item_form')->form();

        $slot_id = "1";
        $form['sis'] = '1365';
        $form['item_name'] = '%A5%DE%A5%A4%A5%B8%A5%E3%A5%B0%A5%E9%A1%BC%AD%B7KD';

        $crawler = $client->submit($form);
        $html = $crawler->html();
        
        //データ格納配列
        // $datas = array();
        // $dom = $crawler->filter('td.td1')->each(function($element)use ($data_array){
        //     // dd($element);
        //     // $el = $element->text()."\n";
        //     echo $el = $element->text();
        //     array_push($data_array,$el);
        // });
        // var_dump($data_array);

        //一次元
        $data_array = array();
        $lix = 0;
        $dom = $crawler->filter('td.td1');
        $dom->each(function ($node) use (&$lix, &$data_array){
            $el = $node->text();
            if($el!='')array_push($data_array,$el);
        });


        $chunks = array_chunk($data_array,5);

        foreach($chunks as $chunk){
            $data = new Datas;
            $data->store_id = $store_id;
            $data->slot_id = $slot_id;
            $data->daiban = $chunk[0];
            $data->bb = $chunk[2];
            $data->rb = $chunk[3];
            $data->games = $chunk[4];
            $data->date = date("Y-m-d");

            Datas::updateOrCreate(
                ['store_id' => $data->store_id,'slot_id' => $data->slot_id, 'daiban'=>$chunk[0], 'date' => date("Y-m-d")],
                ['bb' => $chunk[2],'rb'=> $chunk[3],'games' => $chunk[4]]
            );
        }

        return view('hello.index',['datas' => $chunks]);
    }


    public function index(){

        $base_URL = "https://p-tora.com/toukai/hall/index.html?no=";

        //ビューに渡す配列
        $ret_date = array();

        //店舗ループ
        $stores = DB::table('stores')->get();
        foreach($stores as $store){
            $store_id = $store->id;
            $store_name = $store->name;
            $store_code = $store->code;
            // echo $store_id.":".$store_name."(".$store_code.")";
            //機種ループ
            $slots = DB::table('slots')->where('store_id',$store_id)->get();
            foreach($slots as $slot){
                $slot_id = $slot->id;
                $slot_code = $slot->sis;
                $slot_name = $slot->name;
                $slot_name_encode = $slot->name_encode;

                // Scraping開始
                $URI = $base_URL.$store_code;
                $crawler = GoutteFacade::request('GET', $URI);
                $client = new Client();
                $form = $crawler->filter('form#item_form')->form();
                $form['sis'] = $slot_code;
                $form['item_name'] = $slot_name_encode;
                //form_submit
                $crawler = $client->submit($form);
                $html = $crawler->html();
                //data_arrayに一元格納
                $data_array = array();
                $lix = 0;
                $dom = $crawler->filter('td.td1');
                $dom->each(function ($node) use (&$lix, &$data_array){
                    $el = $node->text();
                    if($el!='')array_push($data_array,$el);
                });
                //chunksに分割格納＋UPSERT（bb,rb,games以外で重複確認）
                $chunks = array_chunk($data_array,5);
                if(count($chunks)>0){
                    array_push($ret_date,["store_id"=>$store_id,"store"=>$store_name,"name"=>$slot_name,"count"=>count($chunks)]);
                }
                foreach($chunks as $chunk){
                    $data = new Datas;
                    $data->store_id = $store_id;
                    $data->slot_id = $slot_id;
                    $data->daiban = $chunk[0];
                    $data->bb = $chunk[2];
                    $data->rb = $chunk[3];
                    $data->games = $chunk[4];
                    $data->date = date("Y-m-d");

                    
                    //UPSERT
                    Datas::updateOrCreate(
                        ['store_id' => $data->store_id,'slot_id' => $data->slot_id, 'daiban'=>$chunk[0], 'date' => date("Y-m-d")],
                        ['bb' => $chunk[2],'rb'=> $chunk[3],'games' => $chunk[4]]
                    );
                }
            }
        }
        // var_dump($ret_date);
        return view('hello.index',['datas' => $ret_date]);

    }
}
