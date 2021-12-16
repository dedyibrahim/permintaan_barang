<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/SignIn',[Login::class,'SignIn']);

Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/SignOut',[Login::class,'SignOut']);
    Route::post('/SearchNik',[DashboardController::class,'SearchNik']);
    Route::get('/getBarang',[DashboardController::class,'getBarang']);
    Route::post('/ProsesPermintaan',[DashboardController::class,'ProsesPermintaan']);
    Route::get('/DataPermintaan',[DashboardController::class,'DataPermintaan']);
    Route::get('/DataKaryawan',[DashboardController::class,'DataKaryawan']);
    Route::get('/DataBarang',[DashboardController::class,'DataBarang']);
});
