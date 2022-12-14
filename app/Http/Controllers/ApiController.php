<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Authencode;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
// use Illuminate\support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;

class ApiController extends Controller
{ 
    public function patient_readonly(Request $request)
    { 
        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His");
        $ip = $request->ip();
        // $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His");
        $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
        $getpatient =  DB::connection('mysql')->select('select cid,hometel from patient limit 2');
        $getvn_stat =  DB::connection('mysql')->select('select * from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql')->select('select * from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql')->select('select * from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql')->select('select * from ovst_seq limit 2');

        // $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();
        $getovst_key = Http::get('http://192.168.0.17/pkauthen/public/api/ovst_key')->collect();
        // เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql')->select('SELECT uuid() as keygen'); 
        // $output = Arr::sort($data_key); 
        // $output2 = Arr::query($data_key);       
        // $output3 = Arr::sort($data_key['keygen']);
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $output_show = $value->keygen; 
        }
        // dd($output_show);
       
        return response([
            $getpatient,$getvn_stat,$get_ovst,$get_opdscreen,
            $vn,$get_ovst_seq,
            $getovst_key,$output_show
        ]);
    }
    public function ovst_key(Request $request)
    {
        $data['patient'] =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');

        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His"); 
        $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
        $ip = $request->ip();

        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
        // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        $datapatient = DB::table('patient')->where('cid','=',$collection['pid'])->first();
            if ($datapatient->hometel != null) {
                $cid = $datapatient->hometel;
            } else {
                $cid = '';
            }   
            if ($datapatient->hn != null) {
                $hn = $datapatient->hn;
            } else {
                $hn = '';
            }  
            if ($datapatient->hcode != null) {
                $hcode = $datapatient->hcode;
            } else {
                $hcode = '';
            } 

          $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();    
        
          $outputcard = Arr::sort($getovst_key);
          // $outputcard = Arr::sort($getovst_key['ovst_key']);
        //    foreach ($outputcard as $values) { 
              // $showovst_key = $values['result']; 
        //   }
        
          return response([
            'getovst_key'  => $getovst_key['result']['ovst_key'],
              $outputcard
             ]);
    }

    
}