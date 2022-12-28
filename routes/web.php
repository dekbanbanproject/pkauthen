<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use Http;
use GuzzleHttp\Client;
Route::get('/', function (Request $request) {

     $year = substr(date("Y"),2) +43;
     $mounts = date('m');
     $day = date('d');
     $time = date("His"); 
     $hcode = '10978';
     $vn = $year.''.$mounts.''.$day.''.$time;
    //  $getpatient =  DB::connection('mysql')->select('select cid,hometel from patient limit 2');
    //  $getvn_stat =  DB::connection('mysql')->select('select * from vn_stat limit 2');
    //  $get_ovst =  DB::connection('mysql')->select('select * from ovst limit 2');
    //  $get_opdscreen =  DB::connection('mysql')->select('select * from opdscreen limit 2');
    //  $get_ovst_seq =  DB::connection('mysql')->select('select * from ovst_seq limit 2');

    //  $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();
    
     ///// เจน  hos_guid  จาก Hosxp
    //  $data_key = DB::connection('mysql')->select('SELECT uuid() as keygen');  
    //  $output4 = Arr::sort($data_key); 
    //  foreach ($output4 as $key => $value) { 
        //  $output_show = $value->keygen; 
    //  }
     ////// dd($output_show); 
     
     

    $ip = $request->ip();
    //   dd($ip);
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals')->collect();
    // $terminals = Http::get('http://192.168.0.17:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals');
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
    // $terminals = Http::get('http://192.168.123.59:8189/api/smartcard/terminals')->collect(); 
    // $smartcard = Http::get('http://192.168.0.17:8189/api/smartcard/read')->collect();  
    // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals'); 
    $terminals = Http::get('http://localhost:8189/api/smartcard/terminals')->collect(); 
    $cardcid = Http::get('http://localhost:8189/api/smartcard/read')->collect();  
    $cardcidonly = Http::get('http://localhost:8189/api/smartcard/read-card-only')->collect(); 
   
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
        }

       
        
    // dd($terminalname);
    return view('welcome',[ 
        'smartcard'            =>   $smartcard, 
        'cardcid'            =>  $cardcid,
        'smartcardcon'            =>  $smartcardcon,
        'output'            =>  $output,
        'status'               =>   '200' 
    ]);
   
});

Route::get('authen_index', [App\Http\Controllers\AuthencodeController::class, 'authen_index'])->name('authen_index');
Route::get('/read', [App\Http\Controllers\AuthencodeController::class, 'read'])->name('read');
Route::get('authen_cid', [App\Http\Controllers\AuthencodeController::class, 'authen_cid'])->name('authen_cid');
Route::get('check_sit', [App\Http\Controllers\AuthencodeController::class, 'check_sit'])->name('c.check_sit');

Route::POST('authencode', [App\Http\Controllers\AuthencodeController::class, 'authencode'])->name('a.authencode');
Route::POST('authen_save', [App\Http\Controllers\AuthencodeController::class, 'authen_save'])->name('a.authen_save');