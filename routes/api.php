<?php
use App\Http\Controllers\studentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'api'],function($routes){
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/profile',[AuthController::class,'profile']);
Route::post('/refresh',[AuthController::class,'refresh']);
Route::post('/logout',[AuthController::class,'logout']);
});


Route::get('/students',[studentApiController::class,'index']);
Route::get('/students/{student}',[studentApiController::class,'show']);
Route::post('/students',[studentApiController::class,'store']);
Route::put('/students/{student}',[studentApiController::class,'update']);
Route::delete('/students/{student}',[studentApiController::class,'destroy']);

