<?php

use App\Http\Controllers\DHTController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\Remote\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/dht', [DHTController::class, 'dht'])->name('dht.now');
Route::middleware('api.needKey')->group(function() {
    Route::get('/pins', [PinController::class, 'getPins'])->name('pin.getAll');
    Route::put('/pins/{pin}', [PinController::class, 'updatePin'])->name('pin.update');
    
    Route::put('/dht', [DHTController::class, 'updateDHT'])->name('dht.update');
    
    Route::get('/monitor', [HomeController::class, 'monitor'])->name('monitor');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
