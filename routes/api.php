<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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
// auth register & login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // user
    Route::get('/userDetail', [AuthController::class, 'userDetail']);
    Route::put('/user/{id}', [AuthController::class, 'update']);
    
    // post
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/deletePost/{id}', [PostController::class, 'destroy']);
    
    // comment
    Route::post('/comment/{postId}', [CommentController::class, 'store']);
    Route::get('/comment/{id}', [CommentController::class, 'show']);
    Route::put('/comment/{Id}', [CommentController::class, 'update']);
    Route::delete('/deleteComment/{Id}', [CommentController::class, 'destroy']);
});