<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwitterController;

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
    return view('welcome');
})->name('wlc');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/scan-qr-code', [UserController::class, 'scanQrCode'])->name('scan.qr.code');
Route::get('/user/{userId}/download-pdf', [UserController::class, 'downloadPDF'])->name('user.download.pdf');
Route::get('/twitter', [TwitterController::class, 'handle'])->name('twitter');
Route::get('/callback', [TwitterController::class, 'callbackHandle'])->name('twitter.callback');



// routes/Admin.php
Route::get('/admin/login', 'App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'App\Http\Controllers\Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'App\Http\Controllers\Admin\Auth\LoginController@logout')->name('admin.logout');



