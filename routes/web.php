<?php

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
    // $datas = "http://localhost:8189/api/smartcard/read";
    // dd($data );
    return view('welcome');
    // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
    // $data['patient'] =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');

    // return view('welcome',$data,[
    //     'collection1' => $collection['pid'],
    //     'collection2' => $collection['fname'],
    //     'collection3' => $collection['lname'],
    //     'collection4' => $collection['birthDate'],
    //     'collection5' => $collection['transDate'],
    //     'collection6' => $collection['mainInscl'],
    //     'collection7' => $collection['subInscl'],
    //     'collection8' => $collection['age'],
    //     'collection9' => $collection['checkDate'],
    //     'collection10' => $collection['correlationId'],
    //     'collection11' => $collection['checkDate'],
    //     'collection' => $collection
    // ]);
});

Route::get('authen_index', [App\Http\Controllers\AuthencodeController::class, 'authen_index'])->name('authen_index');
Route::get('/read', [App\Http\Controllers\AuthencodeController::class, 'read'])->name('read');
