<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DepartmentController;

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
Route::controller(UserController::class)->group(function(){
Route::post('register','register');
Route::post('login','login');
Route::post('logout','logout')->middleware('auth');

});
//Department
Route::apiResource('department',DepartmentController::class);


//category
Route::apiResource('category',CategoryController::class);
//Document
Route::apiResource('document',DocumentController::class);
Route::Delete("/document/{id}",[TagController::class,'destroy']);

//Download Document file
Route::get('/download/{id}',[DocumentController::class,'Download']);

//Tag
Route::Post("/addTag/{id}",[TagController::class,'AddTag'])->middleware('auth');
Route::put("/updateTag/{id}",[TagController::class,'updateTag'])->middleware('auth');
Route::Delete("/DeleteTag/{id}",[TagController::class,'DeleteTag'])->middleware('auth');
