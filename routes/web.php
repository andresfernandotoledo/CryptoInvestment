<?php

use App\Http\Controllers\CryptoController;

Route::get('/', function () {
    return view('index');
});

Route::get('/fetch-data', [CryptoController::class, 'fetchData']);
Route::get('/chart-data', [CryptoController::class, 'getChartData'])->name('getChartData'); // Definir la ruta con nombre
Route::get('/crypto', [CryptoController::class, 'showCryptoPage'])->name('crypto.page');
Route::get('/crypto-data', [CryptoController::class, 'getChartData'])->name('getChartData');
Route::get('/crypto-list', [CryptoController::class, 'getCryptoList'])->name('getCryptoList');

