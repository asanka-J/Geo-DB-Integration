<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeoDBController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/countries', [GeoDBController::class, 'getCountryList'])->name('api.country.list');
Route::get('/country', [GeoDBController::class, 'getCountryDetails'])->name('api.country.detail');

Route::get('/cities', [GeoDBController::class, 'getCitiesByCountry'])->name('api.cities.list');
Route::get('/city', [GeoDBController::class, 'getCityDetailsById'])->name('api.city.detail');
