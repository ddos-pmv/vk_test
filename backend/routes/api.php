<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Good\IndexController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\User\StoreController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
});
Route::group(['prefix' => 'users'], function () {
    Route::post('/reg', [StoreController::class, 'reg']);
});



Route::group(['middleware'=>'jwt.auth','prefix' => 'goods'], function () {
//    Route::post('/add', [IndexController::class,'add']);
//    Route::delete('/{id}', [IndexController::class,'delete']);
})->name('goods_admin_routes');



Route::group(['prefix' => 'goods'], function () {
    Route::get('/', [IndexController::class, 'all']);
//    Route::get('/category/{id}', [IndexController::class, 'category']);
    Route::get('/{good_id}/{region_id}', [IndexController::class, 'get']);
    Route::get('/price/{id}', function ($id) {
        \App\Models\Price::where(['good_id' => $id, 'region_id' => 1]);
    });
})->name('goods_user_routes');



Route::group(['middleware'=>'jwt.auth','prefix' => 'users'], function () {
    Route::get('/', [ManageController::class, 'all']);
    Route::delete('/{id}', [ManageController::class, 'delete']);
});




