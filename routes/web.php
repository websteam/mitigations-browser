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
    return view('welcome');
});

Route::get('tactics', '\App\Http\Controllers\TacticController@index');
Route::get('tactics/:external_id', '\App\Http\Controllers\TacticController@show');

Route::get('techniques', '\App\Http\Controllers\TechniqueController@index');
Route::get('techniques/:external_id', '\App\Http\Controllers\TechniqueController@show');
