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

     // เจน  hos_guid  จาก Hosxp
     $data_key = DB::connection('mysql')->select('SELECT uuid() as keygen'); 
     $output = Arr::sort($data_key); 
     $output2 = Arr::query($data_key);       
     // $output3 = Arr::sort($data_key['keygen']);
     $output4 = Arr::sort($data_key); 
     foreach ($output4 as $key => $value) { 
         $output_show = $value->keygen; 
     }
     // dd($output_show);     
    $ip = $request->ip();
    //   dd($ip);
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals')->collect();
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
    // $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals')->collect(); 
    // $smartcard = Http::get('http://192.168.0.17:8189/api/smartcard/read')->collect();  
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals'); 
    $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect(); 
    $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();  
    $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect(); 
   
        // $output = data_set($terminals,'' ,'');
        // $output = data_set($terminals,'terminalname','1');
        // $output = data_set($terminals,'isPresent','false');
        // $output = Arr::query($terminals);
        $output = Arr::sort($terminals);
        $outputcard = Arr::sort($cardcid);
        $outputcardonly = Arr::sort($cardcidonly);
        // $output = Arr::sort($terminals['isPresent']);

        // dd($output);
        if ($output == []) {
        // if ($output == "") {
            $smartcard = 'NO_CONNECT';
            $smartcardcon = '';
        } else {
            $smartcard = 'CONNECT';
            foreach ($output as $key => $value) {
                $terminalname = $value['terminalName'];
                $cardcids = $value['isPresent']; 
            }
            if ($cardcids != 'false') {
                $smartcardcon = 'NO_CID';
            } else {
                $smartcardcon = 'CID_OK';
            }
            // dd($cardcids); 
            // $carddd = $cardcids;
            // $terminalname = $terminalname;
        }
        // foreach ($output as $key => $value) {
        //     $terminalname = $value['terminalName'];
        //     $cardcids = $value['isPresent']; 
        // }
        // if (condition) {
        //     # code...
        // } else {
        //     # code...
        // }
        // foreach ($outputcard as $key => $value2) { 
        //     $carddd = $value2['status']; 
        // }
        // dd($smartcardcon);
    // dd($terminalname);
    return view('welcome',[ 
        'smartcard'            =>   $smartcard, 
        'cardcid'            =>  $cardcid,
        'smartcardcon'            =>  $smartcardcon,
        'output'            =>  $output,
        'status'               =>   '200' 
    ]);
    // $smartcard = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
    // $datacard[]=[
    //   $dataC = $terminals['isPresent'];
    // ]
    // $smartcardcheck = $terminals['terminalName'];
    // $smartcardcheck = $terminals['isPresent'];
    // foreach ($terminals as $items) 
    //     {
    //      $terminalname = $items->terminalName;         
        // }

    // $terminals = [];
    // if ($terminals == '') {
    //     $smartcardshow = '1';
        // $terminals_show = '';
    // } else {
    //     foreach ($terminals as $items) 
    //     {   
    //         $ispresent = $items['isPresent']; 
    //         // $smartcardcheck = $items['terminalName'];  
    //     }  
    //     // $smartcardshow = '2';
    // // }
    // dd($terminals);

    // if ($ispresent = 'false') {
    //     // $smartcardshow_data = 'กรุณาเสียบบัตรประชาชน';
    // } else {   
    // }      
    
    // dd($terminals['status'] );
    // return view('welcome',[
    //     // 'terminalname' => $terminals['isPresent'],
    //     'terminals'            =>   $terminals,
    //     // 'smartcardshow_data'   =>   $smartcardshow_data,
    //     // 'terminals_show'       =>   $terminals_show,
    //     // 'smartcardshow'        =>   $smartcardshow,
    //     // 'terminals_data'        =>   $terminals_data,
    //     'ispresent'            =>  $ispresent,
    //     'status'               =>   '200' 
    // ]);
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
Route::get('authen_cid', [App\Http\Controllers\AuthencodeController::class, 'authen_cid'])->name('authen_cid');
Route::get('check_sit', [App\Http\Controllers\AuthencodeController::class, 'check_sit'])->name('c.check_sit');