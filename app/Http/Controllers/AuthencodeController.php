<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use Illuminate\support\Facades\Http;

class AuthencodeController extends Controller
{    
    public function index()
    {
        $data['product_data'] = Products::get();
        $product = array();
        $products = Market_product::all();
        foreach ($products as $item) {
            $product[] = [
                'productid' => $item->product_id,
                'productcode' => $item->product_code,
                'productname' => $item->product_name 
            ];
        }
        return view('admin',$data,[
            'products'  =>  $product
        ]);
    }

    public function customerHome(Request $request)
    {
        return view('customer.home');
    }
    public function read(Request $request)
    { 
    //    $collection = Http::get("http://localhost:8189/api/smartcard/read");
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
        'collection' => $collection
    ]);
      
        // return Http::get('http://localhost:8189/api/smartcard/read');
    }

}

