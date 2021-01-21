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
    return redirect()->route('tactics_index');
});

Route::get('tactics', '\App\Http\Controllers\TacticController@index')->name('tactics_index');
Route::get('tactics/{external_id}', '\App\Http\Controllers\TacticController@show')->name('tactics_show');

Route::get('techniques/{external_id}', '\App\Http\Controllers\TechniqueController@show')->name('techniques_show');

Route::get('search', '\App\Http\Controllers\SearchController@index')->name('search');
