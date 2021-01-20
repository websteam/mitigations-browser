<?php

use App\Models\Tactic;
use App\Models\Technique;
use App\Repository\Eloquent\TacticRepository;
use App\Repository\Eloquent\TechniqueRepository;
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

Route::get('tactics', function() {
    return Tactic::all();
});

Route::get('tactics/{external_id}', function($external_id, TacticRepository $repository) {
    return $repository->findByExternalId($external_id);
});

Route::get('techniques', function () {
    return Technique::all();
});

Route::get('techniques/{external_id}', function($external_id, TechniqueRepository $repository) {
    return $repository->findByExternalId($external_id);
});
