<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\ProductController;
use  App\Http\Controllers\FirebaseAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/addproduct',[ProductController::class,'addProduct']);
Route::get('/list',[ProductController::class,'list']);
Route::get('/getproduct/{id}',[ProductController::class,'getProduct']);
Route::delete('/delete/{id}',[ProductController::class,'delete']);

Route::post('/firebase-login', [FirebaseAuthController::class, 'login']);



