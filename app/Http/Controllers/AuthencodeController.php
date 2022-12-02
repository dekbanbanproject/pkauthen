<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Authencode;
use App\Models\Ovst;
use App\Models\Patient;
use App\Models\Vn_stat;
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

            $contents = file('E:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
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
           
            foreach ($result as $key => $value) {
                $status            = $value->status;
                $cardid            = $value->cardid;
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
                // $subinscl           = $subinscl
            }
          $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();    
       
        //APi ovst_key IP SERVER
        // $getovst_key = Http::get('http://192.168.0.17/pkauthen/public/api/ovst_key')->collect();
       
        // $hkey = $collection['pid']; 
        $outputcard = Arr::sort($getovst_key);
        // $outputcard = Arr::sort($getovst_key['ovst_key']);
        //  foreach ($outputcard as $values) { 
        //     $showovst_key = $values['result']; 
        // }
        // foreach ($outputcard as $key => $value) {
           
        //     $ovst_key = $value->ovst_key; 
        // }
            // dd($outputcard);

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
            'getovst_key'   => $getovst_key['result']['ovst_key'],
            'get_spclty'   => $get_spclty,
            'maininscl'    => $maininscl,
            'cardid'       => $cardid,
            'subinscl'     => $subinscl
        ]);
   
    }
    public function authencode(Request $req)
    {
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft");
        $cid = $req->pid;
        $tel = $req->mobile;
        // $ip = $request->ip();        
        $authen = Http::post("http://localhost:8189/api/nhso-service/confirm-save/",
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

        // str_pad(string , length , pad_string , pad_type)
        // string คือ สตริงที่ต้องการเติมคำ
        // length คือ ความยาวของสตริงที่ต้องการ
        // pad_string คือ ตัวอักษรหรือคำที่ต้องการเติม
        // pad_type คือ รูปแบบการเติม ค่าที่เป็นไปได้คือ
        // STR_PAD_BOTH - เติมทั้งสองข้าง ถ้าไม่ลงตัวข้างขวาจะถูกเติมมากกว่า
        // STR_PAD_LEFT - เติมด้านซ้าย
        // STR_PAD_RIGHT - เติมด้านขวา (default)
     
        //    $contents = File::get('D:\Authen\nhso_token.txt');
        $ip = $req->ip();
        // $path = ($ip.'/PKAuthen'.'/public/'.'Authen/nhso_token.txt');
        $contents = file('E:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        // $contents = file($path, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        
        foreach($contents as $line) { 
            // echo str_pad($count, 2, 0, STR_PAD_LEFT).". ".$line;
            // echo $line;
        }

        // $mani = str_pad($line, 5); 
        // echo $mani . "#" . "\n";
       
        // $a="3451000002897#";
        // $count_a = strlen($a);
        // echo $count_a;
        // echo str_pad($count_a, 15, 0, STR_PAD_LEFT);
        // echo "<br>";
        $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
        // print_r($chars);
        // echo "<br>";
        // $data['output'] = Arr::sort($chars,2);
        $output = Arr::sort($chars,2);
        // dd($output,$chars['17']);
        // dd($data['output']);
      
        $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
        $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
        $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
        $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

        $data['datatotal'] = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
        .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];

        // dd($datatotal);
        // echo "function:".str_pad($line,14,".",STR_PAD_RIGHT);  
        // echo "<br>";

        // if(strlen($line) > 15){
        //     $line = mb_substr($line, 0, 15).'...';
        //     }
        //     echo $line;
        //     echo "<br>";

      
        // for($i = 1;$i <$count_a;$i++)
        // {
        //     echo $line[$i];
        //     echo "<br>";
        // }
        // $ar = array();
        // for($i = 0;$i < strlen($line); $i++)
        // {
        //     echo array_push($ar, substr($line,$i,1));
        // }
        // echo str_pad($mani,15,".");  

        // echo str_pad("line", 11, "pp", STR_PAD_BOTH )."\n";
        // echo str_pad($line, 20, "-=", STR_PAD_LEFT)."\n";
        // echo str_pad($line,  15, "*"). "\n"; 
        // echo str_pad($line,5,"$",STR_PAD_LEFT);
        // $myFile = new SplFileObject('D:\Authen\nhso_token.txt');
        // while (!$myFile->eof()) {
        //     echo $myFile->fgets() . PHP_EOL;
        // }

        // $file_handle = fopen('D:\Authen\nhso_token.txt', 'r'); 
        // function get_all_lines($file_handle) { 
        //     while (!feof($file_handle)) {
        //         yield fgets($file_handle);
        //     }
        // }        
        // $count = 0;        
        // foreach (get_all_lines($file_handle) as $line) {
        //     $count += 1;
        //     echo $count.". ".$line;
        // }        
        // fclose($file_handle);
        
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
        $cid = $req->check_cid;
        // $token_ = $req->token;
        $contents = file('E:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        
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
    
            }
        }
        
       
        // dd($fname);
        $ip = $req->ip();
       
        $terminals = Http::get('http://localhost:8189/api/smartcard/terminals')->collect(); 
       
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
        'collection' => $collection
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
        $hospmain = $req->hospmain;
        $oqueue = Ovst::max('oqueue');
        $maxoqueue = $oqueue+1;

        $hn = $req->hn;
        $hos_guid = $req->hos_guid;
        
            $add = new Ovst(); 
            $add->hos_guid = $hos_guid;
            $add->hn = $hn;
            $add->vn = $vn;
            $add->spclty = $req->spclty;
            $add->oqueue = $maxoqueue; 
            $add->vstdate = $date; 
            $add->vsttime = $timesave; 
            $add->ovst_key = $req->ovst_key;
            $add->pttype = $req->pttype;
            $add->pttypeno = $req->pttypeno;
            $add->hospmain = $hospmain; 
            $add->staff = 'KIOS'; 
            $add->save();     

            Patient::where('cid', $pid)
            ->update([
                'hometel'         => $tel 
            ]);

            
            $add2 = new Vn_stat(); 
            $add2->hos_guid = $hos_guid;
            $add2->hn = $hn;
            $add2->vn = $vn;
            $add2->cid = $pid;
            // $add2->oqueue = $maxoqueue; 
            $add2->vstdate = $date; 
            // $add2->vsttime = $timesave; 
            // $add2->ovst_key = $req->ovst_key;
            // $add2->hcode = $req->pttype;
            // $add2->pttypeno = $req->pttypeno;
            $add2->hospmain = $hospmain; 
            $add2->save();     
 
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

