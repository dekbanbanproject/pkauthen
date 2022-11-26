<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use Http;
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

Route::get('/', function (Request $request) {
    $ip = $request->ip();
    //   dd($ip);
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals')->collect();
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
    $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals')->collect(); 
    // $smartcard = Http::get('http://192.168.0.17:8189/api/smartcard/read')->collect();  
    // $smartcard = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
    // $smartcardcheck = $terminals['statusCode'];
    // $smartcardcheck = $terminals['isPresent'];
    // foreach ($terminals as $items) 
    //     {
    //      $terminalname = $items['statusCode']; 
    //     }
    // dd($smartcardcheck);
    // if ($smartcardcheck = '500') {
    //     $smartcardshow_data = 'กรุณาเสียบที่อ่านการ์ด';
    // } else {
    //     $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals')->collect();
    //     $smartcardread = Http::get('http://192.168.123.59:8189/api/smartcard/read')->collect(); 

    // if ($terminals['status'] != 500 || $terminals['terminalName'] != '') {
    //     foreach ($terminals as $items) 
    //     {
    //      $terminalname = $items['terminalName'];
    //      $ispresent = $items['isPresent'];
    //     }

    //     if ($ispresent = 'false') {
    //         $smartcardshow_data = 'ไม่พบเครื่องอ่านบัตร';
    //     } else {
    //         # code...
    //     }
    // } else {
    //     $smartcardshow_data = 'ไม่พบเครื่องอ่านบัตร';
    // }
    
        // foreach ($terminals as $items) 
        // {
        //  $terminalname = $items['terminalName'];
        //  $ispresent = $items['isPresent'];
        // }

        // if ($ispresent = 'false') {
        //     $smartcardshow_data = 'กรุณาเสียบที่อ่านการ์ด';
        // } else {
        //     # code...
        // }
        
    // }
//     "terminalName": "Feitian SCR301 0",
// "isPresent": false
   
    

//   if ($ispresent = 'true' ) {
//     $smartcardshow_data = $smartcardread;
//     } else {
        
//         $smartcardshow_data = 'กรุณาเสียบที่อ่านการ์ด';
//     }
    // $ip = $request->ip();
    // dd($smartcardshow_data);
    // $datas['datas'] = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();  
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
    // $smartcard = $terminals['status'];
    // dd($terminal);
    // if ($smartcard == 500 ) {
    //     $terminalsd = 'กรุณาเสียบที่อ่านการ์ด';
    // } else {
    //     $terminalss = $terminal;
    // }
    
    // dd($terminals['status'] );
    return view('welcome',[
        // 'terminalname' => $terminals['isPresent'],
        'terminals'   =>   $terminals,
        // 'smartcard'   =>   $smartcard,
        'status'      =>   '200' 
    ]);
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
