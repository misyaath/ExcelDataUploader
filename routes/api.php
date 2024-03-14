<?php

use App\Http\Controllers\ExcelDataUploaderController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('excel-data-uploader')->group(function () {
        Route::post('/', [ExcelDataUploaderController::class, 'index']);
        Route::get('/', [ExcelDataUploaderController::class, 'statuses']);
    });

});
