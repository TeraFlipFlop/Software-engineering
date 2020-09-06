<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('register', function () {
    return view('registration');})->name('register');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('home', function () {
    return '1';});
route::get('showofferte',function(){


    return view('mostraO');
});

route::get('notifications','UserNotifyCtrl@show')->middleware('auth');

route::get('/cercaO', function(){
    return view ('cercaO');
})->middleware('auth');

route::get('/pubblicaO', function(){
    return view ('cercaO');
})->middleware('auth');

