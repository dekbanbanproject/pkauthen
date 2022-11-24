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

    $datas = "http://localhost:8189/api/smartcard/read";

    // dd($data );
    return view('welcome',$data);
});

Route::get('/read', [App\Http\Controllers\AuthencodeController::class, 'read'])->name('read');
