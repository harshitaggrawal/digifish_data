<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\newData;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/view', function () {
    return view('date');
});


Route::get('/',[DataController::class,'index']);
Route::get('selectdata',[DataController::class,'selectdata']);


Route::get('/view',[newData::class,'index']);
Route::get('showdata',[newData::class,'showdata']);

