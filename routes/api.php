<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeoDBSearchController;
use App\Http\Controllers\API\GeoDbAPIController;

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

Route::get('/countries', [GeoDbAPIController::class, 'getCountryList'])->name('api.country.list');
Route::get('/country', [GeoDbAPIController::class, 'getCountryDetails'])->name('api.country.detail');

Route::get('/cities', [GeoDbAPIController::class, 'getCitiesByCountry'])->name('api.cities.list');
Route::get('/city', [GeoDbAPIController::class, 'getCityDetailsById'])->name('api.city.detail');
Route::get('/city/nearby', [GeoDbAPIController::class, 'getCitiesNearByCityId'])->name('api.city.nearby');

Route::get('/country/search', [GeoDBSearchController::class, 'searchByCountry'])->name('api.country.search');
