<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' =>'auth:sanctum'],function(){
      Route::get('user.list',[UserController::class,'list'])->name('user.list');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/productos', function () {
    return view('productos/index');
})->name('productos');

Route::middleware(['auth:sanctum', 'verified'])->get('/reportes', function () {
    return view('reportes/index');
})->name('reportes');

Route::middleware(['auth:sanctum', 'verified'])->get('/terminos', function () {
    return view('terms');
})->name('terminos');
