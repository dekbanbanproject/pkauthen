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
use Illuminate\support\Facades\Http;

class AuthencodeController extends Controller
{     
    public function authencode(Request $req)
    {
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft");
        $cid = $req->pid;
        $tel = $req->mobile;

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

}

