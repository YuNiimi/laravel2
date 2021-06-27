<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/data','App\Http\Controllers\ScrapingController@index');

Route::get('/master', function () {
    return view('master/index');
});


Route::get('/master/store','App\Http\Controllers\MasterStoreController@index');
Route::get('/master/{store_id}/slot','App\Http\Controllers\MasterSlotController@edit');
Route::post('/master/store/slot/create','App\Http\Controllers\MasterSlotController@slotcreate');


Route::get('/datas/index','App\Http\Controllers\DatasController@index');
