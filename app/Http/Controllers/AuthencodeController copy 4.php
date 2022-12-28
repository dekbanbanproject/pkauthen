<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Authencode;
use App\Models\Ovst;
use App\Models\Patient;
use App\Models\Vn_stat;
use App\Models\Visit_pttype;
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

class AuthencodeController extends Controller
{     
    public function authen_index(Request $request)
    { 
        // $ip = $request()->ip();
        $ip = $request->ip();
        // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        $collection = Http::get('http://localhost:8189/api/smartcard/read?readImageFlag=true')->collect();
        // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        $data['patient'] =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');

        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His"); 
        // $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
       //  $getpatient =  DB::connection('mysql')->select('select cid,hometel from patient limit 2');
        $getvn_stat =  DB::connection('mysql')->select('select * from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql')->select('select * from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql')->select('select * from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql')->select('select * from ovst_seq limit 2');        
        $get_spclty =  DB::connection('mysql')->select('select * from spclty');
        ///// เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql')->select('SELECT uuid() as keygen');  
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $hos_guid = $value->keygen; 
        }
    
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

            $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
            foreach($contents as $line) {  
            }
            $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
            $output = Arr::sort($chars,2);

            $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
            $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
            $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
            $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

            $token_ = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
            .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];

            $pid = $collection['pid'];
            // dd($pid);
            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,    
                                    "exceptions" => 0,    
                                    "cache_wsdl" => 0 
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$pid",
                        "smctoken" => "$token_",
                        "person_id" => "$pid",
                )
            );         
            $result = $client->__soapCall('searchCurrentByPID',$params);
           dd($result);
  
            foreach ($result as $key => $value) {
                // $status            = $value->status;
                // $cardid            = $value->cardid;
                $birthday                 = $value->birthdate;
                $fname                    = $value->fname;
                $lname                    = $value->lname;
                $hmain                    = $value->hmain;
                $hmain_name               = $value->hmain_name;
                $title                    = $value->title;
                $title_name               = $value->title_name;
                $maininscl                = $value->maininscl;
                $maininscl_main           = $value->maininscl_main;
                $maininscl_name           = $value->maininscl_name;
                $nation                   = $value->nation; 
                $primary_amphur_name      = $value->primary_amphur_name; 
                $primary_moo              = $value->primary_moo; 
                $primary_mooban_name      = $value->primary_mooban_name; 
                $primary_province_name    = $value->primary_province_name; 
                $primary_tumbon_name      = $value->primary_tumbon_name;
                $primaryprovince          = $value->primaryprovince;
                $purchaseprovince         = $value->purchaseprovince;
                $purchaseprovince_name    = $value->purchaseprovince_name;
                $sex                      = $value->sex;
                $startdate                = $value->startdate;
                $person_id                = $value->person_id; 
                $startdate_sss            = $value->startdate_sss; 
                $subinscl                 = $value->subinscl;
                $subinscl_name            = $subinscl_name;
                $ws_data_source           = $value->ws_data_source;
                $ws_date_request          = $value->ws_date_request;
                $ws_status                = $value->ws_status;
                $ws_status_desc           = $value->ws_status_desc;
                $wsid                     = $value->wsid;
                $wsid_batch               = $value->wsid_batch;

            }

            dd($fname);
        //   $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();    
       
        //APi ovst_key IP SERVER
        $getovst_key = Http::get('http://192.168.0.17/pkauthen/public/api/ovst_key')->collect();
        $outputcard = Arr::sort($getovst_key);

        // $hkey = $collection['pid'];         
        // $outputcard = Arr::sort($getovst_key['ovst_key']);
        //  foreach ($outputcard as $values) { 
        //     $showovst_key = $values['result']; 
        // }
        // foreach ($outputcard as $key => $value) {           
        //     $ovst_key = $value->ovst_key; 
        // }
        $strY = date('Y', strtotime($expdate)); 
        $strM = date('m', strtotime($expdate)); 
        $strD = date('d', strtotime($expdate)); 
        $expire_date = $strY.'-'.$strM.'-'.$strD;
            // dd($dateall);

        return view('authen',$data,[
            'collection1'  => $collection['pid'],
            'collection2'  => $collection['fname'],
            'collection3'  => $collection['lname'],
            'collection4'  => $collection['birthDate'],
            'collection5'  => $collection['transDate'],
            'collection6'  => $collection['mainInscl'],
            'collection7'  => $collection['subInscl'],
            'collection8'  => $collection['age'],
            'collection9'  => $collection['checkDate'],
            'collection10' => $collection['correlationId'],
            'collection11' => $collection['checkDate'],
            'collection'   => $collection,
            'hos_guid'     => $hos_guid, 
            'collection12' => $collection['hospMain']['hcode'],
            'collection13' => $collection['image'],
            'getovst_key'  => $getovst_key['result']['ovst_key'],
            'get_spclty'   => $get_spclty,
            'maininscl'    => $maininscl,
            'cardid'       => $cardid,
            'subinscl'     => $subinscl,
            'hsub'         => $hsub,
            'hmain'        => $hmain,
            'person_id'    => $person_id,
            'expdate'      => $expdate,
            'expire_date'      => $expire_date
        ]);
   
    }
    public function authencode(Request $req)
    {
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft");
        $cid = $req->pid;
        $tel = $req->mobile;
        // $ip = $request->ip();        
        $authen = Http::post("http://localhost:8189/api/nhso-service/confirm-save",
        [
            'pid'              =>  $cid,
            'claimType'        =>  $req->claimType,
            'mobile'           =>  $tel,
            'correlationId'    =>  $req->correlationId,
            'hcode'            =>  $req->hcode
        ]);

        
        Patient::where('cid', $cid)
            ->update([
                'hometel'         => $tel 
            ]);
 
        // return $authen->json();
        return response()->json([
            'status'     => '200'
        ]);
        
       
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft/",[
        //     'pid'              =>  "pid",
        //     'claimType'        =>  "claimType",
        //     'mobile'           =>  "mobile",
        //     'correlationId'    =>  "correlationId",
        //     'hcode'            =>  "hcode"
        // ]);
        // $authen = new Authencode;
        // $authen->pid = $req->pid;
        // $authen->claimType = $req->claimType;
        // $authen->mobile = $req->mobile;
        // $authen->correlationId = $req->correlationId;
        // $authen->hcode = $req->hcode;

        // $result = $authen->save();

        // if ($result) {
        //     return ["result" => "Data Save success"];
        // } else {
        //     return ["result" => "Data Save Fail"];
        // }
        
    }

    public function read(Request $request)
    { 
        // $collection = Http::get("http://localhost:8189/api/smartcard/read");
       $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();

       return view('welcome',[
        'collection1' => $collection['pid'],
        'collection2' => $collection['fname'],
        'collection3' => $collection['lname'],
        'collection4' => $collection['birthDate'],
        'collection5' => $collection['transDate'],
        'collection6' => $collection['mainInscl'],
        'collection7' => $collection['subInscl'],
        'collection8' => $collection['age'],
        'collection9' => $collection['checkDate'],
        'collection10' => $collection['correlationId'],
        'collection11' => $collection['startDateTime'],
        'collection' => $collection
    ]); // return Http::get('http://localhost:8189/api/smartcard/read');
    }

    public function authen_cid(Request $req)
    { 
       $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
       $status            = '';
       $birthday          = '';
       $fname             = '';
       $lname             = '';
       $hmain             = '';
       $hmain_name        = '';
       $hsub              = '';
       $hsub_name         = '';
       $maininscl         = '';
       $maininscl_main    = '';
       $maininscl_name    = '';
       $expdate           = '';
 
        $ip = $req->ip();
        // $path = ($ip.'/PKAuthen'.'/public/'.'Authen/nhso_token.txt');
        $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        // $contents = file($path, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        
        foreach($contents as $line) {  
        }
 
        $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
        
        $output = Arr::sort($chars,2);
        
        $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
        $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
        $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
        $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

        $data['datatotal'] = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
        .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];
 
   
        // dd($line);
       return view('authen_cid',$data,
        [
            $status            = $status,
            $birthday          =  $birthday ,
            $fname             = $fname,
            $lname             = $lname,
            $hmain             = $hmain,
            $hmain_name        =  $hmain_name,
            $hsub              = $hsub,
            $hsub_name         = $hsub_name,
            $maininscl         = $maininscl,
            $maininscl_main    = $maininscl_main,
            $maininscl_name    =  $maininscl_name,
            $expdate           = $expdate,
        ]
    );  
    }

    public function check_sit(Request $req )
    {  
        $collection = Http::get('http://localhost:8189/api/smartcard/read?readImageFlag=true')->collect();
        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His"); 
        // $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
       //  $getpatient =  DB::connection('mysql')->select('select cid,hometel from patient limit 2');
        $getvn_stat =  DB::connection('mysql')->select('select * from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql')->select('select * from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql')->select('select * from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql')->select('select * from ovst_seq limit 2');        
        $get_spclty =  DB::connection('mysql')->select('select * from spclty');
        ///// เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql')->select('SELECT uuid() as keygen');  
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $hos_guid = $value->keygen; 
        }

        $cid = $req->check_cid;
        // $token_ = $req->token;
        $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        
        foreach($contents as $line) {  
        }
        $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY); 
        $output = Arr::sort($chars,2);
        $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
        $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
        $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
        $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

        $token_ = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
        .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];
        // dd($cid);
        // $client = new \SoapClient($wsdl, $options);
        $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
            array(
                "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                "trace"      => 1,    
                                "exceptions" => 0,    
                                "cache_wsdl" => 0 
                )
            );
            $params = array(
                'sequence' => array(
                    "user_person_id" => "$cid",
                    "smctoken" => "$token_",
                    "person_id" => "$cid",
            )
        );         
        $result = $client->__soapCall('searchCurrentByPID',$params);
        $card = Arr::sort($result);
        // dd($card);
        foreach ($result as $key => $value1) { 
            $count_select = $value1->count_select; 
            $data_status = $value1->ws_status_desc; 
        }
       
        // dd($result);
        if ($count_select == 0) {
            $status            = '';
            $birthday          = '';
            $fname             = '';
            $lname             = '';
            $hmain             = '';
            $hmain_name        = '';
            $hsub              = '';
            $hsub_name         = '';
            $maininscl         = '';
            $maininscl_main    = '';
            $maininscl_name    = '';
            $expdate           = '';
            $hmain_op          = '';
            $hmain_op_name     = '';
            $mastercup_id      = '';
            $person_id         = '';
            $subinscl          = '';
            $subinscl_name     = '';
            $cid               = '';
            $cardid            = '';
        } else {
            foreach ($result as $key => $value) {
                $status            = $value->status;
                $birthday          = $value->birthdate;
                $fname             = $value->fname;
                $lname             = $value->lname;
                $hmain             = $value->hmain;
                $hmain_name        = $value->hmain_name;
                $hsub              = $value->hsub;
                $hsub_name         = $value->hsub_name;
                $maininscl         = $value->maininscl;
                $maininscl_main    = $value->maininscl_main;
                $maininscl_name    = $value->maininscl_name;
                $expdate           = $value->expdate; 
    
                $hmain_op           = $value->hmain_op; 
                $hmain_op_name      = $value->hmain_op_name; 
                $mastercup_id       = $value->mastercup_id; 
                $person_id          = $value->person_id; 
                $subinscl           = $value->subinscl; 
                $subinscl_name      = $value->subinscl_name; 
                $cid                = $cid;
                $cardid            = $value->cardid;
            }
        }
        
        $strY = date('Y', strtotime($expdate)); 
        $strM = date('m', strtotime($expdate)); 
        $strD = date('d', strtotime($expdate)); 
        $expire_date = $strY.'-'.$strM.'-'.$strD;
        // dd($fname);
        $ip = $req->ip();
        // $datapatient = DB::table('patient')->where('cid','=',$collection['pid'])->first();
        $datapatient = DB::table('patient')->where('cid','=',$cid)->first();
            if ($datapatient->hometel != null) {
                $hometel = $datapatient->hometel;
            } else {
                $hometel = '';
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
       
        $terminals = Http::get('http://localhost:8189/api/smartcard/terminals')->collect(); 
        // $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();    

       
        // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        $data['patient'] =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');
        $output = Arr::sort($terminals);
     
        //เช็คที่อ่านการ์ด
        if ($output == []) {
            // if ($output == "") {
                $smartcard = 'NO_CONNECT';
                $smartcardcon = '';
                $collection['pid'] = '';
                $collection['fname'] = '';
                $collection['lname'] = '';
                $collection['birthDate']= '';
                $collection['transDate'] = '';
                $collection['mainInscl']= '';
                $collection['subInscl']= '';
                $collection['age']= '';
                $collection['checkDate']= '';
                $collection['correlationId']= '';
                $collection['checkDate']= '';
          
            } else {                
                $smartcard = 'CONNECT';
                foreach ($output as $key => $value) {
                    $terminalname = $value['terminalName'];
                    $cardcids = $value['isPresent']; 
                }

                //เช็คเสียบการ์ด
                if ($cardcids != 'false') {
                    $smartcardcon = 'NO_CID';
                    $collection['pid'] = '';
                    $collection['fname'] = '';
                    $collection['lname'] = '';
                    $collection['birthDate']= '';
                    $collection['transDate'] = '';
                    $collection['mainInscl']= '';
                    $collection['subInscl']= '';
                    $collection['age']= '';
                    $collection['checkDate']= '';
                    $collection['correlationId']= '';
                    $collection['checkDate']= '';
                    
                } else {
                    $smartcardcon = 'CID_OK';
                    $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect(); 
                }    
                     
            }
        // dd($collection);
       return view('check_sit',$data,[
        'result'          =>  $result,
        'birthday'        =>  $birthday,
        'fname'           =>  $fname,
        'lname'           =>  $lname,
        'hmain'           =>  $hmain,
        'hmain_name'      =>  $hmain_name,
        'hsub'            =>  $hsub,
        'hsub_name'       =>  $hsub_name,
        'maininscl'       =>  $maininscl,
        'maininscl_main'  =>  $maininscl_main,
        'maininscl_name'  =>  $maininscl_name,
        'hmain_op'        =>  $hmain_op,
        'hmain_op_name'   =>  $hmain_op_name,
        'mastercup_id'    =>  $mastercup_id,
        'person_id'       =>  $person_id,
        'subinscl'        =>  $subinscl,
        'subinscl_name'   =>  $subinscl_name,

        'collection1' => $collection['pid'],
        'collection2' => $collection['fname'],
        'collection3' => $collection['lname'],
        'collection4' => $collection['birthDate'],
        'collection5' => $collection['transDate'],
        'collection6' => $collection['mainInscl'],
        'collection7' => $collection['subInscl'],
        'collection8' => $collection['age'],
        'collection9' => $collection['checkDate'],
        'collection10' => $collection['correlationId'],
        'collection11' => $collection['checkDate'],
        // 'collection12' => $collection['hospMain']['hcode'],
        // 'collection13' => $collection['image'],
        // 'getovst_key'  => $getovst_key['result']['ovst_key'],
        'collection'   => $collection,
        'hos_guid'     => $hos_guid, 
        'hometel'          => $hometel,
        'cardid'       => $cardid,
        'expire_date'  => $expire_date,
        'get_spclty'   => $get_spclty
       ]);  
    }

    public function authen_save(Request $req)
    {
        $date = date('Y-m-d');
        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His");
        $timesave = date("H:i:s");  
        $vn = $year.''.$mounts.''.$day.''.$time;
        $pid = $req->pid;
        $tel = $req->mobile;
        $hcode = $req->hcode;
        $hospmain = $req->hmain;
        $hospsub = $req->hsub;
        $oqueue = Ovst::max('oqueue');
        $maxoqueue = $oqueue+1;

        $hn = $req->hn;
        $hos_guid = $req->hos_guid;
        $pttype = $req->pttype;
        $pttypeno = $req->pttypeno;
        $expire_date = $req->expire_date;

            $add = new Ovst(); 
            $add->hos_guid = $hos_guid;
            $add->hn       = $hn;
            $add->vn       = $vn;
            $add->spclty   = $req->spclty;
            $add->oqueue   = $maxoqueue; 
            $add->vstdate  = $date; 
            $add->vsttime  = $timesave; 
            $add->ovst_key = $req->ovst_key;
            $add->pttype   = $pttype;
            $add->pttypeno = $pttypeno;
            $add->hospmain = $hospmain;
            $add->hospsub  = $hospsub;
            $add->hcode    = $hcode;
            $add->staff    = 'KIOS'; 
            $add->save();     

            Patient::where('cid', $pid)
            ->update([
                'hometel'         => $tel 
            ]);

            
            $add2 = new Vn_stat(); 
            $add2->hos_guid      = $hos_guid;
            $add2->hn            = $hn;
            $add2->vn            = $vn;
            $add2->cid           = $pid; 
            $add2->vstdate       = $date;  
            $add2->hospmain      = $hospmain; 
            $add2->hospsub       = $hospsub;
            $add2->pttypeno      = $pttypeno;
            $add2->pttype_expire = $expire_date;
            $add2->pttype   = $pttype;
            $add2->save(); 
            
            $add3 = new Visit_pttype();
            $add3->vn           = $vn;
            $add3->pttype       = $pttype;
            $add3->hospmain     = $hospmain;
            $add3->hospsub      = $hospsub;
            $add3->pttypeno     = $pttypeno;
            $add3->hos_guid      = $hos_guid;
            $add3->save(); 


            // ออก Authen Code       
            $authen = Http::post("http://localhost:8189/api/nhso-service/confirm-save/",
            [
                'pid'              =>  $pid,
                'claimType'        =>  $req->claimType,
                'mobile'           =>  $tel,
                'correlationId'    =>  $req->correlationId,
                'hcode'            =>  $hospmain 
            ]);
 
        return response()->json([
            'status'     => '200'
        ]);
    }

}

