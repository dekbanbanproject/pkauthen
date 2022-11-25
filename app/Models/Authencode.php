<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Authencode extends Model
{
    use HasFactory;

    // protected $connection = 'mysql2';

    // protected $connection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
 
    public $timestampts = false;

}
