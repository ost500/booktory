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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hotels', [\App\Http\Controllers\HotelController::class, 'hotels']);
Route::post('/hotels/register', [\App\Http\Controllers\HotelController::class, 'hotelRegister']);
Route::post('/hotels/{hotelId}/reservation', [\App\Http\Controllers\HotelController::class, 'reservation'])
    ->name('reservation');
Route::put('/hotels/reservations/{reservationId}/status', [\App\Http\Controllers\HotelController::class, 'reservationStatus'])
    ->name('reservation.status');
