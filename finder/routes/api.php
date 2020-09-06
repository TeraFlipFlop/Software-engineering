<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', 'User@index');
Route::get('/users/{id}', 'User@show');
Route::post('/users', 'User@store');
Route::delete('/users/{id}', 'User@destroy');
Route::put('/users/{id}', 'User@edit');
Route::patch('/users/{id}', 'User@update');
Route::post('/login', 'User@login');

Route::get('/offerte', 'OffertaCtrl@index');
Route::get('/offerte/{id}', 'OffertaCtrl@show');
Route::post('/offerte', 'OffertaCtrl@store');
Route::delete('/offerte/{id}', 'OffertaCtrl@destroy');
Route::put('/offerte/{id}', 'OffertaCtrl@edit');
Route::patch('/offerte/{id}', 'OffertaCtrl@update');
Route::get('/offerte/{id}/skills', 'OffertaCtrl@skilloff');
Route::get('/offerte/{id}/candidature', 'OffertaCtrl@candidature_a_offerta');
Route::get('/offerte/{id}/candidature/candidati', 'OffertaCtrl@candidati_a_offerta');


Route::get('/candidature', 'CandidaturaCtrl@index');
Route::get('/candidature/{id}', 'CandidaturaCtrl@show');
Route::post('/candidature', 'CandidaturaCtrl@store');
Route::delete('/candidature/{id}', 'CandidaturaCtrl@destroy');


Route::get('/notifiche', 'UserNotifyCtrl@index');
Route::get('/notifiche/{id}', 'UserNotifyCtrl@show');
Route::post('/notifiche', 'UserNotifyCtrl@store');
Route::delete('/notifiche/{id}', 'UserNotifyCtrl@destroy');

Route::get('/skills', 'skillCtrl@index');
Route::get('/skills/categorie/all', 'skillCtrl@showcategorie');
Route::get('/skills/categorie/{cat}', 'skillCtrl@showskillsbycat');
Route::get('/skills/list', 'skillCtrl@indexlist');
Route::get('/skills/{id}', 'skillCtrl@show');
Route::post('/skills', 'skillCtrl@store');
Route::delete('/skills/{id}', 'skillCtrl@destroy');
Route::put('/skills/{id}', 'skillCtrl@edit');
Route::patch('/skills/{id}', 'skillCtrl@update');

Route::get('/profili_off', 'profilo_off_Ctrl@index');
Route::get('/profili_off/{id}', 'profilo_off_Ctrl@show');
Route::post('/profili_off', 'profilo_off_Ctrl@store');
Route::delete('/profili_off/{id}', 'profilo_off_Ctrl@destroy');
Route::put('/profili_off/{id}', 'profilo_off_Ctrl@edit');
Route::patch('/profili_off/{id}', 'profilo_off_Ctrl@update');
Route::get('/profili_off/{id}/candidature', 'profilo_off_Ctrl@showcanbyid');
Route::get('/profili_off/{id}/candidature/candidati', 'profilo_off_Ctrl@showcandidati');

Route::get('/profili_can', 'profilo_can_Ctrl@index');
Route::get('/profili_can/{id}', 'profilo_can_Ctrl@show');
Route::post('/profili_can', 'profilo_can_Ctrl@store');
Route::delete('/profili_can/{id}', 'profilo_can_Ctrl@destroy');
Route::put('/profili_can/{id}', 'profilo_can_Ctrl@edit');
Route::patch('/profili_can/{id}', 'profilo_can_Ctrl@update');
Route::get('/profili_can/{id}/matchingofferte', 'profilo_can_Ctrl@match_offerte');
